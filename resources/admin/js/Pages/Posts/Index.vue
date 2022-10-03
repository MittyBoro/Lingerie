<template>
	<app-layout title="Блог" >
		<index-section class="max-w-3xl">

			<template #title>Записи</template>
			<template #buttons>
				<Link :href="route(routePrefix + 'create')" class="btn">Добавить</Link>
			</template>

			<template #content>

				<t-table :table="table">
					<template #row="sp">
						<t-data :title="sp.element.id" mini>
							<div class="min-w-max">
								<img :src="sp.element.preview" class="h-8 w-8 rounded borderobject-cover" alt="">
							</div>
						</t-data>
						<t-data v-model="sp.element.title" @update:modelValue="update(sp.element)" />
						<t-data mini>
							<f-switcher v-model="sp.element.is_published" @update:modelValue="update(sp.element)" mini/>
						</t-data>
						<t-data class="text-xs" v-text="formatDate(sp.element.published_at)" />
						<t-data mini>
							<a :href="frontUrl('article/' + sp.element.slug)" target="_blank" class="text-gray-500 hover-link">
								<font-awesome-icon icon="eye"/>
							</a>
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
				routePrefix: 'admin.posts.',
				roles: this.$page.props.roles,
			}
		},

		computed: {
			table() {
				return {
					headers: [
						{},
						{ key: 'title', text: 'Название',  sortable: true },
						{ key: 'is_published', fa: 'eye', sortable: true, class: 'text-center' },
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
		},
	}
</script>
