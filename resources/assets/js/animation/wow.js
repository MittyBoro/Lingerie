
import wow from '../libs/wow.min';


let wowVar = new wow(
	{
		boxClass:     'wow',
		animateClass: 'animated',
		offset:       0,
		mobile:       true,
		live:         true,
		callback:     function(box) {
			if (box.classList.contains('w-36'))
				addNumberToStop(box, 0, 36, 1, 1500)
			if (box.classList.contains('w-.99'))
				addNumberToStop(box, 0, .99, .01, 2500)
			if (box.classList.contains('w-60'))
				addNumberToStop(box, 0, 60, 1, 2500)
		},
		scrollContainer: null
	}
);

wowVar.init();


function addNumberToStop(box, from, to, step, speed = 500)
{
	let newValue = from;
	let stepSpeed = speed / (to - from) * step;

	let timerId  = setInterval(() =>
	{
		newValue += step;
		newValue = Math.round(newValue * 1000) / 1000;

		box.innerHTML = newValue;

		if (to == newValue) clearTimeout(timerId);
	}, stepSpeed)
}
