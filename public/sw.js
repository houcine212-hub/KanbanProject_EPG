/* ════════════════════════════════════════════
   EPG Kanban — Service Worker
   public/sw.js
   ════════════════════════════════════════════ */

const CACHE_NAME    = 'epg-kanban-v1';
const OFFLINE_URL   = '/offline';

/* ── Assets à mettre en cache au démarrage ── */
const PRECACHE = [
    '/',
    '/kanban',
    '/offline',
    '/manifest.json',
    '/images/epg-logo.jpg',
    '/icons/icon-192x192.png',
    '/icons/icon-512x512.png',
    'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap',
    'https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js',
];

/* ══════════════════════════════════════════
   INSTALL — Précache des assets statiques
══════════════════════════════════════════ */
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => cache.addAll(PRECACHE))
            .then(() => self.skipWaiting())
    );
});

/* ══════════════════════════════════════════
   ACTIVATE — Nettoyage ancien cache
══════════════════════════════════════════ */
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(keys =>
            Promise.all(
                keys
                    .filter(key => key !== CACHE_NAME)
                    .map(key => caches.delete(key))
            )
        ).then(() => self.clients.claim())
    );
});

/* ══════════════════════════════════════════
   FETCH — Stratégie de cache
══════════════════════════════════════════ */
self.addEventListener('fetch', event => {
    const { request } = event;
    const url = new URL(request.url);

    /* ── Ignorer: POST, API calls, WebSocket ── */
    if (request.method !== 'GET') return;
    if (url.pathname.startsWith('/api/')) return;
    if (url.pathname.startsWith('/kanban/ai-chat')) return;

    /* ── Fonts Google: Cache First ── */
    if (url.hostname === 'fonts.googleapis.com' || url.hostname === 'fonts.gstatic.com') {
        event.respondWith(cacheFirst(request));
        return;
    }

    /* ── CDN (SortableJS etc): Cache First ── */
    if (url.hostname === 'cdn.jsdelivr.net') {
        event.respondWith(cacheFirst(request));
        return;
    }

    /* ── Assets statiques (images, icons): Cache First ── */
    if (url.pathname.match(/\.(png|jpg|jpeg|svg|gif|ico|webp|woff2?)$/)) {
        event.respondWith(cacheFirst(request));
        return;
    }

    /* ── Pages Laravel: Network First (données fraîches) ── */
    if (url.hostname === self.location.hostname) {
        event.respondWith(networkFirst(request));
        return;
    }
});

/* ══════════════════════════════════════════
   Stratégies
══════════════════════════════════════════ */

/** Cache First: pour assets statiques */
async function cacheFirst(request) {
    const cached = await caches.match(request);
    if (cached) return cached;
    try {
        const response = await fetch(request);
        if (response.ok) {
            const cache = await caches.open(CACHE_NAME);
            cache.put(request, response.clone());
        }
        return response;
    } catch {
        return new Response('', { status: 408 });
    }
}

/** Network First: pour pages dynamiques */
async function networkFirst(request) {
    try {
        const response = await fetch(request);
        if (response.ok) {
            const cache = await caches.open(CACHE_NAME);
            cache.put(request, response.clone());
        }
        return response;
    } catch {
        const cached = await caches.match(request);
        if (cached) return cached;

        /* Page offline de fallback */
        if (request.destination === 'document') {
            return caches.match(OFFLINE_URL);
        }
        return new Response('', { status: 408 });
    }
}
