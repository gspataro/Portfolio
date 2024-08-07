document.addEventListener('DOMContentLoaded', function () {
    initHeader();

    function initHeader()
    {
        const header = document.getElementById('header');
        const navbarToggler = document.getElementById('navbar-toggle');

        if (!header || !navbarToggler) {
            return;
        }

        navbarToggler.onclick = function () {
            if (header.dataset.open === 'false') {
                header.dataset.open = 'true';
                document.body.classList.add('hamburger-open');
            } else {
                header.dataset.open = 'false';
                document.body.classList.remove('hamburger-open');
            }
        };
    }

    const customCursor = document.createElement('div');
    customCursor.style.display = 'none';
    customCursor.classList.add('cursor');
    document.body.append(customCursor);

    document.addEventListener('pointermove', function (e) {
        if (document.documentElement.clientWidth < 992) {
            return;
        }

        const xpos = e.clientX - (customCursor.clientWidth / 2);
        const ypos = e.clientY - (customCursor.clientHeight / 2);

        customCursor.style.display = 'block';

        customCursor.style.top = ypos + 'px';
        customCursor.style.left = xpos + 'px';
    });

    document.addEventListener('mouseover', function (e) {
        if (e.target.tagName.toLowerCase() !== 'a') {
            return;
        }

        customCursor.classList.add('hover');
    });

    document.addEventListener('mouseout', function (e) {
        if (e.target.tagName.toLowerCase() !== 'a') {
            return;
        }

        customCursor.classList.remove('hover');
    });

    document.addEventListener('mousedown', function () {
        customCursor.classList.add('click');
    });

    document.addEventListener('mouseup', function () {
        customCursor.classList.remove('click');
    });
});
