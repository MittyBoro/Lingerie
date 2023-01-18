

import Swiper, {
    Navigation,
    Autoplay ,
    Thumbs,
    EffectFade,
} from 'swiper'

Swiper.use([
    Navigation,
    Autoplay ,
    Thumbs,
    EffectFade,
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
        navigation: {
            nextEl: parent.querySelector('.sw-next'),
            prevEl: parent.querySelector('.sw-prev'),
        },
    });
})
