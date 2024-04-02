document.addEventListener('DOMContentLoaded', function () {
    const header = document.getElementById('header');
    const navbarToggler = document.getElementById('navbar-toggle');

    navbarToggler.onclick = function () {
        if (header.dataset.open === 'false') {
            header.dataset.open = 'true';
            document.body.classList.add('hamburger-open');
        } else {
            header.dataset.open = 'false';
            document.body.classList.remove('hamburger-open');
        }
    };
});
