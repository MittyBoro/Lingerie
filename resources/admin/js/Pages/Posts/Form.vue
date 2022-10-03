<template>
	<app-layout title="Записи">

		<form-section :submit="submit" :form="form" :tabs="['Основное', 'Медиа', 'Партнёры', 'SEO']" v-model:activeTab="activeTab" :showLink="frontUrl('article/' + form.slug)">
			<template #title>
				<div v-if="!isEdit">Добавить</div>
				<div v-else>Редактировать</div>
			</template>
			<template #buttons>
				<Link v-if="isEdit" :href="route(routePrefix + 'create')" class="btn btn-gray ml-auto">Добавить ещё</Link>
			</template>

			<template #content>

				<TabMain v-show="activeTab == 'Основное'" :form="form" :isEdit="isEdit" />
				<TabMedia v-show="activeTab == 'Медиа'" :form="form" />
				<TabPartner v-show="activeTab == 'Партнёры'" :form="form" />
				<TabSEO v-show="activeTab == 'SEO'" :form="form" />

			</template>
		</form-section>

	</app-layout>
</template>

<script>

	import AppLayout from '@/Layouts/AppLayout'
	import FormSection from '@/Layouts/Sections/Form'

	import TabMain from './Form/Main'
	import TabMedia from './Form/Media'
	import TabPartner from './Form/Partner'
	import TabSEO from './Form/SEO'

	export default {
		components: {
			AppLayout,
			FormSection,

			TabMain,
			TabMedia,
			TabPartner,
			TabSEO,
		},

		data() {
			return {
				routePrefix: 'admin.posts.',

				form: this.$inertia.form(this.$page.props.item || {
					title: null,
					slug: null,
					is_published: false,
					published_at: new Date,

					preview: null,
					description: null,

					partner_id: null,

					photos: null,
					videos: null,

					meta_title: null,
					meta_keywords: null,
					meta_description: null,
				}),

				isEdit: !!this.$page.props.item,

				activeTab: null,
			}
		},

		methods: {

			submit() {
				this.isEdit ?
							this.update() :
							this.store()
			},

			store() {
				this.form
					.post(route(this.routePrefix + 'store'), {
						preserveState: (page) => Object.keys(page.props.errors).length,
					});
			},

			update() {
				this.form
					.transform((data) => ({
						...data,
						_method : 'PUT',
					}))
					.post(route(this.routePrefix + 'update', this.form.id), {
						preserveState: (page) => Object.keys(page.props.errors).length,
						preserveScroll: true,
					});
			},
		},
	}
</script>
