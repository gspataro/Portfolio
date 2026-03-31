import './ui';
import './favicon';
import './slider';
import './player';
import './accordion';
import './image';

if (window.location.pathname === '/' || window.location.pathname === '/index.html') {
    import('./synth').then((module) => {
        module.initSynth();
    }).catch((error) => {
        console.error(`Failed to load synth module: ${error.message}`);
    });

    import('./homepage').then((module) => {
        module.init();
    }).catch((error) => {
        console.error(`Failed to load homepage module: ${error.message}`);
    });
}
