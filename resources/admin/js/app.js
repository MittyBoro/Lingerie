import { componentFromFolder } from './bootstrap';
import "../sass/app.sass";

// Import modules...

import { createApp, h } from 'vue';
import { createInertiaApp, Link } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from 'ziggy';

import Toast from "vue-toastification";
import MyMixin from "./Mixins/Mixin.js";

import Icon from './Elements/Icon'


createInertiaApp({
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),

    setup({ el, app, props, plugin }) {

        let createdApp = createApp({ render: () => h(app, props) });

        createdApp.config.globalProperties.$admin = {}

        createdApp
            .use(plugin)
            .use(ZiggyVue, Ziggy)

            .mixin({ methods: { route } })
            .mixin(MyMixin)
            .use(Toast)
            .component('Icon', Icon)
            .component('Link', Link)


        componentFromFolder(createdApp, import.meta.globEager('./Elements/Form/*.vue'), 'F')
        componentFromFolder(createdApp, import.meta.globEager('./Elements/Table/*.vue'), 'T')

        return createdApp.mount(el);
    },
});



InertiaProgress.init({ color: '#fff' });
