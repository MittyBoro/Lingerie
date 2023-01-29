export default {
    data() {
        return {
            manualPreloader: false
        }
    },

    created() {
        window.manualPreloader = true
    },

    mounted() {
        if (!this.manualPreloader)
            document.body.classList.remove('preload')
    },

    methods: {
        toSingular(word) {
            if (word.endsWith("ies")) {
                return word.slice(0, -3) + "y";
            } else if (word.endsWith("s")) {
                return word.slice(0, -1);
            } else if (word.endsWith("es")) {
                return word.slice(0, -2);
            }
            return word;
        },

        getProductOption(key) {
            return localStorage.getItem('product_' + key)
        },

        setProductOption(key, value) {
            localStorage.setItem('product_' + key, value)
        },


        formatPrice() {
            let price = [...arguments].reduce((a, b) => parseFloat(a) + parseFloat(b), 0);

            if (price) {
                price = Math.round(price);
                return new Intl.NumberFormat('ru-RU').format(price);
            }
            else
                return 0;
        },
    }
}
