'use strict';
// Change the cache version when deploying new app assets.
const CACHE_NAME = 'it-student-hub-v6';
const OFFLINE_URL = '/offline.html';
const PAGES = ['/', '/directory', '/courses', '/admissions', '/contact'];
const STATIC_PREFIXES = ['/build/assets/', '/images/'];
// Save the offline fallback and app icons.
self.addEventListener('install', (event) => {
    event.waitUntil(caches.open(CACHE_NAME).then((cache) => cache.addAll([
        OFFLINE_URL, '/manifest.json', '/images/ucc-student-hub-icon-192x192.png', '/images/ucc-student-hub-icon-512x512.png',
    ])));
});
// Remove older app caches without touching other apps.
self.addEventListener('activate', (event) => {
    event.waitUntil((async () => {
        const keys = await caches.keys();
        await Promise.all(keys.filter((key) => key.startsWith('it-student-hub-') && key !== CACHE_NAME).map((key) => caches.delete(key)));
        await self.clients.claim();
    })());
});
// Save allowed local files requested by the page.
self.addEventListener('message', (event) => {
    if (event.data?.type !== 'CACHE_ASSETS' || !Array.isArray(event.data.urls)) return;
    event.waitUntil((async () => {
        const cache = await caches.open(CACHE_NAME);
        const urls = event.data.urls.slice(0, 40).filter((value) => {
            try {
                const url = new URL(value, self.location.origin);
                return url.origin === self.location.origin && !url.search && (
                    STATIC_PREFIXES.some((prefix) => url.pathname.startsWith(prefix)) || PAGES.includes(url.pathname)
                );
            } catch { return false; }
        });
        await Promise.allSettled(urls.map((url) => cache.add(url)));
    })());
});
// Serve saved public pages when the network is unavailable.
self.addEventListener('fetch', (event) => {
    const url = new URL(event.request.url);
    if (event.request.method !== 'GET' || url.origin !== self.location.origin) return;
    const isPage = event.request.mode === 'navigate' && PAGES.includes(url.pathname) && !url.search;
    const isAsset = STATIC_PREFIXES.some((prefix) => url.pathname.startsWith(prefix));
    if (!isPage && !isAsset) {
        if (event.request.mode === 'navigate') event.respondWith(fetch(event.request).catch(() => caches.match(OFFLINE_URL)));
        return;
    }
    event.respondWith((async () => {
        const cache = await caches.open(CACHE_NAME);
        if (isAsset) {
            const cached = await cache.match(event.request);
            if (cached) return cached;
        }
        try {
            const response = await fetch(event.request);
            if (response.ok && response.type === 'basic') await cache.put(event.request, response.clone());
            return response;
        } catch {
            return (await cache.match(event.request)) || (isPage ? await cache.match(OFFLINE_URL) : Response.error());
        }
    })());
});
