

import Swiper, {
    Navigation,
    EffectFade,
    Lazy,
} from 'swiper'

Swiper.use([
    Navigation,
    EffectFade,
    EffectFade,
    Lazy,
]);


import 'swiper/css';
import 'swiper/css/effect-fade';



// слайдер картинок в товаре
document.querySelectorAll('.catalog-item .swiper').forEach(el => {
    let parent = el.closest('.catalog-item')
    new Swiper(el, {

        slidesPerView: 1,
        loop: true,
        effect: 'fade',

        lazy: {
            checkInView: true,
            loadPrevNext: true,
        },

        navigation: {
            nextEl: parent.querySelector('.sw-next'),
            prevEl: parent.querySelector('.sw-prev'),
        },
    });
})
