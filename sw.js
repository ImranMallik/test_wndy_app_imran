
const cacheName = "WNDY";

// const staticAssets = [
// 	'./',
// 	'./pwa-js/index.js',
// 	'./manifest.webmanifest'
// ];

// INSTALL
self.addEventListener('install', async e => {
  const cache = await caches.open(cacheName);
  // await cache.addAll(staticAssets);
  return self.skipWaiting();
})

self.addEventListener('activate', e => {
  self.clients.claim();
})

self.addEventListener('fetch', async e => {
  const req = e.request;
  const url = new URL(req.url);

  if (e.request.url.search("www.facebook.com") != -1 || 
      e.request.url.search("connect.facebook.net") != -1 || 
      e.request.url.search("www.googletagmanager.com") != -1 || 
      e.request.url.search("translate.googleapis.com") != -1 || 
      e.request.url.search("translate-pa.googleapis.com") != -1 ||
      e.request.url.search("analytics.google.com") != -1) {
    // FB Pixel & Googole
  } else {

    if (url.origin === location.origin) {
      e.respondWith(cacheFirst(req));
    } else {
      e.respondWith(networkAndCache(req));
    }

  }

})

async function cacheFirst(req) {
  const cache = await caches.open(cacheName);
  const cached = await cache.match(req);
  return cached || fetch(req);
}

async function networkAndCache(req) {
  const cache = await caches.open(cacheName);
  try {
    const fresh = await fetch(req);
    await cache.put(req, fresh.clone());
    return fresh;
  } catch (e) {
    const cached = await cache.match(req);
    return cached;
  }
}