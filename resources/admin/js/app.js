require('./bootstrap');

// Import modules...
import { createApp, h } from 'vue';
import { App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { Link } from '@inertiajs/inertia-vue3'

import Toast from "vue-toastification";

import MyMixin from "./Mixins/Mixin.js";

import "../sass/app.sass";


// fortawesome
import { library } from '@fortawesome/fontawesome-svg-core'
import { fas } from '@fortawesome/free-solid-svg-icons'
import { fab } from '@fortawesome/free-brands-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
library.add(fas, fab)




const el = document.getElementById('app');

const app = createApp({
	render: () =>
		h(InertiaApp, {
			initialPage: JSON.parse(el.dataset.page),
			resolveComponent: (name) => require(`./Pages/${name}`).default,
		}),
});


InertiaProgress.init({ color: '#fff' });

app.mixin({ methods: { route } });
app.mixin(MyMixin);
app.use(InertiaPlugin);
app.use(Toast);

app.component('font-awesome-icon', FontAwesomeIcon)



const componentFromFolder = (requireComponent, prefix) => {

	requireComponent.keys().forEach(fileName => {
		let componentConfig = requireComponent(fileName)
		let componentName = _.upperFirst(
			_.camelCase( fileName.split('/').pop().replace(/\.\w+$/, '') )
		)

		app.component(
			prefix + componentName,
			componentConfig.default || componentConfig
		)
	})
}

componentFromFolder(require.context('./Elements/Form', false, /.*\.vue$/), 'F')
componentFromFolder(require.context('./Elements/Table', false, /.*\.vue$/), 'T')


app.component('Link', Link)


app.mount(el);
