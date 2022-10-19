document.addEventListener("DOMContentLoaded", () => {
    /**
     * Header
     */

    const header = document.getElementById("header");
    const headerPlaceholder = document.getElementById("header-placeholder");

    headerPlaceholder.style.height = header.clientHeight + "px";

    /**
     * Navbar
     */

    const navbar = document.getElementById("navbar");
    const navbarToggle = document.getElementById("navbar-toggle");
    const navbarToggleOpen = navbarToggle.getElementsByClassName("open")[0];
    const navbarToggleClose = navbarToggle.getElementsByClassName("close")[0];

    navbar.style.top = header.clientHeight + "px";

    navbarToggle.onclick = function () {
        navbarToggleOpen.classList.toggle("hidden");
        navbarToggleClose.classList.toggle("hidden");
        navbar.classList.toggle("hidden");
    }
});
