

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

function initCatalogSlider() {
    document.querySelectorAll('.catalog-item .swiper:not(.swiper-initialized)').forEach(el => {
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
}

initCatalogSlider();

document.addEventListener('catalogChanged', () => {
    initCatalogSlider();
})
