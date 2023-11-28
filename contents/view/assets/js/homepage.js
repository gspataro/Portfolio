document.addEventListener('DOMContentLoaded', function () {
    // Navigation

    const main = document.getElementsByTagName('main')[0];
    const sections = main.getElementsByTagName('section');
    let currentSection = 0;

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

    function goToSection(number) {
        main.scrollTo({
            left: window.innerWidth * number,
            behavior: 'smooth'
        });
    }
});
