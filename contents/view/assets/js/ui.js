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

    const customCursor = document.createElement('div');
    customCursor.style.display = 'none';
    customCursor.classList.add('cursor');
    document.body.append(customCursor);

    document.addEventListener('mousemove', function (e) {
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
});
