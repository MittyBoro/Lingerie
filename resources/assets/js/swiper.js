

import Swiper, {Navigation, Autoplay , Pagination, Thumbs, EffectFade, } from 'swiper'
Swiper.use([Navigation, Autoplay, Pagination, Thumbs, EffectFade, ]);



// слайдер на главной
let homeSlider = new Swiper('.home-screen .swiper-container', {
	slidesPerView: 1,
	spaceBetween: 30,
	loop: true,
	loopAdditionalSlides: 3,
	speed: 750,
	autoplay: {
		delay: 5000,
		disableOnInteraction: false,
	},
	pagination: {
		el: '.home-screen .swiper-pagination',
		clickable: true,
	},
	navigation: {
		nextEl: '.home-screen .swiper-button-next',
		prevEl: '.home-screen .swiper-button-prev',
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
			document.querySelector('.home-screen .swiper-numeric').innerHTML =
											(swiper.realIndex + 1).toString().padStart(2, '0');
		}

	},
});



// слайдер товары
let thumbContainer = document.querySelector('.product-content .gallery-thumbs .swiper-container')

let galleryThumbs = new Swiper(thumbContainer, {
	spaceBetween: 15,
	slidesPerView: 3,
	// watchSlidesVisibility: true,
	// watchSlidesProgress: true,


	on: {
		init: (swiper) => {
			document.querySelector('.product-content .gallery-thumbs').classList.add('inited');
			if (swiper.slides.length < 2) {
				document.querySelector('.product-content .gallery-thumbs').classList.add('hidden');
			}
		},
	},
	breakpoints: {
		576: {
		},
		768: {
		},
		992: {
			spaceBetween: 25,
			slidesPerView: 4,
		},
		1240: {
		}
	}
});

let topContainer = document.querySelector('.product-content .gallery-top .swiper-container');

let galleryTop = new Swiper(topContainer, {
	spaceBetween: 15,
	loop: true,
	effect: 'fade',
	fadeEffect: {
		crossFade: true
	},
	navigation: {
		nextEl: '.product-content .swiper-button-next',
		prevEl: '.product-content .swiper-button-prev',
	},
	thumbs: {
		swiper: galleryThumbs,
	},
});

if (topContainer) {
	topContainer.querySelectorAll('.prod-zoom-image').forEach(el => {
		el.addEventListener('mousemove', zoom)
	})
}


function zoom(e){
    let zoomer = e.currentTarget;
	let offsetX, offsetY;

    e.offsetX ? (offsetX = e.offsetX) : (offsetX = e.touches[0].pageX);
    e.offsetY ? (offsetY = e.offsetY) : (offsetX = e.touches[0].pageX);

    let x = offsetX / zoomer.offsetWidth  * 100;
    let y = offsetY / zoomer.offsetHeight * 100;

    zoomer.style.backgroundPosition = x + "% " + y +"%";
}




// слайдер о нас
document.querySelectorAll('.about-box .gallery-thumbs .swiper-container').forEach(el => {
	thumbAboutFn(el);
});

// слайдер о нас
document.querySelectorAll('.contract-box .gallery-thumbs .swiper-container').forEach(el => {
	thumbAboutFn(el);
});

function thumbAboutFn(thumbAbout) {

	let parrent = thumbAbout.closest('.about-gallery, .contract-gallery');

	let thumbAboutSwiper = new Swiper(thumbAbout, {
		spaceBetween: 10,
		slidesPerView: 3,
		// watchSlidesVisibility: true,
		// watchSlidesProgress: true,
		navigation: {
			nextEl: parrent.querySelector('.swiper-button-next'),
			prevEl: parrent.querySelector('.swiper-button-prev'),
		},
		breakpoints: {
			576: {
				slidesPerView: 4,
			},
			768: {
				spaceBetween: 15,
			},
			992: {
				spaceBetween: 30,
			},
			1240: {
				slidesPerView: 5,
			}
		}
	});

}

document.querySelectorAll('.contract-box .video-slider .swiper-container').forEach(el => {
	thumbAboutFn2(el);
});

function thumbAboutFn2(thumbAbout) {

	let parrent = thumbAbout.closest('.contract-gallery');

	let thumbAboutSwiper = new Swiper(thumbAbout, {
		spaceBetween: 10,
		slidesPerView: 1,
		// watchSlidesVisibility: true,
		// watchSlidesProgress: true,
		navigation: {
			nextEl: parrent.querySelector('.swiper-button-next'),
			prevEl: parrent.querySelector('.swiper-button-prev'),
		},
		breakpoints: {
			576: {
				slidesPerView: 2,
			},
			768: {
				spaceBetween: 15,
			},
			992: {
				spaceBetween: 30,
			},
			1240: {
				slidesPerView: 3,
			}
		}
	});

}




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
	on: {
		init: (swiper) => {
			swiper.$el[0].addEventListener('mouseenter', () => {
				swiper.autoplay.stop()
			}, false);
			swiper.$el[0].addEventListener('mouseleave', () => {
				swiper.autoplay.start()
			}, false);
		},

	},
	breakpoints: {
		576: {
		},
		768: {
			spaceBetween: 30,
			slidesPerView: 3,
		},
		992: {
			enabled: false,
			spaceBetween: 45,
			autoplay: false,
			enabled: false,
			loop: false,
			slidesPerView: 4,
		},
		1250: {
			enabled: false,
			spaceBetween: 60,
			slidesPerView: 4,
		}
	}
});
