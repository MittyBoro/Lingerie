<template>
	<AppLayout title="Товары" >
		<IndexSection class="max-w-5xl">

			<template #title>Товары</template>
			<template #buttons>
				<Link :href="route(routePrefix + 'create')" class="btn">Добавить</Link>
			</template>


			<template #content>

				<ListFilter v-if="table.items.length" class="border-t bg-gray-50" />

				<TTable :table="table">
					<template #row="sp">
						<TData :title="sp.element.id" mini>
							<div class="min-w-max">
								<img :src="sp.element.preview" class="h-8 w-8 rounded borderobject-cover" alt="">
							</div>
						</TData>
						<TData v-model="sp.element.title" @update:modelValue="update(sp.element)" />
						<TData>
							<span class="whitespace-nowrap">
								<span v-if="sp.element.variations_count > 1">от</span>
								{{ formatPrice(sp.element.min_price) }}₽
							</span>
						</TData>
						<TData mini>
							<FSwitcher v-model="sp.element.is_published" @update:modelValue="update(sp.element)" mini/>
						</TData>
						<TData mini>
							<FSwitcher v-model="sp.element.is_stock" @update:modelValue="update(sp.element)" mini secondary/>
						</TData>
						<TData mini>
							<a :href="frontUrl('product/' + sp.element.slug)" target="_blank" class="text-gray-500 hover-link">
								<font-awesome-icon icon="eye"/>
							</a>
						</TData>
					</template>
				</TTable>

			</template>

		</IndexSection>
	</AppLayout>
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
				routePrefix: 'admin.products.',
				roles: this.$page.props.roles,
			}
		},

		computed: {
			table() {
				return {
					headers: [
						{},
						{ key: 'title', text: 'Название',  sortable: true },
						{ key: 'price', text: 'Цена',  sortable: true },
						{ key: 'is_published', fa: 'eye', sortable: true, class: 'text-center' },
						{ key: 'is_stock', fa: 'flag', sortable: true, class: 'text-center' },
						{},
					],
					items: this.$page.props.list.data,
					pagination: this.$page.props.list,

					sortRoute: this.routePrefix + 'sort',
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
