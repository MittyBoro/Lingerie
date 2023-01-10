document.addEventListener("DOMContentLoaded", function() {
    let lazyImages = [].slice.call(document.querySelectorAll("img.lazy, .lazy-bg"));
    let active = false;

    const lazyLoad = function() {
        if (active === false) {
            active = true;

            setTimeout(function() {
                lazyImages.forEach(function(lazyImage) {
                    var minus = 450
                    if ((lazyImage.getBoundingClientRect().top <= window.innerHeight + minus && lazyImage.getBoundingClientRect().bottom >= minus * -1 ) && getComputedStyle(lazyImage).display !== "none") {
                        if (lazyImage.dataset.src) lazyImage.src = lazyImage.dataset.src;
                        // lazyImage.srcset = lazyImage.dataset.srcset;
                        lazyImage.classList.remove("lazy");
                        lazyImage.classList.remove("lazy-bg");

                        lazyImages = lazyImages.filter(function(image) {
                            return image !== lazyImage;
                        });

                        if (lazyImages.length === 0) {
                            document.removeEventListener("scroll", lazyLoad);
                            window.removeEventListener("resize", lazyLoad);
                            window.removeEventListener("orientationchange", lazyLoad);
                        }
                    }
                });

                active = false;
            }, 200);
        }
    };

    document.addEventListener("scroll", lazyLoad);
    window.addEventListener("resize", lazyLoad);
    window.addEventListener("orientationchange", lazyLoad);
    window.addEventListener("load", lazyLoad);
});
