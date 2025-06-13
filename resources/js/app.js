import Alpine from "alpinejs";
import "./bootstrap";

window.Alpine = Alpine;

Alpine.start();

document.addEventListener("DOMContentLoaded", function () {
    const lightSwitches = document.querySelectorAll(".light-switch");
    const test = localStorage.getItem("dark-mode");
    if (localStorage.getItem("dark-mode") === "true") {
        document.querySelector("html").classList.add("dark");
    } else {
        document.querySelector("html").classList.remove("dark");
    }
    if (lightSwitches.length > 0) {
        lightSwitches.forEach((lightSwitch, i) => {
            lightSwitch.addEventListener("change", () => {
                const { checked } = lightSwitch;
                lightSwitches.forEach((el, n) => {
                    if (n !== i) {
                        el.checked = checked;
                    }
                });
                document.documentElement.classList.add("**:transition-none!");
                if (lightSwitch.checked) {
                    document.documentElement.classList.add("dark");
                    document.querySelector("html").classList.add("dark");
                    localStorage.setItem("dark-mode", true);
                    document.dispatchEvent(
                        new CustomEvent("darkMode", { detail: { mode: "on" } })
                    );
                } else {
                    document.documentElement.classList.remove("dark");
                    document.querySelector("html").style.colorScheme = "light";
                    localStorage.setItem("dark-mode", false);
                    document.dispatchEvent(
                        new CustomEvent("darkMode", { detail: { mode: "off" } })
                    );
                }
                setTimeout(() => {
                    document.documentElement.classList.remove(
                        "**:transition-none!"
                    );
                }, 1);
            });
        });
    }
});


