<template>
	<AppLayout title="Заказы товаров">
		<IndexSection class="max-w-4xl">

			<template #content>

				<ListItem :element="item" class="-mb-10 shadow-none bg-transparent" single="1"/>

			</template>
		</IndexSection>
	</AppLayout>
</template>

<script>

	import AppLayout from '@/Layouts/AppLayout'
	import IndexSection from '@/Layouts/Sections/Index'

	import ListItem from './ListItem'

	export default {
		components: {
			AppLayout,
			IndexSection,
			ListItem,
		},

		data() {
			return {
				item: this.$page.props.item,
			}
		},
	}
</script>
