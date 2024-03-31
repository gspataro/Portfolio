document.addEventListener('DOMContentLoaded', function () {
    const header = document.getElementById('header');
    const navbarToggler = document.getElementById('navbar-toggle');

    navbarToggler.onclick = function () {
        if (header.dataset.open === 'false') {
            header.dataset.open = 'true';
        } else {
            header.dataset.open = 'false';
        }
    };
});
