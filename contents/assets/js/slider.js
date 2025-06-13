import Swiper from "swiper";
import { Navigation } from "swiper/modules";

const swiper = new Swiper('.swiper', {
    modules: [Navigation],
    slidesPerView: 3,
    spaceBetween: 30,
    navigation: {
        prevEl: '.swiper-button-prev',
        nextEl: '.swiper-button-next'
    }
});
