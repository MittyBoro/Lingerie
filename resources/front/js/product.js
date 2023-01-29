
import './vue/Product';

import lightGallery from 'lightgallery';

import lgThumbnail from 'lightgallery/plugins/thumbnail'
import lgZoom from 'lightgallery/plugins/zoom'
// import lgPager from 'lightgallery/plugins/pager'
import lgHash from 'lightgallery/plugins/hash'

import 'lightgallery/css/lightgallery.css'
import 'lightgallery/css/lg-zoom.css'
import 'lightgallery/css/lg-thumbnail.css'
// import 'lightgallery/css/lg-pager.css'

document.querySelectorAll('.lightgallery').forEach(el => {
	lightGallery(el, {
        plugins: [
            lgZoom,
            lgThumbnail,
            // lgPager,
            lgHash
        ],
		counter: false,
		download: false,
	});
})






import Swiper, {
    Navigation,
    Autoplay ,
    Thumbs,
    Keyboard,
    EffectFade,
    Scrollbar,
    Mousewheel,
    Lazy,
} from 'swiper'

Swiper.use([
    Navigation,
    Autoplay ,
    Thumbs,
    Keyboard,
    EffectFade,
    Scrollbar,
    Mousewheel,
    Lazy,
]);


import 'swiper/css';
import 'swiper/css/effect-fade';
import 'swiper/css/scrollbar';





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


        lazy: {
            checkInView: true,
            loadPrevNext: true,
        },

        on: {
            init: (swiper) => {
                if (swiper.slides.length < 2) {
                    el.classList.add('single');
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

        lazy: {
            checkInView: true,
            loadPrevNext: true,
        },

        navigation: {
            nextEl: el.querySelector('.sw-next'),
            prevEl: el.querySelector('.sw-prev'),
        },
        thumbs: {
            swiper: galleryThumbs,
        },
    });

    if (topContainer) {
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

document.querySelectorAll('.zoom-image').forEach(el => {
    el.addEventListener('mousemove', zoom)
})

