import './vue/Catalog';

import './elements/rangeSlider';
import './elements/catalogSwiper';



document.querySelectorAll('.catalog-box [filter-toggle]').forEach(el => {
    el.addEventListener('click', () => {
        document.querySelector('.catalog-mobile-sort').classList.toggle('active');
    })
})
