document.addEventListener('DOMContentLoaded', function () {
    // Navigation

    const header = document.getElementById('header');
    const main = document.getElementsByTagName('main')[0];
    const sections = main.getElementsByTagName('section');
    const navNext = document.getElementsByClassName('next-section');
    const navPrev = document.getElementsByClassName('prev-section');
    let currentSection = 0;
    let arrowKeyLock = false;

    // Setup current section based on scroll position
    currentSection = main.scrollLeft / main.offsetWidth;
    goToSection(currentSection);

    // Update current section based on scroll snap
    main.addEventListener('scroll', function () {
        currentSection = Math.round(main.scrollLeft / main.offsetWidth);
        setupSection(currentSection);
    });

    // Arrow keys navigation
    document.addEventListener('keydown', function (e) {
        if (e.code !== 'ArrowLeft' && e.code !== 'ArrowRight') {
            return;
        }

        if (arrowKeyLock) {
            return;
        }

        e.preventDefault();

        switch (e.code) {
            case 'ArrowRight':
                nextSection();
                break;
            case 'ArrowLeft':
                prevSection();
                break;
        }

        arrowKeyLock = true;
    });

    // Reset arrow keys
    document.addEventListener('keyup', function (e) {
        if (e.code !== 'ArrowLeft' && e.code !== 'ArrowRight') {
            return;
        }

        if (!arrowKeyLock) {
            return;
        }

        arrowKeyLock = false;
    });

    // Navigation
    for (let i = 0; i < navNext.length; i++) {
        navNext[i].addEventListener('click', function () {
            nextSection();
        });
    }

    for (let i = 0; i < navPrev.length; i++) {
        navPrev[i].addEventListener('click', function () {
            prevSection();
        });
    }

    // Reset position on screen resize
    window.addEventListener('resize', function () {
        goToSection(currentSection);
    });

    /**
     * Setup a section
     *
     * @param number
     * @return void
     */

    function setupSection(number)
    {
        const section = sections[number];

        if (!section) {
            return;
        }

        // Change header style based on section style
        header.dataset.style = section.dataset.style;
    }

    /**
     * Go to a specific section
     *
     * @param number
     * @return void
     */

    function goToSection(number) {
        const section = sections[number];

        if (!sections[number]) {
            return;
        }

        setupSection(number);

        section.scrollIntoView({
            behavior: 'smooth',
            inline: 'start'
        });
    }

    /**
     * Go to the next section
     *
     * @return void
     */

    function nextSection()
    {
        if (currentSection >= (sections.length - 1)) {
            return;
        }

        currentSection++;
        goToSection(currentSection);
    }

    /**
     * Go to the previous section
     *
     * @return void
     */

    function prevSection()
    {
        if (currentSection <= 0) {
            return;
        }

        currentSection--;
        goToSection(currentSection);
    }
});
