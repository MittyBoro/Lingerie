import { createApp } from 'vue/dist/vue.esm-bundler';
import Mixin from "./Mixins";
import API from '../libs/api';
import imgToSvg from '../libs/imgToSvg';


const app = createApp({
    data() {
        let filter = {
            options: [],
            price: [0,0],
        }
        return {
            timerId: null,
            loading: false,

            sortable: $sortable,
            activeSlug: $slug,

            categories: $categories,

            colorsLimit: true,
            sizesLimit: true,

            listenFilter: false,

            defaultFilter: JSON.parse(JSON.stringify(filter)),
            filter: filter,

            locationSearch: window.location.search
        };
    },


	computed: {
        activeSort() {
            let urlParams = new URLSearchParams(this.locationSearch);

            let sortHref = urlParams.get('sort');

            return this.sortable.find(el => el.href.endsWith(sortHref)) || this.sortable[0]
        },
	},

	watch: {
        locationSearch(val) {
            history.pushState(null, null, location.pathname + val);
        },

        filter: {
            deep: true,
            handler() {
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
        this.setCatalogLinkEvents(this.$el)
        this.listenFilter = true;
    },

    methods: {

        setUrlToFilter() {
            let params = new URLSearchParams(location.search);
            let validKeys = Object.keys(this.filter);

            params.forEach((value, key) => {
                if (!validKeys.includes(key)) return;
                this.filter[key] = value.split(',');
            });
        },

        filterToUrl() {
            let params = new URLSearchParams(location.search);

            Object.entries(this.filter).forEach(([key, value]) => {
                const filterValue = Array.isArray(value) ? value.join(',') : value;

                if (filterValue && filterValue != '0,0')
                    params.set(key, filterValue);
                else
                    params.delete(key);
            });

            params.delete('p');

            return params.toString() ? '?' + params : ''
        },


        filtering() {
            let search = this.filterToUrl()
            this.getCatalog(search)
        },


        getCatalog(search = '') {
            this.locationSearch = search;
            this.loading = true;

            let url = '/catalog' + (this.activeSlug ? '/' + this.activeSlug : '') + search;

            API.post(url, {}, true)
                .then(data => {
                    this.updateCatalog(data);
                })
                .catch(err => alert(err))
                .then(() => {
                    this.loading = false;
                })
        },

        updateCatalog(data) {
            let catalogList = this.$refs.catalogList
                catalogList.innerHTML = data;

            imgToSvg(catalogList);

            document.dispatchEvent(new CustomEvent('catalogChanged', { bubbles: true }));

            this.setCatalogLinkEvents(catalogList)
        },

        setCatalogLinkEvents(parent) {
            parent.querySelectorAll('.event-links a').forEach(a => {
                a.addEventListener('click', e => {
                    e.preventDefault()

                    let search = new URL(a.href).search;
                    this.getCatalog(search)
                    this.toTop()

                })
            })
        },

        setCategory(link) {
            this.activeSlug = link.slug;
            this.getCatalog()
            history.pushState(null, null, link.href);

            this.$refs.title.innerText = link.title
            this.toTop()
        },

        reset() {
            this.filter = JSON.parse(JSON.stringify(this.defaultFilter));
            this.setFilterToUrl()

            if (this.$refs.priceSlider)
                this.$refs.priceSlider.setUi()
            this.toTop()
        },

        toTop() {
            document.body.scrollIntoView();
        },
    },
});



app
    .mixin(Mixin)
    .mount("#catalog")