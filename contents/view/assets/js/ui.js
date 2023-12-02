document.addEventListener('DOMContentLoaded', function () {
    // Navbar

    const navbar = document.getElementById('navbar');
    const navbarToggle = navbar.getElementsByClassName('toggle')[0];
    const navbarClose = navbar.getElementsByClassName('close')[0];

    navbarToggle.addEventListener('click', function () {
        let status = navbar.dataset.status;

        if (status == 'open') {
            navbar.dataset.status = 'closed';
            document.body.style.overflowY = 'auto';
        } else {
            navbar.dataset.status = 'open';
            document.body.style.overflowY = 'hidden';
        }
    });

    navbarClose.addEventListener('click', function () {
        navbar.dataset.status = 'closed';
        document.body.style.overflowY = 'auto';
    });

    navbarClose.addEventListener('keydown', function (e) {
        if (e.code !== 'Escape') {
            return;
        }

        navbar.dataset.status = 'closed';
        document.body.style.overflowY = 'auto';
    });
});
