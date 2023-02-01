

import { createApp } from 'vue/dist/vue.esm-bundler';
import Mixin from "./Mixins";
import API from '../libs/api';

import {parsePhoneNumberFromString} from 'libphonenumber-js';


const app = createApp({
    data() {

        let form = {
                name: '',
                phone: '',
                email: '',
                address: {
                    country: '',
                    region: '',
                    city: '',
                    street: '',
                    postcode: '',
                },
                payment_type: 'receipt',
            }

        let localForm = JSON.parse(localStorage.getItem('checkout_form'))

        return {
            cart: [],
            conditions: [],
            subtotal: 0,
            total: 0,

            timerId: null,
            loading: false,

            manualPreloader: true,

            form: { ...form, ...localForm }
        };
    },


    watch: {
        form: {
            deep: true,
            handler(val) {
                localStorage.setItem('checkout_form', JSON.stringify(val));
            },
        },
        'form.phone'(val) {
            let phone = parsePhoneNumberFromString(val, 'RU');
            if (phone) {
                if (!phone.isValid() ) {
                    this.$refs.phone.setCustomValidity("Invalid phone");
                } else {
                    this.$refs.phone.setCustomValidity("");
                }

                this.form.phone = phone.formatInternational().replace(/^8/g, '+7');
            }
        }
    },


    created() {
        window.manualPreloader = true
        this.get();
    },

    mounted() {
        if (!this.form.address.country)
            this.form.address.country = this.$refs.country.dataset.default
    },


    methods: {
        get() {
            API.get('/cart/final')
            .then(cart => {
                this.cart = cart.data;
                this.conditions = cart.conditions;
                this.subtotal = cart.subtotal;
                this.total = cart.total;
                this.form.total = cart.total;
            })
            .catch(err => alert(err))
            .then(() => {
                if (!this.cart.length){
                    window.location = '/cart';
                }
                else {
                    this.loading = false;
                    document.body.classList.remove('preload')
                }

            });
        },

        submit() {
            this.loading = true;

            API.post('/cart/checkout', this.form)
			.then(res => {
                window.location = res.url;
			})
            .catch(err => alert(err))
            .then(() => {
                this.loading = false;
            });
        },

    },
});



app
    .mixin(Mixin)
    .mount("#checkout")
