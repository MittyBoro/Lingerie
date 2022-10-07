
import {slideToggle} from './libs/slideToggle'


document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.sb-menu a').forEach(el => {
        let href = el.getAttribute('href');

        decodeURI(location.href).indexOf(decodeURI(href)) >= 0 ?
                el.classList.add('active') :
                el.classList.remove('active')
    });
});


document.addEventListener('DOMContentLoaded', () => {
    let bct = document.querySelector('.btn.cats-toggle');

    if (!bct) return;

    bct.addEventListener('click', function() {
        let menu = this.parentNode.querySelector('.sb-menu');

        slideToggle(menu, 400, (action) => {
            action == 'up' ?
            this.classList.remove('active') :
            this.classList.add('active');
        });

    });
});

