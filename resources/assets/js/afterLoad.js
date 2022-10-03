
// import './libs/loadJs'
import MapStart from './map'

document.addEventListener('DOMContentLoaded', function() {

	/**
	 * метрики, чаты, карты
	 */
	let onScrollScripts = () =>
	{
		// jivoSite();
	};

	let onLoadScripts = () =>
	{
		metrika();
		MapStart();
		// яндекс метрка
	};

	window.addEventListener('scroll', () =>
	{
		setTimeout(onScrollScripts, 1000);
	}, {once: true});

	window.onload = () =>
	{
		setTimeout(onLoadScripts, 1000);
	}


	let timerStart = Date.now();
	window.addEventListener('load', function() {
		window.timeEnd = Date.now() - timerStart;
		let rem = 500 - window.timeEnd;
		if ( rem < 0 ) rem = 10;
		setTimeout( () => {
			document.body.classList.remove('preload');
		}, rem);
	});


	function metrika() {
	}


	function jivoSite() {
		(function(){ var widget_id = '8J1kyfk9LO';var d=document;var w=window;function l(){
			var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();
	}


	document.addEventListener('input', function(e){
		e.target.classList.remove('invalid');
	}, true);

	document.addEventListener('invalid', function(e){
		e.target.classList.add('invalid');
	}, true);

});
