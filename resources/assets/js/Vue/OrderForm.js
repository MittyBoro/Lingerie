
import { createApp, h } from 'vue';
// import isVisible from '../libs/isVisible.js';
import HTTP from '../libs/http';


const initApp = (el) => {
	const App = {
		data() {
			return {
				form: {},
				disabled: false,
				success: false,
			};
		},

		methods: {
			submit() {
				if (this.disabled || this.success)
					return;

				this.disabled = true;

				HTTP.post('/order/feedback', this.form)
				.then(res => {
					if (res) {
						if (!res.success) {
							alert(res.message)
						} else {
							this.success = true;
							const event = new CustomEvent('order_sent', { detail: true });
							document.dispatchEvent(event);
						}
					} else {
						alert('Ошибка обработки данных')
					}
				})
				.catch(e => {
					console.log('e', e)
					alert('Ошибка сети, повторите попытку')
				})
				.then(() => {
					this.disabled = false;
				});
			},

		},
	};

	createApp(App).mount(el);
};

document.querySelectorAll('.order-form').forEach(el => {
	initApp(el);
});

document.addEventListener('popup_opened', function (e) {
	let el = e.detail.element.querySelector('.popup-order-form');
	if (el)
		initApp(el);
}, false);



