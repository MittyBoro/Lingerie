
import { createApp, h } from 'vue';
import HTTP from '../libs/http';


const App = {
    data() {
        return {
            cart: [],
            timerId: null,

            future_bonuses: null,

            loading: true,
            ready: false,

            promocode: null,
            newPromocode: '',
            promoMessage: '',

        };
    },


    computed: {
        cartList() {
            return Object.values(this.cart);
        },
        subtotal() {
            let total = 0;
            this.cartList.forEach(el => {
                let price = el.discount_price || el.price
                total += price * el.quantity;
            })
            return this.formatPrice(total);
        },
        subtotalOld() {
            let total = 0;
            this.cartList.forEach(el => {
                total += el.price * el.quantity;
            })
            return this.formatPrice(total);
        }
    },

    mounted() {
        this.getCart();
    },

    methods: {
        getCart() {
            HTTP.get('/cart/get')
            .then(res => {
                if (!res)
                    throw new Error;

                this.applyData(res);
            })
            .catch(() => alert('Ошибка сети, повторите попытку'))
            .then(() => {
                this.loading = false;
                this.ready = true;
            });
        },

        setPromocode() {
            if (!this.newPromocode)
                return;

            this.loading = true;
            this.promoMessage = '';

            HTTP.post('/cart/promocode/apply', {
                code: this.newPromocode,
            }).then(res => {
                if (res) {
                    if (!res.success) {
                        this.promoMessage = res.message;
                    } else {
                        this.applyData(res);
                        this.newPromocode = '';
                    }
                } else {
                    alert('Ошибка изменения корзины, повторите попытку')
                }
            })
            .catch(() => alert('Ошибка сети, повторите попытку'))
            .then(() => {
                this.loading = false;
            });
        },

        clearPromocode() {

            this.loading = true;

            HTTP.post('/cart/promocode/clear', {})
            .then(res => {
                if (res && res.success) {
                    this.applyData(res);
                } else {
                    alert('Ошибка изменения корзины, повторите попытку')
                }
            })
            .catch(() => alert('Ошибка, повторите попытку'))
            .then(() => {
                this.loading = false;
            });
        },


        update(item) {

            this.loading = true;

            HTTP.post('/cart/update', {
                id: item.id,
                quantity: item.quantity,
            }).then(res => {
                if (res && res.success) {
                    this.applyData(res);
                } else {
                    alert('Ошибка изменения корзины, повторите попытку')
                }
            })
            .catch(() => alert('Ошибка сети, повторите попытку'))
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

        getWidth(val) {
            return ((val.toString().length + 1) * 11) + 'px'
        },

        remove(item) {
            this.loading = true;
            HTTP.post('/cart/remove', {
                id: item.id,
            }).then(res => {
                if (res && res.success) {
                    this.applyData(res);
                } else {
                    alert('Ошибка изменения корзины, повторите попытку')
                }
            })
            .catch(() => alert('Ошибка сети, повторите попытку'))
            .then(() => {
                this.loading = false;
            });
        },

        applyData(values) {
            this.cart = values.cart;
            this.future_bonuses = values.future_bonuses;
            this.promocode = values.promocode;
            this.setCartCount(values.cart.length);
        },

        bonusString(bonuses) {
            return this.formatPrice(bonuses) + this.sklonenie(bonuses, [' бонусный рубль', ' бонусных рубля', ' бонусных рублей'])
        },
    },
};

if (document.querySelector('#cart')) {
    const vue = createApp(App);
    vue.config.globalProperties.formatPrice = window.formatPrice;
    vue.config.globalProperties.sklonenie = window.sklonenie;

    vue.mount("#cart")
}
