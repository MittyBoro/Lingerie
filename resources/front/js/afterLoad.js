// import {setScrollbarWidth} from './libs/methods';
import { slideDown, slideUp } from './libs/slideToggle';

document.addEventListener('DOMContentLoaded', function() {


    // анимация перед загрузкой страницы выкл.
    let timerStart = Date.now();
    window.addEventListener('load', function() {
        window.timeEnd = Date.now() - timerStart;
        let rem = 500 - window.timeEnd;
        if ( rem < 0 ) rem = 10;
        setTimeout( () => {
            document.body.classList.remove('preload');
        }, rem);
    });


    document.addEventListener('invalid', function(e){
        e.target.classList.add('invalid');
    }, true);
    document.addEventListener('input', function(e){
        if (e.target.checkValidity()) {
            e.target.classList.remove('invalid');
            e.target.classList.add('valid');
        } else {
            e.target.classList.add('invalid');
            e.target.classList.remove('valid');
        }
    }, true);


    // вкладки
    document.querySelectorAll('[tabs-here]').forEach(parent => {

        let tabNames = parent.querySelectorAll('[data-tab-name]')

        if (!tabNames.length)
            return;

        tabNames.forEach(el => {

            el.addEventListener('click', () => {
                parent.querySelectorAll('[data-tab-name], [data-tab-content]').forEach(tn => tn.classList.remove('tab-active'));

                el.classList.add('tab-active');

                parent.querySelectorAll('[data-tab-content="' + el.dataset.tabName + '"]')
                            .forEach(tc => tc.classList.add('tab-active'))

            });
        });

        parent.querySelectorAll('[tab-next], [tab-prev]').forEach(el => {

            el.addEventListener('click', () => {
                let localTabNames = [...tabNames]

                if (el.hasAttribute('tab-prev'))
                    localTabNames = [...localTabNames].slice().reverse()

                let element
                let willBeNext = false

                localTabNames.some(tItem => {
                    if (willBeNext) {
                        element = tItem
                        return true;
                    }
                    if (tItem.classList.contains('tab-active'))
                        willBeNext = true;
                })

                if (!element)
                    element = localTabNames[0]

                if (element)
                    element.click();
            });
        });
    });


    document.querySelectorAll('[toggling] [toggle-click]').forEach(element => {
        let toggling = element.closest('[toggling]'),
            toggleEl   = toggling.querySelector('[toggle-el]')

        toggling.classList.add('initialized')
        if ( !toggling.classList.contains('active') && toggleEl ) {
            toggleEl.style.display = 'none'
        }

        element.addEventListener('click', () => {

            if ( toggling.classList.contains('active') ) {
                toggling.classList.remove('active');
                if (toggleEl)
                    slideUp(toggleEl, 300)
            } else {
                toggling.classList.add('active');
                if (toggleEl)
                    slideDown(toggleEl, 300)
            }
        })
    });

    // document.addEventListener('scroll', e => {
    // 	// переменная ширины кастомного скролла
    // 	setScrollbarWidth('--scrollbar-width', 'custom-scroll');
    // 	setScrollbarWidth();
    // });
    // setScrollbarWidth();
    // setScrollbarWidth('--scrollbar-width', 'custom-scroll');



    // image to svg, after other init
    document.addEventListener('readystatechange', function() {
        document.querySelectorAll('img.to-svg').forEach(image => {
            fetch(image.src)
            .then(res => res.text())
            .then(data => {
                const parser = new DOMParser();
                const svg = parser.parseFromString(data, 'image/svg+xml').querySelector('svg');

                if (image.id) svg.id = image.id;
                if (image.className) svg.classList = image.classList;

                Object.keys(image.dataset).forEach(function(key) {
                    svg.dataset[key] = image.dataset[key];
                });

                image.parentNode.replaceChild(svg, image);
            })
            .catch(error => console.error(error))
        })
    })


    // prevet click inside link
    document.querySelectorAll('.prevent').forEach(el => {
        el.addEventListener('click', (e) => {
            e.preventDefault();
        });
    });

    // закрыть меню
    document.querySelectorAll('.menu-box').forEach(element => {
        element.addEventListener('click', (e) => {

            if (
                e.target.classList.contains('prevent') ||
                e.target.closest('.prevent')
            ) {
                return;
            }

            document.querySelector('.header-box').classList.remove('active');
        })
    });

});
