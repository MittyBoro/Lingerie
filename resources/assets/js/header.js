
document.addEventListener('DOMContentLoaded', () => {

    let isOpen = false;
    let headerClasses = document.querySelector('.header').classList



    document.querySelector('.hamburger').addEventListener('click', function() {
        if (headerClasses.contains('open-menu')) {
            headerClasses.remove('open-menu');
            isOpen = false;
        }
        else {
            headerClasses.add('open-menu');
            isOpen = true;
        }
    });

    document.addEventListener('click', function(e) {
        if(!isOpen)
            return;

        if (e.target.closest('.big-menu-box') || e.target.classList.contains('big-menu-box') || e.target.classList.contains('hamburger') )
            return;

        headerClasses.remove('open-menu');
        isOpen = false;
    });



    let arrow = document.querySelector('.arrow-top');

    if (arrow) {
        document.addEventListener('scroll', e => {
            window.scrollY > 100 ?
            arrow.classList.add('active') :
            arrow.classList.remove('active')
        });

        arrow.addEventListener('click', e => {
            window.scrollTo(0,0);
        });
    }
});

