

import Swiper, {
    Navigation,
    Autoplay ,
    // Pagination,
    // Thumbs,
    Keyboard,
    EffectFade,
} from 'swiper'

import 'swiper/css';
import 'swiper/css/effect-fade';
// import 'swiper/css/navigation';
// import 'swiper/css/autoplay';


Swiper.use([
    Navigation,
    Autoplay ,
    // Pagination,
    // Thumbs,
    Keyboard,
    EffectFade,
]);



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


    navigation: {
        nextEl: '.home-novelties-box .sw-next',
        prevEl: '.home-novelties-box .sw-prev',
    },

    on: {
        init: (swiper) => {
            swiper.$el[0].addEventListener('mouseenter', () => {
                swiper.autoplay.stop()
            }, false);
            swiper.$el[0].addEventListener('mouseleave', () => {
                swiper.autoplay.start()
            }, false);
        },
        snapIndexChange: (swiper) => {
            let intEl = document.querySelector('.home-novelties-box .sw-current-int')
            if (intEl)
                intEl.innerHTML =  (swiper.realIndex + 1).toString();
        }
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


document.querySelectorAll('.catalog-item .swiper').forEach(el => {
    // слайдер home ПОПУЛЯРНЫЕ НОВИНКИ

    let parent = el.closest('.catalog-item')
    new Swiper(el, {

        slidesPerView: 1,
        loop: true,
        effect: 'fade',
        navigation: {
            nextEl: parent.querySelector('.sw-next'),
            prevEl: parent.querySelector('.sw-prev'),
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
})
