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

            locationSearch: window.location.search,

            catalogLink: {
                slug: '',
                href: this.localePath('catalog'),
            }
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

            this.$refs.mobiCat.classList.remove('active')
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

            this.$refs.title.innerText = link.title || this.$refs.title.dataset?.default

            this.resetFilter()

            // после сброса фильтра не обновлять ещё раз
            setTimeout(() => {
                if (this.timerId) {
                    this.timerId = clearInterval(this.timerId);
                }
            }, 50);
        },

        resetFilter() {
            this.filter = JSON.parse(JSON.stringify(this.defaultFilter));
            this.filterToUrl()

            if (this.$refs.priceSlider)
                this.$refs.priceSlider.setUi()

            this.toTop()
        },


        mobileFiltering() {
            this.listenFilter = true;
            this.filtering()
            this.toTop()
        },

        stopListeningFilter() {
            this.listenFilter = false;
        },

        toTop() {
            let y = this.$el.getBoundingClientRect().top + window.pageYOffset - 50;
            if (window.scrollY > y)
                window.scrollTo({top: y, behavior: 'smooth'});
        },
    },
});



app
    .mixin(Mixin)
    .mount("#catalog")
