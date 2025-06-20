window.addEventListener('load', () => {
	registerSW();
})

async function registerSW() {
	if ('serviceWorker' in navigator) {
		try {
			await navigator.serviceWorker.register('sw.js');
			// console.log('SW Registration Done');
		}
		catch (e) {
			// console.log('SW Registration Failed ' + e);
		}
	}
}