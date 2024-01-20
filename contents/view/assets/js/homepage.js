document.addEventListener('DOMContentLoaded', function () {
    const header = document.getElementById('header');
    const main = document.getElementById('main');
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
        if (!section) {
            return;
        }

        const sectionStyle = section.dataset.style ?? 'pianoforte';

        // Update header style based on section
        header.dataset.style = sectionStyle;
    }

    /**
     * Go to a section
     *
     * @param int id
     * @return void
     */

    function goToSection(id)
    {
        const section = sections[id] ?? null;

        if (!section) {
            return;
        }

        setupSection(section);
        section.scrollIntoView({
            'behavior': 'smooth'
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

    currentSectionId = main.scrollLeft / main.offsetWidth;
    setupSection(sections[currentSectionId]);

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
