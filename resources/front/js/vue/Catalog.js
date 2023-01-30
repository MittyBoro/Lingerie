import { createApp } from 'vue/dist/vue.esm-bundler';
import Mixin from "./Mixins";
import HTTP from '../libs/http';


const app = createApp({
    data() {
        let filter = {
            options: [],
            price: [],
        }
        return {
            timerId: null,
            loading: false,

            sortable: $sortable,
            activeSlug: $slug,

            categories: $categories,

            colorsLimit: true,
            sizesLimit: true,

            listenFilter: 0,

            defaultFilter: JSON.parse(JSON.stringify(filter)),
            filter: filter,
        };
    },


	computed: {
        activeSort() {
            let urlParams = new URLSearchParams(window.location.search);

            let sortHref = urlParams.get('sort');

            return this.sortable.find(el => el.href.endsWith(sortHref)) || this.sortable[0]
        },
	},

	watch: {
        filter: {
            deep: true,
            handler() {
                if (this.listenFilter === 0) {
                    this.listenFilter = true;
                    return;
                }
                if (!this.listenFilter)
                    return;

                if (this.timerId)
                    this.timerId = clearInterval(this.timerId);

                this.timerId = setTimeout(() => {
                    this.filtering();
                }, 1000);
            },
        },
	},


    created() {
        this.setUrlToFilter()
    },

    mounted() {
    },

    methods: {
        setFilterToUrl() {
            let params = new URLSearchParams();

            Object.entries(this.filter).forEach(([key, value]) => {
                const filterValue = Array.isArray(value) ? value.join(',') : value;

                if (filterValue)
                    params.append(key, filterValue);
                else
                    params.delete(key);
            });

            let paramsString = params.toString()
            let newUrl = location.pathname + (paramsString ? '?' + paramsString : '');

            history.pushState(null, null, newUrl);
        },

        setUrlToFilter() {
            let params = new URLSearchParams(location.search);
            let validKeys = Object.keys(this.filter);

            params.forEach((value, key) => {
                if (!validKeys.includes(key)) return;
                this.filter[key] = value.split(',');
            });
        },


        filtering() {

            this.setFilterToUrl()

            return;

            HTTP.get('/cart/get')
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

            HTTP.post('/cart/update/' + item.id, {
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

        reset() {
            this.filter = JSON.parse(JSON.stringify(this.defaultFilter));
            this.setFilterToUrl()

            if (this.$refs.priceSlider)
                this.$refs.priceSlider.setUi()
        },

    },
});



app
    .mixin(Mixin)
    .mount("#catalog")
