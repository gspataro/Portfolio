import './ui';
import './synth';
import './slider';

if (window.location.pathname === '/' || window.location.pathname === '/index.html') {
    import('./homepage').then((module) => {
        module.initHomepage();
    }).catch((error) => {
        console.error(`Failed to load homepage module: ${error.message}`);
    });
}
