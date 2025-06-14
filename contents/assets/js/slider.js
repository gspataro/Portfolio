import Swiper from "swiper";
import { Navigation } from "swiper/modules";

const swiper = new Swiper('.swiper', {
    modules: [Navigation],
    slidesPerView: 1,
    spaceBetween: window.getComputedStyle(document.body).getPropertyValue('--spacing-sm'),
    navigation: {
        prevEl: '.swiper-button-prev',
        nextEl: '.swiper-button-next'
    },
    breakpoints: {
        768: {
            slidesPerView: 2
        },
        1280: {
            slidesPerView: 3
        }
    }
});
