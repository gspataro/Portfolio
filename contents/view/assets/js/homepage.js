document.addEventListener('DOMContentLoaded', function () {
    const header = document.getElementById('header');
    const mainWrapper = document.getElementById('main-wrapper');
    const main = document.getElementById('main');
    const footer = document.getElementById('footer');
    const sections = main.getElementsByTagName('section');
    const navigationPrev = main.getElementsByClassName('nav-prev');
    const navigationNext = main.getElementsByClassName('nav-next');
    let currentSectionId = 0;

    /**
     * Setup DOM based on section informations
     *
     * @param DOMElement section
     * @return void
     */

    function setupSection(section)
    {
        if (window.innerWidth < 768) {
            mainWrapper.style.height = '';
            return;
        }

        if (!section) {
            return;
        }

        const sectionStyle = section.dataset.style ?? 'pianoforte';

        // Update header and footer styles based on section
        header.dataset.style = sectionStyle;
        footer.dataset.style = sectionStyle;

        // Main section height
        mainWrapper.style.height = section.offsetHeight + 'px';
    }

    /**
     * Go to a section
     *
     * @param int id
     * @return void
     */

    function goToSection(id)
    {
        if (window.innerWidth < 768) {
            return;
        }

        const section = sections[id] ?? null;

        if (!section) {
            return;
        }

        setupSection(section);

        const sectionXCoords = section.offsetLeft;
        main.scroll({
            top: 0,
            left: sectionXCoords,
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
        const nextSection = currentSectionId + 1;

        if (nextSection > sections.length) {
            return;
        }

        goToSection(nextSection);
    }

    /**
     * Go to the previous section
     *
     * @return void
     */

    function prevSection()
    {
        const prevSection = currentSectionId - 1;

        if (prevSection < 0) {
            return;
        }

        goToSection(prevSection);
    }

    if (window.innerWidth >= 768) {
        currentSectionId = main.scrollLeft / main.offsetWidth;
        setupSection(sections[currentSectionId]);
    }

    // Redo section setup on window resize
    window.addEventListener('resize', function () {
        currentSectionId = main.scrollLeft / main.offsetWidth;
        setupSection(sections[currentSectionId]);
    });

    // Determine current section based on scroll snap
    main.addEventListener('scroll', function () {
        currentSectionId = Math.round(main.scrollLeft / main.offsetWidth);
        setupSection(sections[currentSectionId]);
    });

    // Apply functionality to prev/next navigation
    for (const element of navigationPrev) {
        element.addEventListener('click', prevSection);
    }

    for (const element of navigationNext) {
        element.addEventListener('click', nextSection);
    }

    // Add arrow keys navigation functionality
    window.addEventListener('keydown', function (e) {
        if (e.key !== 'ArrowRight' && e.key !== 'ArrowLeft') {
            return;
        }

        if (e.repeat) {
            return;
        }

        e.preventDefault();

        if (e.key == 'ArrowRight') {
            nextSection();
        }

        if (e.key == 'ArrowLeft') {
            prevSection();
        }
    });
});
