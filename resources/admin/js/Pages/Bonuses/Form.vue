<template>
	<app-layout title="Настройки" >

		<form-section :submit="submit" :form="form">
			<template #title>
				<div v-if="!isEdit">Добавить бонусы</div>
				<div v-else>Редактировать бонусы</div>
			</template>
			<template #subtitle>
				<div>
					<span>Для пользователя </span> <Link class="link" :href="route('admin.users.show', user.id)">{{ user.name }}</Link> <Link class="hover-link text-xs opacity-70" :href="route(routePrefix + 'index', { user_id: user.id })">[все бонусы]</Link>
				</div>
				<div v-if="order">
					<Link class="link" :href="route('admin.product_orders.show', order.id)">Заказ #{{ order.id }}</Link>
				</div>
			</template>

			<template v-if="isEdit" #buttons>
				<Link :href="route(routePrefix + 'create', { user_id: user.id })" class="btn">Добавить ещё</Link>
			</template>

			<template #content>

				<f-label title="Название" :error="form.errors.title">
					<f-input v-model="form.title" />
				</f-label>

				<f-label :title="'Дата окончания' + (end_at ? '' : ' (бессрочно)')" :error="form.errors.end_at">
					<f-input type="datetime-local" v-model="end_at" min="2010-01-01" max="2090-01-01" />
				</f-label>

				<f-label title="Кол-во баллов" :error="form.errors.amount">
					<f-input type="number" v-model="form.amount"/>
				</f-label>

			</template>

		</form-section>
	</app-layout>
</template>

<script>

	import AppLayout from '@/Layouts/AppLayout'
	import FormSection from '@/Layouts/Sections/Form'


	export default {
		components: {
			AppLayout,
			FormSection,
		},


		data() {

			return {
				routePrefix: 'admin.bonuses.',

				form: this.$inertia.form(this.$page.props.item || {
					title: null,
					amount: null,
					end_at: null,
					user_id: this.$page.props.user.id,
				}),

				isEdit: !!this.$page.props.item,

				user: this.$page.props.user,
				order: this.$page.props.order,
			}
		},

		computed: {
			end_at: {
				get() {
					return this.dateTimeToInput(this.form.end_at);
				},
				set(val) {
					this.form.end_at = this.inputDateToUTC(val);
				}
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
					.transform((data) => ({
						...data,
					}))
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

