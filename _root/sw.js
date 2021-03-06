var swsource = "/service-worker.js";
if ("serviceWorker" in navigator) {
	navigator.serviceWorker.register(swsource).then(function (reg) {
		console.log('ServiceWorker scope: ', reg.scope);
	}).catch(function (err) {
		console.log('ServiceWorker registration failed: ', err);
	});
}
