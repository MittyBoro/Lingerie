import { createApp } from 'vue/dist/vue.esm-bundler';
import Mixin from "./Mixins";
import API from '../libs/api';


const app = createApp({
    data() {
        return {
            cartMini: $cartMini,
            loading: false,
            success: false,

            options: $options,

            form: {},
        };
    },


    computed: {
        inCart() {
            let inCart = false

            this.cartMini.forEach(item => {
                let key = $id + '__' + this.formValues.join('_')

                if (key == item.id) {
                    inCart = true
                }
            })

            return inCart
        },
        formValues() {
            return Object.values(this.form).sort((a, b) => a - b)
        }
    },

    watch: {
        form: {
            deep: true,
            handler(val) {
                this.success = false
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

            API.post('/cart/store/' + id, {
                options: this.formValues,
            })
            .then(cart => {
                this.cartMini = cart.mini

                let event = new CustomEvent('setCartCount', { bubbles: true, detail: { count: cart.count} });
                document.dispatchEvent(event);


                this.success = true

                setTimeout(() => {this.success = false}, 2000)

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
