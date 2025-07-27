export function init() {
    const mainWrapper = document.getElementById('main-wrapper');
    const main = document.getElementById('main');
    const sections = main.getElementsByTagName('section');
    const navigationPrev = main.getElementsByClassName('nav-prev');
    const navigationNext = main.getElementsByClassName('nav-next');
    let currentSectionId = 0;

    /**
     * Setup DOM based on section informations
     *
     * @param int id
     * @return void
     */

    function setupSection(id)
    {
        if (!sections[id]) {
            return;
        }

        document.body.dataset.style = id % 2 ? 'fortepiano' : 'pianoforte';

        // Main section height
        mainWrapper.style.height = (sections[id].offsetHeight - 0.5) + 'px';
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

        const sectionXCoords = section.offsetLeft;
        main.scroll({
            top: 0,
            left: sectionXCoords,
            behavior: 'smooth'
        });

        if (window.scrollY > 0) {
            window.scroll({
                top: 0,
                behavior: 'smooth'
            });
        }
    }

    /**
     * Go to the next section
     *
     * @return void
     */

    function nextSection(e)
    {
        e.preventDefault();

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

    function prevSection(e)
    {
        e.preventDefault();

        const prevSection = currentSectionId - 1;

        if (prevSection < 0) {
            return;
        }

        goToSection(prevSection);
    }

    if (window.location.hash) {
        let hash = window.location.hash.replace('#', '');
        let hashSection = document.getElementById(hash);

        if (hashSection.length) {
            main.scrollTo({
                left: hashSection.scrollLeft,
                behavior: 'smooth'
            });
        }
    }

    currentSectionId = main.scrollLeft / main.offsetWidth;
    setupSection(currentSectionId);

    // Redo section setup on window resize
    window.addEventListener('resize', function () {
        currentSectionId = main.scrollLeft / main.offsetWidth;
        setupSection(currentSectionId);
    });

    // Determine current section based on scroll snap
    main.addEventListener('scroll', function () {
        currentSectionId = Math.round(main.scrollLeft / main.offsetWidth);
        setupSection(currentSectionId);
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
            nextSection(e);
        }

        if (e.key == 'ArrowLeft') {
            prevSection(e);
        }
    });

    // Hero piano
    const welcome = document.getElementById('hero-welcome');
    const keyboard = document.getElementById('hero-keyboard');
    const playPianoCta = document.getElementById('hero-welcome-play');
    const closePianoCta = document.getElementById('hero-keyboard-close');
    const muteControl = document.getElementById('keyboard-mute');

    playPianoCta.addEventListener('click', function (e) {
        e.preventDefault();

        welcome.classList.add('hidden');
        keyboard.dataset.hidden = 'false';

        if (muteControl.dataset.muted === 'true') {
            muteControl.click();
        }
    });

    closePianoCta.addEventListener('click', function (e) {
        e.preventDefault();

        keyboard.dataset.hidden = 'true';
        welcome.classList.remove('hidden');

        if (muteControl.dataset.muted === 'false') {
            muteControl.click();
        }
    });
};
