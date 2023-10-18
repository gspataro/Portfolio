document.addEventListener('DOMContentLoaded', function () {
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
});
