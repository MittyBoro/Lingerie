
import 'lightgallery.js'
// import 'lg-thumbnail.js'
import 'lg-pager.js'
import 'lg-zoom.js'
import 'lg-hash.js'
// import 'lg-fullscreen.js'
// import 'lg-autoplay.js'


document.querySelectorAll('.lightgallery').forEach(el => {
    lightGallery(el, {
        controls: true,
        counter: false,

        zoom: true,
        actualSize: false,

        fullScreen: false,
        download: false,
        // thumbnail: false,
        // autoplay: false,
    });
})
