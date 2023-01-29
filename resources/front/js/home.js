

import Swiper, {
    Navigation,
    Autoplay ,
    Keyboard,
    Lazy,
} from 'swiper'

Swiper.use([
    Navigation,
    Autoplay ,
    Keyboard,
    Lazy,
]);


import 'swiper/css';


// слайдер home ПОПУЛЯРНЫЕ НОВИНКИ
new Swiper('.home-novelties-box .swiper', {

    slidesPerView: 1,
    centeredSlides: true,

    loop: true,
    loopAdditionalSlides: 5,

    keyboard: true,
    slideToClickedSlide: true,

    autoplay: {
        delay: 7000,
        disableOnInteraction: false,
    },

    lazy: {
        checkInView: true,
        loadPrevNext: true,
        loadPrevNextAmount: 5,
    },


    navigation: {
        nextEl: '.home-novelties-box .sw-next',
        prevEl: '.home-novelties-box .sw-prev',
    },

    on: {
        init: (swiper) => {
            if (swiper.autoplay.running) {
                swiper.$el[0].addEventListener('mouseenter', () => {
                    swiper.autoplay.stop()
                }, false);
                swiper.$el[0].addEventListener('mouseleave', () => {
                    swiper.autoplay.start()
                }, false);
            }
        },
        snapIndexChange: (swiper) => {
            let intEl = document.querySelector('.home-novelties-box .sw-current-int')
            if (intEl)
                intEl.innerHTML =  (swiper.realIndex + 1).toString();
        },
        slideChange: (swiper) => {
            let current = swiper.slides[swiper.activeIndex]

            let name = current.querySelector('.n-name').innerText
            let price = current.querySelector('.n-price').innerText

            document.querySelector('.home-novelties-box .prod-name').innerHTML = name
            document.querySelector('.home-novelties-box .prod-price').innerHTML = price
        },
    },
});
