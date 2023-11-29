document.addEventListener('DOMContentLoaded', function () {
    // Navigation

    const header = document.getElementById('header');
    const main = document.getElementsByTagName('main')[0];
    const sections = main.getElementsByTagName('section');
    const navNext = document.getElementsByClassName('next-section');
    const navPrev = document.getElementsByClassName('prev-section');
    let currentSection = 0;

    // Setup current section based on scroll position
    currentSection = main.scrollLeft / main.offsetWidth;
    goToSection(currentSection);

    // Arrow keys navigation
    document.addEventListener('keydown', function (e) {
        if (!e.code === 'ArrowRight' && !e.code === 'ArrowLeft') {
            return;
        }

        switch (e.code) {
            case 'ArrowRight':
                currentSection = currentSection < (sections.length - 1) ? currentSection + 1 : currentSection;
                break;
            case 'ArrowLeft':
                currentSection = currentSection > 0 ? currentSection - 1 : currentSection;
                break;
        }

        goToSection(currentSection);
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
     * Go to a specific section
     *
     * @param number
     * @return void
     */

    function goToSection(number) {
        const section = sections[number];

        if (section.length < 1) {
            return;
        }

        // Change header style based on section style
        header.dataset.style = section.dataset.style;

        main.scrollTo({
            left: window.innerWidth * number,
            behavior: 'smooth'
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
