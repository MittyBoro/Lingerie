
import { createApp, h } from 'vue';


const App = {
    data() {
        return {
            count: cartCount || '',
        };
    },

    mounted() {
        document.addEventListener('setCartCount', el => {
            this.count = el.detail.count;
        })
    },

};

if (document.querySelector('#head_cart'))
    createApp(App).mount("#head_cart");


