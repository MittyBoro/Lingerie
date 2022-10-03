<template>
	<app-layout title="Промокоды" >
		<index-section class="max-w-3xl">

			<template #title>Промокоды</template>
			<template #subtitle>
				<div>Нажмите на ячейку, что бы редактировать</div>
			</template>
			<template #buttons>
				<button class="btn" @click="store">Добавить</button>
			</template>

			<template #content>
				<t-table :table="table">
					<template #row="sp">
						<t-data v-model="sp.element.code" @update:modelValue="update(sp.element)" />
						<t-data>
							<f-switcher v-model="sp.element.is_active" @update:modelValue="update(sp.element)" mini />
						</t-data>
						<t-data>
							<f-switcher v-model="sp.element.add_bonuses" @update:modelValue="update(sp.element)" mini secondary />
						</t-data>
					</template>
				</t-table>

			</template>
		</index-section>
	</app-layout>
</template>

<script>
	import AppLayout from '@/Layouts/AppLayout'
	import IndexSection from '@/Layouts/Sections/Index'

	export default {
		components: {
			AppLayout, IndexSection
		},

		data() {
			return {
				routePrefix: 'admin.promo_codes.',
			}
		},

		computed: {
			table() {
				return {
					headers: [
						{ key: 'code', text: 'Промокод', sortable: true },
						{ key: 'is_active', text: 'Активен', sortable: true },
						{ key: 'add_bonuses', text: 'Назначать бонусы' },
					],
					items: this.$page.props.list,

					destroyRoute: this.routePrefix + 'destroy',
				}
			}
		},

		methods: {
			store() {
				let form = this.$inertia.form({});

				form.post( route(this.routePrefix + 'store') , {
					preserveScroll: true,
				});
			},
			update(element) {
				let form = this.$inertia.form(element);

				form.put( route(this.routePrefix + 'update', element.id) , {
					preserveScroll: true,
				});
			},

		},
	}
</script>
