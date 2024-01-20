document.addEventListener('DOMContentLoaded', function () {
    const keyboard = document.getElementById('keyboard');
    const keys = keyboard.getElementsByClassName('key');

    const audioContext = new AudioContext();
    const oscList = [];

    // Setup gain node
    const mainGainNode = audioContext.createGain();
    mainGainNode.connect(audioContext.destination);
    mainGainNode.gain.value = 50;

    // Prepare wave form
    const sineTerms = new Float32Array([0, 1, 1, 0, 0]);
    const cosineTerms = new Float32Array(sineTerms.length);
    const waveForm = audioContext.createPeriodicWave(cosineTerms, sineTerms);

    /**
     * Play a tone
     *
     * @param frequency
     * @return void
     */

    function playTone(frequency)
    {
        const oscillator = audioContext.createOscillator();
        oscillator.connect(mainGainNode);

        oscillator.setPeriodicWave(waveForm);
        oscillator.frequency.value = frequency;
        oscillator.start();

        return oscillator;
    }

    /**
     * Note pressed
     *
     * @param e
     * @return void
     */

    function pressNote(e)
    {
        if (e.buttons & 1) {
            if (!e.target.dataset.pressed) {
                e.stopPropagation();
                oscList[e.target.dataset['name']] = playTone(e.target.dataset.frequency);
                e.target.dataset.pressed = true;
            }
        }
    }

    /**
     * Note realeased
     *
     * @param e
     * @return void
     */

    function releaseNote(e)
    {
        if (e.target.dataset && e.target.dataset.pressed) {
            if (oscList[e.target.dataset['name']]) {
                oscList[e.target.dataset['name']].stop();
                delete oscList[e.target.dataset['name']];
                delete e.target.dataset.pressed;
            }
        }
    }

    for (let i = 0; i < 9; i++) {
        oscList[i] = {};
    }

    for (const key of keys) {
        key.addEventListener('mousedown', pressNote, false);
        key.addEventListener('mouseup', releaseNote, false);
        key.addEventListener('mouseover', pressNote, false);
        key.addEventListener('mouseleave', releaseNote, false);
    }
});
