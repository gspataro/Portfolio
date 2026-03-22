import { animate } from 'motion';

const accordions = document.getElementsByClassName('accordion');

for (const accordion of accordions) {
    accordion.querySelectorAll('.accordion-item').forEach((item) => {
        if (!item.getElementsByClassName('accordion-arrow')[0]) {
            console.error(
                `Item is missing accordion-arrow`,
                item
            );
            return;
        }

        if (!item.getElementsByClassName('accordion-content')[0]) {
            console.error(
                `Item is missing accordion-content`,
                item
            );
            return;
        }

        const arrow = item.getElementsByClassName('accordion-arrow')[0];
        const content = item.getElementsByClassName('accordion-content')[0];

        item.accordion = {
            arrow: arrow,
            content: content,
            contentHeight: content.scrollHeight,
            isOpen: () => 'open' in item.dataset,
            open: () => {
                accordion.querySelectorAll('.accordion-item[data-open="open"]').forEach((target) => {
                    target.accordion.close();
                });

                animate(item.accordion.arrow, {
                    rotate: -180
                }, {
                    duration: 0.25,
                    easing: 'ease-in-out'
                });

                animate(item.accordion.content, {
                    height: [0, `${item.accordion.contentHeight}px`]
                }, {
                    duration: 0.25,
                    easing: 'ease-in-out'
                });

                item.dataset.open = 'open';
            },
            close: () => {
                animate(item.accordion.arrow, {
                    rotate: 0
                }, {
                    duration: 0.25,
                    easing: 'ease-in-out'
                });

                animate(item.accordion.content, {
                    height: [`${item.accordion.contentHeight}px`, 0]
                }, {
                    duration: 0.25,
                    easing: 'ease-in-out'
                });

                delete item.dataset.open
            },
            toggle: () => item.accordion.isOpen() ? item.accordion.close() : item.accordion.open()
        }

        window.addEventListener('resize', () => {
            item.accordion.content.style.height = 'auto';
            item.accordion.contentHeight = content.scrollHeight;

            if (item.accordion.isOpen()) {
                item.accordion.content.style.height = `${item.accordion.contentHeight}px`;
            }
        });

        accordion.addEventListener('click', (e) => {
            const toggle = e.target.closest('.accordion-toggle');

            if (!toggle) {
                return;
            }

            toggle.closest('.accordion-item').accordion.toggle();
        });

        item.accordion.arrow.addEventListener('click', (e) => {
            e.preventDefault();
            item.accordion.toggle();
        });
    });
}
