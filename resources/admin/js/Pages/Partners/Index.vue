<template>
	<app-layout title="Партнёры">
		<index-section>

			<template #title>Все партнёры</template>
			<template #subtitle>
				<div>Здесь собраны дистрибьюторы и франчайзи</div>
				<div>Воспользуйтесь фильтром, что бы вывести конкретных людей</div>
			</template>
			<template #buttons>
				<Link :href="route(routePrefix + 'create')" class="btn">Добавить</Link>
			</template>

			<template #content>

				<ListFilter v-if="table.items.length" class="border-t bg-gray-50" />

				<t-table :table="table">
					<template #row="sp">
						<t-data v-model="sp.element.person_name" @update:modelValue="update(sp.element)" />
						<t-data v-model="sp.element.city" @update:modelValue="update(sp.element)" />
						<t-data v-model="sp.element.company_name" @update:modelValue="update(sp.element)" :disabled="!sp.element.is_franchisee" />
						<t-data v-model="sp.element.address" @update:modelValue="update(sp.element)" :disabled="!sp.element.is_franchisee" />
						<t-data mini>
							<f-switcher v-model="sp.element.is_franchisee" @update:modelValue="update(sp.element)" mini/>
						</t-data>
						<t-data mini>
							<f-switcher v-model="sp.element.is_distributor" @update:modelValue="update(sp.element)" secondary mini/>
						</t-data>
						<t-data mini>
							<f-switcher v-model="sp.element.is_published" @update:modelValue="update(sp.element)" secondary mini/>
						</t-data>
						<t-data class="text-xs text-center" v-text="formatDate(sp.element.created_at)" />
					</template>
				</t-table>

			</template>
		</index-section>
	</app-layout>
</template>

<script>

	import AppLayout from '@/Layouts/AppLayout'
	import IndexSection from '@/Layouts/Sections/Index'

	import ListFilter from './Index/ListFilter'

	export default {
		components: {
			AppLayout, IndexSection, ListFilter,
		},

		data() {
			return {
				routePrefix: 'admin.partners.',
			}
		},

		computed: {
			table() {
				return {
					headers: [
						{ key: 'person_name', text: 'Имя Фамилия',  sortable: true },
						{ key: 'city', text: 'Город',  sortable: true },
						{ key: 'company_name', text: 'Компания',  sortable: true },
						{ key: 'address', text: 'Адрес',  sortable: true },
						{ key: 'is_franchisee', text: 'Франч',  sortable: true },
						{ key: 'is_distributor', text: 'Дист',  sortable: true },
						{ key: 'is_published', fa: 'eye', sortable: true, class: 'text-center' },
						{ key: 'created_at', fa: 'calendar-days', sortable: true },
					],
					items: this.$page.props.list.data,
					pagination: this.$page.props.list,

					editRoute: this.routePrefix + 'edit',
					destroyRoute: this.routePrefix + 'destroy',
				}
			}
		},

		methods: {
			update(item) {
				item.index_edit = true;

				let form = this.$inertia.form(item);

				form.put( route(this.routePrefix + 'update', item.id) , {
					preserveScroll: true,
				});
			},
		}
	}
</script>
