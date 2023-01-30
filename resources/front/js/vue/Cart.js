import { createApp } from 'vue/dist/vue.esm-bundler';
import Mixin from "./Mixins";
import API from '../libs/api';


const app = createApp({
    data() {
        return {
            cart: [],
            timerId: null,
            loading: false,

            manualPreloader: true
        };
    },


	computed: {
		subtotal() {
			let total = 0;
			this.cart.forEach(el => {
				total += el.price * el.quantity;
			})
			return total;
		},
	},


    created() {
        window.manualPreloader = true
    },

    mounted() {
        this.get();
    },

    methods: {
        get() {
            API.get('/cart/get')
            .then(cart => {
                this.cart = cart.data;
                this.setCartCount(this.cart.length);
            })
            .catch(err => alert(err))
            .then(() => {
                this.loading = false;
                this.ready = true;

                document.body.classList.remove('preload')
            });
        },

        update(item) {
            this.loading = true;

            API.post('/cart/update/' + item.id, {
                quantity: item.quantity,
            }).then(cart => {
                this.cart = cart.data;
                this.setCartCount(this.cart.length);
            })
            .catch(err => alert(err))
            .then(() => {
                this.loading = false;
            });
        },
        destroy(item) {
            this.loading = true;

            API.post('/cart/destroy/' + item.id, {}).then(cart => {
                this.cart = cart.data;
                this.setCartCount(this.cart.length);
            })
            .catch(err => alert(err))
            .then(() => {
                this.loading = false;
            });
        },

        setItemCount(item, integer) {
            if (item.quantity == 1 && integer < 1)
                return item;

            if (this.timerId)
                this.timerId = clearInterval(this.timerId);

            item.quantity = parseInt(item.quantity) + integer;

            this.timerId = setTimeout(() => {
                this.update(item);
            }, 1000);

            return item;
        },


        setCartCount(count) {
            let event = new CustomEvent('setCartCount', { bubbles: true, detail: { count: count} });
            document.dispatchEvent(event);
        },
    },
});



app
    .mixin(Mixin)
    .mount("#cart")
