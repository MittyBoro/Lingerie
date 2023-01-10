

import Swiper, {Navigation, Autoplay , Pagination, Thumbs, EffectFade, } from 'swiper'
Swiper.use([Navigation, Autoplay, Pagination, Thumbs, EffectFade, ]);



// слайдер 4 товара в каталоге
let catalogSlider = new Swiper('.catalog-list .swiper-container', {
    slidesPerView: 2,
    spaceBetween: 20,
    loop: true,
    enabled: true,
    loopAdditionalSlides: 3,
    speed: 750,
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
    },
    pagination: {
        el: '.catalog-list .swiper-pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.catalog-list .swiper-button-next',
        prevEl: '.catalog-list .swiper-button-prev',
    },
    // breakpoints: {
    //     576: {
    //     },
    //     768: {
    //         spaceBetween: 30,
    //         slidesPerView: 3,
    //     },
    //     992: {
    //         enabled: false,
    //         spaceBetween: 45,
    //         autoplay: false,
    //         enabled: false,
    //         loop: false,
    //         slidesPerView: 4,
    //     },
    //     1250: {
    //         enabled: false,
    //         spaceBetween: 60,
    //         slidesPerView: 4,
    //     }
    // }
});
