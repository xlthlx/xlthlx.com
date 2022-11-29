window.addEventListener("load", () => {
	if (("serviceWorker" in navigator) && (location.hostname !== 'localhost')) {
		navigator.serviceWorker.register("/service-worker.js");
	}
});
