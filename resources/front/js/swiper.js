

import Swiper, {
    Navigation,
    Autoplay ,
    Thumbs,
    Keyboard,
    EffectFade,
    Scrollbar,
    Mousewheel,
} from 'swiper'

Swiper.use([
    Navigation,
    Autoplay ,
    Thumbs,
    Keyboard,
    EffectFade,
    Scrollbar,
    Mousewheel,
]);


import 'swiper/css';
import 'swiper/css/effect-fade';
import 'swiper/css/scrollbar';
// import 'swiper/css/autoplay';


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

    autoplay: false,


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
            let price = current.querySelector('.n-price-value').innerText

            document.querySelector('.home-novelties-box .prod-name').innerHTML = name
            document.querySelector('.home-novelties-box .prod-price-value').innerHTML = price
        },
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



// product-gallery
document.querySelectorAll('.product-box .gallery-col').forEach(el => {

    // слайдер товары
    let thumbContainer = el.querySelector('.thumbs-row .swiper');

    let galleryThumbs = new Swiper(thumbContainer, {
        spaceBetween: 6,
        slidesPerView: 5,
        scrollbar: false,
        mousewheel: true,
        scrollbar: {
            el: ".swiper-scrollbar",
            hide: false,
            draggable: true,
        },
        on: {
            init: (swiper) => {
                if (swiper.slides.length < 2) {
                    el.querySelector('.full-row').classList.add('hidden');
                }
            },
        },
        breakpoints: {
            // 576: {
            // },
            // 768: {
            // },
            992: {
                spaceBetween: 10,
                slidesPerView: 'auto',
                direction: 'vertical',
            },
        }
    });


    let topContainer = el.querySelector('.full-row .swiper')

    new Swiper(topContainer, {
        spaceBetween: 15,
        loop: true,
        effect: 'fade',
        navigation: {
            nextEl: el.querySelector('.sw-next'),
            prevEl: el.querySelector('.sw-prev'),
        },
        thumbs: {
            swiper: galleryThumbs,
        },
    });

    if (topContainer) {
        topContainer.querySelectorAll('.zoom-image').forEach(el => {
            el.addEventListener('mousemove', zoom)
        })
    }
});


function zoom(e){
    let zoomer = e.currentTarget;
	let offsetX, offsetY;

    e.offsetX ? (offsetX = e.offsetX) : (offsetX = e.touches[0].pageX);
    e.offsetY ? (offsetY = e.offsetY) : (offsetX = e.touches[0].pageX);

    let x = offsetX / zoomer.offsetWidth  * 100;
    let y = offsetY / zoomer.offsetHeight * 100;

    zoomer.style.backgroundPosition = x + "% " + y +"%";
}
