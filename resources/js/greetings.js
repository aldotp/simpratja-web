function setGreeting() {
    const greeting = document.getElementById("greeting");
    const hour = new Date().getHours();

    let greetingText = "Good morning,";
    if (hour >= 12 && hour < 18) {
        greetingText = "Good afternoon,";
    } else if (hour >= 18) {
        greetingText = "Good evening,";
    }

    greeting.textContent = greetingText;
}

document.addEventListener("DOMContentLoaded", function () {
    setGreeting();
});
