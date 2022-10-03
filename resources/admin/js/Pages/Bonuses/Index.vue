<template>
	<app-layout title="Бонусы">
		<index-section>

			<template #title>Все зачисленные бонусы</template>
			<template v-if="user" #buttons>
				<Link :href="route(routePrefix + 'create', { user_id: user.id })" class="btn">Добавить</Link>
			</template>
			<template v-if="user" #subtitle>
				<div>
					<span>Бонусы пользователя <Link class="link" :href="route('admin.users.show', user.id)">{{ user.name }}</Link></span>
				</div>
				<div>Всего: {{ user.bonuses }}</div>
			</template>

			<template #content>

				<t-table :table="table">
					<template #row="sp">
						<t-data v-model="sp.element.title" @update:modelValue="update(sp.element)" />
						<t-data v-model="sp.element.amount" @update:modelValue="update(sp.element)" />
						<t-data v-if="!user">
							<Link class="link" :href="route('admin.users.show', sp.element.user.id)">{{ sp.element.user.name }}</Link>
						</t-data>
						<t-data>
							<Link v-if="sp.element.order" class="link" :href="route('admin.product_orders.show', sp.element.order.id)">#{{ sp.element.order.id }}</Link>
						</t-data>
						<t-data class="text-xs" v-text="formatDateTime(sp.element.created_at)" />
						<t-data class="text-xs">
							<div v-if="sp.element.end_at" v-text="formatDateTime(sp.element.end_at)"></div>
							<div v-else>Бессрочно</div>
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
			AppLayout, IndexSection,
		},

		data() {
			return {
				routePrefix: 'admin.bonuses.',
			}
		},

		computed: {
			table() {

				let headers = [
						{ key: 'title', text: 'Заголовок',  sortable: true },
						{ key: 'amount', text: 'Кол-во баллов',  sortable: true },
					];

				if (!this.user)
					headers.push({ key: 'user_id', text: 'Пользователь' });

				headers = [
						...headers,
						{ key: 'order_id', text: 'Заказ', },
						{ key: 'created_at', text: 'Создано',  sortable: true },
						{ key: 'end_at', text: 'Действует до',  sortable: true },
					];

				return {
					headers: headers,
					items: this.$page.props.list.data,
					pagination: this.$page.props.list,

					editRoute: this.routePrefix + 'edit',
					destroyRoute: this.routePrefix + 'destroy',
				}
			},

			user() {
				return this.$page.props.user
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
