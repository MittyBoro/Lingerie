<template>
	<app-layout title="Партнёры">

		<form-section :submit="submit" :form="form">
			<template #title>
				<div v-if="!isEdit">Добавить</div>
				<div v-else>Редактировать</div>
			</template>
			<template #buttons>
				<Link v-if="isEdit" :href="route(routePrefix + 'create')" class="btn btn-gray ml-auto">Добавить ещё</Link>
			</template>

			<template #content>

				<f-label as="div" class="grid grid-cols-6 xl:grid-cols-8 gap-3">

					<f-label title="Имя Фамилия" :error="form.errors.person_name">
						<f-input type="text" v-model="form.person_name" autocomplete="off"/>
					</f-label>

					<f-label title="Город" :error="form.errors.city">
						<f-input type="text" v-model="form.city" autocomplete="off"/>
					</f-label>

					<f-label title="Название компании" :error="form.errors.company_name">
						<f-input type="text" v-model="form.company_name" :disabled="!form.is_franchisee" autocomplete="off"/>
					</f-label>

					<f-label title="Адрес" :error="form.errors.address">
						<f-input type="text" v-model="form.address" :disabled="!form.is_franchisee" autocomplete="off"/>
					</f-label>
				</f-label>

				<f-label as="div" class="grid grid-cols-3 gap-4">
					<!-- is_franchisee -->
					<f-label title="Франчайзи" :error="form.errors.is_franchisee" classes>
						<f-switcher v-model="form.is_franchisee" secondary />
					</f-label>
					<!-- is_distributor -->
					<f-label title="Дистрибьютор" :error="form.errors.is_distributor" classes>
						<f-switcher v-model="form.is_distributor" secondary />
					</f-label>
					<!-- is_published -->
					<f-label title="Опубликован" :error="form.errors.is_published" classes>
						<f-switcher v-model="form.is_published" />
					</f-label>
				</f-label>

				<f-label title="Описание" :error="form.errors.description" as="div">
					<f-textarea-editor v-model="form.description" mini/>
				</f-label>

				<!-- information -->
				<information v-model="form.information" />

			</template>
		</form-section>

	</app-layout>
</template>

<script>

	import AppLayout from '@/Layouts/AppLayout'
	import FormSection from '@/Layouts/Sections/Form'

	import Information from "./Form/Information";

	export default {
		components: {
			AppLayout,
			FormSection,

			Information,
		},


		data() {
			return {
				routePrefix: 'admin.partners.',

				form: this.$inertia.form(this.$page.props.item || {
					person_name: null,
					company_name: null,
					description: null,

					city: null,
					address: null,

					information: null,

					is_franchisee: false,
					is_distributor: false,
					is_published: false,
				}),

				isEdit: !!this.$page.props.item?.id,
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
						preserveScroll: true,
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

