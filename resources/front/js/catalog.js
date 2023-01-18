
import noUiSlider from 'noUiSlider';



document.querySelectorAll('.sb-price').forEach(element => {

    let rangeEl = element.querySelector('.sb-range-price');

	if (!rangeEl)
        return;

	let rangeStart = element.querySelector('input.range-start');
	let rangeEnd   = element.querySelector('input.range-end');


	// Укажите ценовой диапазон
	noUiSlider.create(rangeEl, {
		start: [
            parseInt(rangeStart.value || rangeEl.dataset.min),
            parseInt(rangeEnd.value || rangeEl.dataset.max),
        ],
		connect: true,
		step: parseInt(rangeEl.dataset.step),
        tooltips: { to: value  => new Intl.NumberFormat('ru-RU').format(value) },
		range: {
			'min': parseInt(rangeEl.dataset.min),
			'max': parseInt(rangeEl.dataset.max)
		}
	});

	rangeEl.noUiSlider.on('update', function (values, handle) {

		let value = values[handle];

		if (!handle) {
			rangeStart.value = value;
		} else {
			rangeEnd.value = value;
		}
	});
})



document.querySelectorAll('.catalog-box [filter-toggle]').forEach(el => {
    el.addEventListener('click', () => {
        document.querySelector('.catalog-mobile-sort').classList.toggle('active');
    })
})
