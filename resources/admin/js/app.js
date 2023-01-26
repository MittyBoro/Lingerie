import { componentFromFolder } from './bootstrap';
import "../sass/app.sass";

// Import modules...

import { createApp, h } from 'vue';
import { createInertiaApp, Link } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

import { ZiggyVue } from 'ziggy';

import Toast from "vue-toastification";

import Icon from './Elements/Icon'

import MixinFormat from "./Mixins/General/Format.js";
import MixinMain from "./Mixins/General/Main.js";
import MixinRouting from "./Mixins/General/Routing.js";

import.meta.glob([
    '../images/favicon.svg',
  ]);


createInertiaApp({
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {

        let createdApp = createApp({ render: () => h(App, props) });

        createdApp.config.globalProperties.$admin = {}

        createdApp
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(Toast)

            .mixin({ methods: { route } })
            .mixin(MixinFormat)
            .mixin(MixinMain)
            .mixin(MixinRouting)
            .component('Icon', Icon)
            .component('Link', Link)


        componentFromFolder(createdApp, import.meta.globEager('./Elements/Form/*.vue'), 'F')
        componentFromFolder(createdApp, import.meta.globEager('./Elements/Table/*.vue'), 'T')
        componentFromFolder(createdApp, import.meta.globEager('./Elements/Main/*.vue'), 'M')

        return createdApp.mount(el);
    },
    progress: {
        color: '#fff',
    },
});

