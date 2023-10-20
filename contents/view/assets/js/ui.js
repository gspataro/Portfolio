document.addEventListener('DOMContentLoaded', function () {
    // Light/dark mode

    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }

    const toggleModeElement = document.getElementsByClassName('toggle-mode')[0];

    toggleModeElement.addEventListener('click', function () {
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            localStorage.theme = 'light';
            document.documentElement.classList.remove('dark');
        } else {
            localStorage.theme = 'dark';
            document.documentElement.classList.add('dark');
        }
    });

    // Navbar

    const navbarElement = document.getElementById('navbar');
    const navbarElementToggle = navbarElement.getElementsByClassName('toggle')[0];
    const navbarElementClose = navbarElement.getElementsByClassName('close')[0];

    navbarElementToggle.addEventListener('click', function () {
        let status = navbarElement.dataset.status;

        if (status == 'open') {
            navbarElement.dataset.status = 'closed';
            document.body.style.overflowY = 'auto';
        } else {
            navbarElement.dataset.status = 'open';
            document.body.style.overflowY = 'hidden';
        }
    });

    navbarElementClose.addEventListener('click', function () {
        navbarElement.dataset.status = 'closed';
        document.body.style.overflowY = 'auto';
    });

    navbarElementClose.addEventListener('keydown', function (e) {
        if (e.code !== 'Escape') {
            return;
        }

        navbarElement.dataset.status = 'closed';
        document.body.style.overflowY = 'auto';
    });
});
