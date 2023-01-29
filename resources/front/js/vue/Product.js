import { createApp } from 'vue/dist/vue.esm-bundler';
import Mixin from "./Mixins";
import HTTP from '../libs/http';


const app = createApp({
	data() {
		return {
			count: 1,
            inCart: false,
			loading: false,

            options: $options,

            form: {},
		};
	},


	computed: {

	},

	watch: {
		form: {
			deep: true,
			handler(val) {
                Object.entries(val).forEach(arr => {
                    this.setProductOption(arr[0], arr[1])
                })
			}
		}
	},

    mounted() {
        this.setInitValues()
    },

	methods: {

		store(id) {
			if (this.loading)
				return;

			this.loading = true;

			HTTP.post('/cart/store/' + id, {
                options: Object.values(this.form),
            })
            .then(res => {
				console.log('res', res);

                let event = new CustomEvent('setCartCount', { bubbles: true, detail: { count: res.count} });
                document.dispatchEvent(event);

                this.inCart = true;
			})
            .catch(err => alert(err))
			.then(() => {
				this.loading = false;
			});
		},

        setInitValues() {

            Object.entries(this.options).forEach((arr) => {
                let key = arr[0],
                    list = arr[1],
                    optId = this.getProductOption(key)

                list.forEach(el => {
                    if (el.id == optId)
                        this.form[key] = optId;
                })

                if (!this.form[key])
                    this.form[key] = list[0].id;
            });

        },

	},
});



app
    .mixin(Mixin)
    .mount("#product")
