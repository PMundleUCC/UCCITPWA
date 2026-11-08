import { test } from 'node:test';
import assert from 'node:assert/strict';
import { readFileSync } from 'node:fs';
import vm from 'node:vm';

const source = readFileSync(new URL('../public/sw.js', import.meta.url), 'utf8');
const origin = 'https://campus.example';

function worker() {
    const events = {};
    const stores = new Map();
    let online = true;
    let status = 200;
    let requests = 0;
    const key = (request) => new URL(typeof request === 'string' ? request : request.url, origin).href;
    const fetch = async (request) => {
        requests++;
        if (!online) throw new TypeError('Offline');
        const response = new Response(`page:${key(request)}`, { status });
        Object.defineProperty(response, 'type', { value: 'basic' });
        return response;
    };
    const caches = {
        async open(name) {
            if (!stores.has(name)) stores.set(name, new Map());
            const store = stores.get(name);
            return {
                async match(request) { return store.get(key(request))?.clone(); },
                async put(request, response) { store.set(key(request), response.clone()); },
                async add(request) {
                    const response = await fetch(request);
                    if (!response.ok) throw new Error('Uncacheable response');
                    store.set(key(request), response);
                },
                async addAll(urls) { await Promise.all(urls.map((url) => this.add(url))); },
            };
        },
        async match(request) {
            for (const store of stores.values()) {
                if (store.has(key(request))) return store.get(key(request)).clone();
            }
        },
        async keys() { return [...stores.keys()]; },
        async delete(name) { return stores.delete(name); },
    };
    vm.runInNewContext(source, {
        self: { location: { origin }, clients: { claim: async () => {} }, addEventListener: (name, fn) => { events[name] = fn; } },
        caches, fetch, URL, Response,
    });
    return {
        stores, caches,
        offline() { online = false; },
        fail() { status = 503; },
        requestCount() { return requests; },
        async dispatch(name, data = {}) {
            let pending;
            events[name]({ ...data, waitUntil(value) { pending = value; }, respondWith(value) { pending = value; } });
            return pending;
        },
        async visit(path, method = 'GET', mode = 'navigate') {
            return this.dispatch('fetch', { request: { url: new URL(path, origin).href, method, mode } });
        },
    };
}

test('a visited public page remains available offline; new pages use fallback', async () => {
    const app = worker();
    await app.dispatch('install');
    assert.equal((await app.visit('/courses')).status, 200);
    app.offline();
    assert.equal(await (await app.visit('/courses')).text(), `page:${origin}/courses`);
    assert.equal(await (await app.visit('/directory')).text(), `page:${origin}/offline.html`);
    assert.equal(await (await app.visit('/unvisited')).text(), `page:${origin}/offline.html`);
});

test('server errors are returned without overwriting a saved successful page', async () => {
    const app = worker();
    await app.visit('/courses');
    app.fail();
    assert.equal((await app.visit('/courses')).status, 503);
    app.offline();
    assert.equal((await app.visit('/courses')).status, 200);
});

test('writes, external requests, and private resources are not intercepted', async () => {
    const app = worker();
    assert.equal(await app.visit('/courses', 'POST'), undefined);
    assert.equal(await app.visit('https://external.example/feed'), undefined);
    assert.equal(await app.visit('/account', 'GET', 'cors'), undefined);
    assert.equal(app.requestCount(), 0);
});

test('first-load messages save public pages and assets but reject private and external URLs', async () => {
    const app = worker();
    await app.dispatch('message', { data: { type: 'CACHE_ASSETS', urls: [
        `${origin}/`, `${origin}/build/assets/ucc-student-hub.js`, `${origin}/account`, 'https://external.example/image.jpg', `${origin}/courses?secret=1`,
    ] } });
    assert.equal(app.requestCount(), 2);
    app.offline();
    assert.equal(await (await app.visit('/')).text(), `page:${origin}/`);
    assert.equal(await (await app.visit('/build/assets/ucc-student-hub.js', 'GET', 'cors')).text(), `page:${origin}/build/assets/ucc-student-hub.js`);
});

test('activation deletes only older caches belonging to this application', async () => {
    const app = worker();
    await app.caches.open('it-student-hub-old');
    await app.caches.open('other-application');
    await app.dispatch('install');
    await app.dispatch('activate');
    assert.deepEqual(await app.caches.keys(), ['other-application', 'it-student-hub-v6']);
});

test('manifest icons exist and have the declared PNG dimensions', () => {
    const manifest = JSON.parse(readFileSync(new URL('../public/manifest.json', import.meta.url), 'utf8'));
    assert.equal(manifest.display, 'standalone');
    assert.equal(manifest.start_url, '/');
    for (const icon of manifest.icons) {
        const image = readFileSync(new URL(`../public${icon.src}`, import.meta.url));
        assert.equal(image.subarray(1, 4).toString(), 'PNG');
        assert.equal(`${image.readUInt32BE(16)}x${image.readUInt32BE(20)}`, icon.sizes);
    }
});
