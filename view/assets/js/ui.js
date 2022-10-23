const header = document.getElementById("header");
let headerHeight = header.clientHeight + "px";

/**
 * Fix header placeholder height on resize
 * @return void
 */

function headerResizeEvent() {
    const headerPlaceholder = document.getElementById("header-placeholder");
    headerHeight = header.clientHeight + "px";

    headerPlaceholder.style.height = headerHeight;
}

document.addEventListener("DOMContentLoaded", () => {
    /**
     * Header
     */

    headerResizeEvent();

    /**
     * Navbar
     */

    const navbar = document.getElementById("navbar");
    const navbarToggle = document.getElementById("navbar-toggle");
    const navbarToggleOpen = navbarToggle.getElementsByClassName("open")[0];
    const navbarToggleClose = navbarToggle.getElementsByClassName("close")[0];

    navbarToggle.onclick = function () {
        document.body.style.overflow = document.body.style.overflow == "hidden" ? "auto" : "hidden";
        navbarToggleOpen.classList.toggle("hidden");
        navbarToggleClose.classList.toggle("hidden");
        navbar.classList.toggle("hidden");
        navbar.style.top = headerHeight;
    }
});

window.addEventListener("resize", headerResizeEvent);
