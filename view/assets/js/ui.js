let navbar = document.getElementById("navbar");
let navbarOverlay = navbar.getElementsByClassName("overlay")[0];

function uiOpenNavbar()
{
    navbar.classList.remove("hidden");
    navbarOverlay.classList.remove("hidden");
}

function uiCloseNavbar()
{
    navbar.classList.add("hidden");
    navbarOverlay.classList.remove("hidden");
}
