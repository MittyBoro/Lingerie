<template>
	<app-layout title="Пользователи" >
		<index-section class="max-w-5xl">

			<template #title>Пользователи</template>

			<template #content>

				<ListFilter v-if="table.items.length" class="border-t bg-gray-50" />

				<t-table :table="table">
					<template #row="sp">
						<t-data :title="sp.element.id" mini>
							<div class="min-w-max">
								<img :src="sp.element.avatar" class="h-7 w-7 border rounded-full object-cover" alt="">
							</div>
						</t-data>
						<t-data v-model="sp.element.name" @update:modelValue="update(sp.element)" />
						<!-- <t-data v-model="sp.element.username" @update:modelValue="update(sp.element)" /> -->
						<t-data v-model="sp.element.email" @update:modelValue="update(sp.element)" />
						<t-data v-text="roles[sp.element.role]" />
						<t-data>
							<Link class="btn btn-mini" :href="route('admin.product_orders.index', {user_id: sp.element.id})">{{ formatPrice(sp.element.paid) }}₽</Link>
						</t-data>
						<t-data>
							<Link class="btn btn-mini" :href="route('admin.bonuses.index', {user_id: sp.element.id})">{{ formatPrice(sp.element.bonuses) }}</Link>
						</t-data>
						<t-data>
							<div class="text-xs" v-text="formatDateTime(sp.element.created_at)"></div>
							<div v-if="!sp.element.email_verified_at" class="btn btn-mini mt-1" @click="verify(sp.element.id)">Подтв.email</div>
						</t-data>
						<t-data mini>
							<Link :href="route(routePrefix + 'show', sp.element.id)" class="text-gray-500 hover-link">
								<font-awesome-icon icon="eye"/>
							</Link>
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

	import ListFilter from './Index/ListFilter'

	export default {
		components: {
			AppLayout, IndexSection, ListFilter,
		},

		data() {
			return {
				routePrefix: 'admin.users.',
				roles: this.$page.props.roles,
			}
		},

		computed: {
			table() {
				return {
					headers: [
						{},
						{ key: 'name', text: 'Имя', sortable: true },
						// { key: 'username', text: 'Логин', sortable: true },
						{ key: 'email', text: 'Email', sortable: true },
						{ key: 'role', text: 'Роль', sortable: true },
						{ key: 'paid', text: 'Купили на', sortable: false },
						{ key: 'bonuses', text: 'Бонусов', sortable: true },
						{ key: 'created_at', fa: 'calendar-days', sortable: true, },
						{},
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
			verify(id) {
				this.$inertia.form().post( route(this.routePrefix + 'verify', id) , {
					preserveScroll: true,
				});
			},
		},
	}
</script>
