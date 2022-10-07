<template>
	<app-layout title="Заказы товаров">
		<index-section class="max-w-4xl">

			<template #content>

				<list-item :element="item" class="-mb-10 shadow-none bg-transparent" single="1"/>

			</template>
		</index-section>
	</app-layout>
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
