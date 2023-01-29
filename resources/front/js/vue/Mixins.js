export default {
    data() {
        return {
        }
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
        }
    }
}
