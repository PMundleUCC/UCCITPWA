// Search and filter the staff and course cards.
document.querySelectorAll('[data-ucc-filter-list]').forEach((list) => {
    const search = list.querySelector('[data-ucc-search]');
    const level = list.querySelector('select[data-ucc-course-year]');
    const items = [...list.querySelectorAll('[data-ucc-filter-card]')];
    const update = () => {
        const query = search.value.trim().toLocaleLowerCase();
        let visible = 0;
        items.forEach((item) => {
            const matches = item.dataset.uccSearchText.toLocaleLowerCase().includes(query)
                && (!level?.value || item.dataset.uccCourseYear === level.value);
            item.hidden = !matches;
            if (matches) visible++;
        });
        list.querySelector('[data-ucc-result-count]').textContent = `${visible} of ${items.length} ${level ? 'courses' : 'team members'}`;
        list.querySelector('[data-ucc-empty-results]').hidden = visible > 0;
    };
    search.addEventListener('input', update);
    level?.addEventListener('change', update);
    list.querySelector('[data-ucc-reset-filters]').addEventListener('click', () => {
        search.value = '';
        if (level) level.value = '';
        update();
        search.focus();
    });
    update();
});

// Offer installation when the browser supports it.
let installPrompt;
const installButton = document.querySelector('[data-ucc-install-button]');
window.addEventListener('beforeinstallprompt', (event) => {
    event.preventDefault();
    installPrompt = event;
});
installButton?.addEventListener('click', async () => {
    if (installPrompt) {
        try {
            await installPrompt.prompt();
            await installPrompt.userChoice;
        } finally {
            installPrompt = null;
        }
    } else {
        document.querySelector('[data-ucc-install-help]').hidden = false;
    }
});
function markInstalled() {
    if (installButton) {
        installButton.textContent = 'Installed on this device';
        installButton.disabled = true;
        document.querySelector('[data-ucc-install-help]').hidden = true;
    }
}
window.addEventListener('appinstalled', markInstalled);
if (window.matchMedia('(display-mode: standalone)').matches || navigator.standalone) markInstalled();

// Ask the service worker to save this page and its assets.
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.ready.then((registration) => {
        const assets = [...document.querySelectorAll('link[rel="stylesheet"], script[src], img[src]')]
            .map((element) => element.href || element.src)
            .filter((url) => new URL(url).origin === location.origin);
        registration.active?.postMessage({ type: 'CACHE_ASSETS', urls: [...assets, location.href] });
    }).catch(() => {});
}
