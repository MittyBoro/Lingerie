document.addEventListener('DOMContentLoaded', function ()
{

    document.addEventListener('openmodality', (e) =>
    {
        setBtnAnimation(e.target);
    });

    document.addEventListener('mounted', (e) =>
    {
        setBtnAnimation(e.target);
    });

    setBtnAnimation(document);


    function setBtnAnimation(parent)
    {
        parent.querySelectorAll('.btn:not(.norip) .btn-content')
            .forEach(el => btnAnimation(el));
    }


    function btnAnimation(el)
    {
        if ( el.querySelector('.ripplelink') )
        {
            return;
        }

        let ripplelink = document.createElement('div');
            ripplelink.classList.add('ripplelink');

        el.appendChild(ripplelink);

        setInterval(function()
        {
            let d, x, y;
            let ink = el.querySelector('.ink')

            if (!ink)
            {
                ink = document.createElement('span');
                ink.classList.add('ink');
                ripplelink.appendChild(ink);
            }

            ink.classList.remove('animate');

            if (!ink.offsetHeight && !ink.offsetWidth)
            {
                d = Math.max(el.offsetWidth, el.offsetHeight);
                ink.style.height = d + 'px';
                ink.style.width = d + 'px';
            }

            x = Math.round(Math.random() * ink.offsetHeight - ink.offsetHeight / 2);
            y = Math.round(Math.random() * ink.offsetHeight - ink.offsetHeight / 2);
            // y = 0;
            // x = e.pageX - $this.offset().left - ink.width()/2;
            // y = e.pageY - $this.offset().top - ink.height()/2;

            ink.style.top = y + 'px';
            ink.style.left = x + 'px';

            ink.classList.add('animate');
            ink.style.animationDelay = (Math.random() * 1.5) + 's.';

        }, 3000)
    }

});
