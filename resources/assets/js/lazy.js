
import lazySizes from 'lazysizes';

lazySizes.cfg.expand = 1500;
lazySizes.cfg.loadHidden = false;

document.addEventListener('scroll', () => {
	
	let mainContentHeight = document.body.offsetHeight - window.outerHeight;
	let windowScrollProcent = window.pageYOffset / mainContentHeight * 100;
	
	if (windowScrollProcent > 30)
	{
		lazySizes.cfg.expand = document.body.offsetHeight;
		document.querySelectorAll('img.lazyload').forEach(el => {
			let src = el.getAttribute('data-src');
			el.setAttribute('src', src);
			el.removeAttribute('data-src');
			el.classList.remove('lazyload');
		})
		lazySizes.loader.checkElems();
	}
	
})
document.addEventListener('openmodality', () => {
	// lazySizes.init()
})