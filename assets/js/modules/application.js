import particlesConfig from "../config/particles"

window.addEventListener("scroll", () => {
    const navbar = document.querySelector(".navbar");
    const isSticky = navbar.classList.contains("is-sticky");

    if (window.scrollY > 100) {
        if (!isSticky) navbar.classList.add("is-sticky");
    } else {
        if (isSticky) navbar.classList.remove("is-sticky");
    }
});

document.addEventListener("DOMContentLoaded", () => {
    if (typeof particlesJS !== "undefined") {
        try {
            window.particlesJS("js-particles", particlesConfig);
        } catch (e) {
            console.log({e})
        }
    }

    if (typeof GitHubCalendar !== "undefined") {
        try {
            GitHubCalendar(".calendar", "bernard-ng", {
                responsive: true,
                global_stats: false
            });
        } catch (e) {
            console.error({e})
        }
    }
});
