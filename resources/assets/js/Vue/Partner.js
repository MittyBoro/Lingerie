
import { createApp, h } from 'vue';
import isVisible from '../libs/isVisible.js';
import HTTP from '../libs/http';


const App = {
	data() {
		return {
			city: '',
		};
	},

	watch: {
		city() {
			this.setNewUrl();
		}
	},

	computed: {
		translatedCity() {
			return this.engToRus(this.city.toLowerCase())
		}
	},

	created() {
		const queryString = window.location.search;
		const urlParams = new URLSearchParams(queryString);
		this.city = urlParams.get('city') || '';


		this.mapClickEvent();
	},

	methods: {
		showCity(str) {
			let reg = new RegExp(this.translatedCity, 'i')
			let find = reg.test(str);

			return find;
		},

		highlight(innerHTML) {
			let city = this.translatedCity;
			let index = innerHTML.toLowerCase().indexOf(city);
			if (index >= 0) {
				innerHTML = innerHTML.substring(0,index) + "<span class='highlight'>" + innerHTML.substring(index,index+city.length) + "</span>" + innerHTML.substring(index + city.length);
			}
			return innerHTML;
		},

		engToRus(str) {

			const ru = new Map([
				['a', 'а'],['b', 'б'], ['v', 'в'], ['g', 'г'], ['d', 'д'], ['e', 'е'],
				['yo', 'ё'], ['zh', 'ж'], ['z', 'з'], ['i', 'и'], ['k', 'к'],
				['l', 'л'], ['m', 'м'], ['n', 'н'], ['o', 'о'], ['p', 'п'], ['r', 'р'], ['s', 'с'],
				['t', 'т'], ['u', 'у'], ['f', 'ф'], ['h', 'х'], ['c', 'ц'], ['ch', 'ч'], ['sh', 'ш'],
				['shch', 'щ'], ['y', 'ы'], ['u', 'ю'], ['ya', 'я'],
			]);

			return Array.from(str)
				.reduce((s, l) =>
					s + (
						  ru.get(l)
						  || ru.get(l.toLowerCase()) === undefined && l
						  || ru.get(l.toLowerCase()).toUpperCase()
					  )
					, '');
		},

		setNewUrl() {
			const params = new URLSearchParams(location.search);

			if (!this.city)
				params.delete('city', this.city)
			else if ( params.has('city') )
				params.set('city', this.city)
			else
				params.append('city', this.city);

			history.replaceState({}, null, '?' + params.toString());

		},

		intoMapView(id) {
			let event = new CustomEvent('locationClick', {bubbles: true, detail: { id: id }});
			document.dispatchEvent(event);
		},

		mapClickEvent() {
			document.addEventListener('mapClick', el => {
				this.city = '';

				let activeElement = document.getElementById('item-' + el.detail.id);

				setTimeout(() => {
					activeElement.scrollIntoView();
					activeElement.classList.add('active');
				}, 200);
				setTimeout(() => {
					activeElement.classList.remove('active');
				}, 9000);
			});
		}

	},
};

if (document.querySelector('#partners'))
	createApp(App).mount("#partners");


