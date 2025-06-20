
let installPrompt = null;

window.addEventListener("beforeinstallprompt", (event) => {
    event.preventDefault();
    installPrompt = event;
    _(".header-install-bar").style.display = "block";
});

_(".app-install-btn").addEventListener("click", async () => {
    if (!installPrompt) {
        return;
    }
    const result = await installPrompt.prompt();
    // console.log(`Install prompt was: ${result.outcome}`);
    disableInAppInstallPrompt();
});

function disableInAppInstallPrompt() {
    installPrompt = null;
    _(".header-install-bar").style.display = "none";
}

window.addEventListener("appinstalled", () => {
    disableInAppInstallPrompt();
});
