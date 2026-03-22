const accordions = document.getElementsByClassName('accordion');

for (const accordion of accordions) {
    accordion.querySelectorAll('.item').forEach((item) => {
        item.accordion = {
            arrow: item.getElementsByClassName('arrow')[0] ?? null,
            isOpen: () => 'open' in item.dataset,
            open: () => {
                accordion.querySelectorAll('.item[data-open="open"]').forEach((target) => {
                    target.accordion.close();
                });

                item.dataset.open = 'open';
            },
            close: () => delete item.dataset.open
        }

        if (item.accordion.arrow !== null) {
            item.accordion.arrow.addEventListener('click', (e) => {
                e.preventDefault();

                if (item.accordion.isOpen()) {
                    item.accordion.close();
                    return;
                }

                item.accordion.open();
            });
        }
    });
}
