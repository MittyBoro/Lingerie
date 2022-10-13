
import { createApp, h } from 'vue';
import HTTP from '../libs/http';
import {parsePhoneNumberFromString} from 'libphonenumber-js';


const App = {
    data() {
        return {
            form: CUSTOMER || {},
            disabled: false,
            payment_type: null,

            total: 0,
            bonus_limit: 0,
            spending_bonuses: 0,

            ready: false,
            newSpendingBonus: null,

            phoneValid: false,
        };
    },

    computed: {
        phone: {
            get() {
                return this.form.phone;
            },
            set(val) {
                let phone = parsePhoneNumberFromString(val, 'RU');
                if (phone) {
                    this.form.phone = phone.formatInternational();

                    if (!phone.isValid() ) {
                        this.$refs['phone'].setCustomValidity("Введите корректный номер телефона (+7…)");
                    } else {
                        this.$refs['phone'].setCustomValidity("");
                    }
                }
            }
        }
    },

    mounted() {
        this.getCart();

        this.phone = this.form.phone;
    },

    methods: {
        getCart() {
            HTTP.get('/cart/checkout/get')
            .then(res => {
                if (!res)
                    throw new Error;

                this.applyData(res);

                setTimeout(() => {
                    this.newSpendingBonus = this.bonus_limit;
                }, 700);
            })
            .catch(() => alert('Ошибка сети, повторите попытку'))
            .then(() => {
                this.ready = true;
            });
        },

        create() {
            if (!this.payment_type)
                return;

            let data = {
                name: this.form.name,
                phone: this.form.phone.replace(/^8/g, '+7'),
                email: this.form.email,

                address: {
                    region: this.form.region,
                    city: this.form.city,
                    street: this.form.street,
                    postcode: this.form.postcode,
                    transport: this.form.transport,
                },

                comment: this.form.comment,
                payment_type: this.payment_type,
                total: this.total,
            }

            this.disabled = true;

            HTTP.post('/cart/checkout/pay', data)
            .then(res => {
                if (res && res.url) {
                    window.location = res.url;
                    setTimeout(() => {
                        this.disabled = true;
                    }, 40);
                } else if (res.message) {
                    alert(res.message)
                } else {
                    alert('Ошибка обработки данных. Проерьте корректность данных')
                }
            })
            .catch(() => alert('Ошибка сети, повторите попытку'))
            .then(() => {
                this.disabled = false;
            });
        },


        setBonuses() {

            this.ready = false;

            HTTP.post('/cart/checkout/bonuses', {
                bonuses: this.newSpendingBonus,
            }).then(res => {
                if (!res?.total)
                    throw new Error;

                this.applyData(res);
            })
            .catch(() => alert('Ошибка, повторите попытку'))
            .then(() => {
                this.ready = true;
            });
        },

        setPaymentType(paymentType) {
            this.payment_type = paymentType;
        },

        applyData(values) {
            this.total = values.total;
            this.bonus_limit = values.bonus_limit;
            this.spending_bonuses = values.spending_bonuses;
        },

    },
};

if (document.querySelector('#checkout')) {
    const vue = createApp(App);
    vue.config.globalProperties.formatPrice = window.formatPrice;
    vue.config.globalProperties.sklonenie = window.sklonenie;

    vue.mount("#checkout")
}
