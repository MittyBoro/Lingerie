
import { createApp, h } from 'vue';
import HTTP from '../libs/http';


const App = {
	data() {
		return {
			product: PRODUCT,
			activeTab: 1,
			activeVariations: [],
			count: 1,
			disabled: false,
			success: false,
		};
	},


	computed: {

		price() {
			let prices = [0];

			this.activeVariations.forEach(el => {
				prices.push( parseInt(el.price) );
			});

			let priceMin = Math.max( Math.min(...prices) );
			let price = Math.max(...prices) - priceMin;

			return price * this.count;
		},

		bonuses() {
			let bonuses = [0];

			this.activeVariations.forEach(el => {
				bonuses.push( parseInt(el.bonuses) );
			});

			let bMin = Math.max( Math.min(...bonuses) );
			let b = Math.max(...bonuses) - bMin;

			return b * this.count;
		},

		variations() {
			let vars = this.product.variations || [];

			let	groups = []

			vars.forEach(item => {
				let existing = groups.filter(v => {
					return v.name == item.name;
				});

				if (existing.length) {
					let existingIndex = groups.indexOf(existing[0]);
					groups[existingIndex].values = groups[existingIndex].values.concat(item);
				} else {
					let add = {
						name: item.name,
						values: [item],
					};
					groups.push(add);
				}
			});

			return groups;
		},
	},

	watch: {
		activeVariations: {
			deep: true,
			handler() {
				this.disabled = false;
				this.success = false;
			}
		}
	},


	created() {
		this.setInitVariation();
	},

	mounted() {
		this.$el.parentNode.classList.add('mounted');
	},

	methods: {

		addToCart() {

			if (this.disabled || this.success)
				return;

			let variations = [];

			this.activeVariations.forEach(el => {
				variations.push(el.id);
			});

			this.disabled = true;

			HTTP.post('/cart/add', {
				product_id: this.product.id,
				variation_ids: variations,
				count: this.count,
			}).then(res => {
				if (res && res.success) {
					let event = new CustomEvent('setCartCount', { bubbles: true, detail: { count: res.count} });
					document.dispatchEvent(event);
					this.success = true;
				} else {
					alert('Ошибка добавления товара, повторите попытку. Если ошибка повторилась – сообщите нам об этом в социальных сетях')
				}
			}).catch(err => alert('Ошибка сети, повторите попытку'))
			.then(() => {
				this.disabled = false;
			});
		},

		setTab(tab) {
			this.activeTab = tab;
		},

		setInitVariation() {
			this.variations.forEach((el, i) => {
				this.activeVariations[i] = el.values[0];
			})
		},

		getWidth(val) {
			return ((val.toString().length + 1) * 11) + 'px'
		},

	},
};



if (document.querySelector('#product')) {
	const vue = createApp(App);
	vue.config.globalProperties.formatPrice = window.formatPrice;
	vue.config.globalProperties.sklonenie = window.sklonenie;

	vue.mount("#product")
}


