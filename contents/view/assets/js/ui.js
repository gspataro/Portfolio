document.addEventListener('DOMContentLoaded', function () {
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

    // Homepage header

    if (document.body.classList.contains('homepage')) {
        const header = document.getElementById('header');
        const logo = header.getElementsByClassName('logo')[0];

        window.addEventListener('scroll', function () {
            let scrollPosition = document.documentElement.scrollTop;

            if (scrollPosition > 100) {
                header.classList.add('bg-thunder-darkest');
                logo.src = 'http://gspataro.test/assets/images/logo-light.svg';
            } else {
                header.classList.remove('bg-thunder-darkest');
                logo.src = 'http://gspataro.test/assets/images/logo.svg';
            }
        });
    }
});
