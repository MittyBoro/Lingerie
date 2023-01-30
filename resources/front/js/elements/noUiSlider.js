import noUiSlider from 'noUiSlider';


const rangeSliders = document.querySelectorAll('.range-sliger');

rangeSliders.forEach(container => {

    let rangeEl = container.querySelector('.range-sliger-element');

	if (!rangeEl) return;

	let rangeMin = container.querySelector('input.range-min');
	let rangeMax = container.querySelector('input.range-max');

	// Укажите ценовой диапазон
	noUiSlider.create(rangeEl, {
		start: [
            parseInt(rangeMin.value) || parseInt(rangeEl.dataset.min),
            parseInt(rangeMax.value) || parseInt(rangeEl.dataset.max),
        ],
		connect: true,
		step: parseInt(rangeEl.dataset.step),
        tooltips: { to: value  => new Intl.NumberFormat('ru-RU').format(value) },
		range: {
			min: parseInt(rangeEl.dataset.min),
			max: parseInt(rangeEl.dataset.max)
		}
	});

	rangeEl.noUiSlider.on('set', function (values, handle) {

		let value = values[handle];

		if (!handle) {
			rangeMin.value = value;
            fireEvent(rangeMin, 'change');
		} else {
			rangeMax.value = value;
            fireEvent(rangeMax, 'change');
		}
	});

    rangeEl.setUi = (...args) => {
        rangeEl.noUiSlider.set([
            parseInt(args[0] || rangeEl.dataset.min),
            parseInt(args[1] || rangeEl.dataset.max),
        ])
    }
})


function fireEvent(element, event) {
    element.dispatchEvent(new Event(event, { 'bubbles': true }))
}
