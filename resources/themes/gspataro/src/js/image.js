document.querySelectorAll('img[loading=lazy]').forEach(img => {
    if (img.complete) {
        img.dataset.loaded = 'loaded';
    } else {
        img.addEventListener('load', () => img.dataset.loaded = 'loaded');
    }
});
