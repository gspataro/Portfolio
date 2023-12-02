document.addEventListener('DOMContentLoaded', function () {
    const main = document.getElementsByTagName('main')[0];

    // Mobile navbar functionality

    const header = document.getElementById('header');
    const navbar = document.getElementById('navbar');
    const navbarToggle = navbar.getElementsByClassName('toggle')[0];
    const navbarClose = navbar.getElementsByClassName('close')[0];
    let headerStyle;

    navbarToggle.addEventListener('click', function () {
        let status = navbar.dataset.status;

        if (status == 'open') {
            navbar.dataset.status = 'closed';
            header.dataset.style = headerStyle ?? 'default';
            document.body.style.overflowY = null;
        } else {
            navbar.dataset.status = 'open';
            headerStyle = header.dataset.style;
            header.dataset.style = 'default';
            document.body.style.overflowY = 'hidden';
        }
    });

    navbarClose.addEventListener('click', function () {
        navbar.dataset.status = 'closed';
        header.dataset.style = headerStyle ?? 'default';
        document.body.style.overflowY = null;
    });

    navbarClose.addEventListener('keydown', function (e) {
        if (e.code !== 'Escape') {
            return;
        }

        navbar.dataset.status = 'closed';
        header.dataset.style = headerStyle ?? 'default';
        document.body.style.overflowY = null;
    });

    window.addEventListener('resize', function () {
        if (navbar.dataset.status !== 'open') {
            return;
        }

        if (window.screen.width < 1024) {
            return;
        }

        navbar.dataset.status = 'closed';
        header.dataset.style = headerStyle ?? 'default';
        document.body.style.overflowY = null;
    });
});
