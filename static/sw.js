importScripts('https://storage.googleapis.com/workbox-cdn/releases/4.3.1/workbox-sw.js');

if (workbox) {
	workbox.routing.registerRoute(
		/.*/,
		new workbox.strategies.StaleWhileRevalidate()
	);
	console.info("Ready");
} else {
	console.warn("Error: Workbox didn't load");
}