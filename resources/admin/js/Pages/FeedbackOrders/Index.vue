<template>
	<app-layout title="Обратная связь">
		<index-section class="max-w-4xl">

			<template #title>Все заявки с форм</template>
			<template #subtitle>
				<div>Все заявки с форм на обратную связь, запросы на подписку</div>
			</template>

			<template #content>

				<t-pagination :pages="$page.props.list" class="border-t bg-gray-50" />

				<div v-if="$page.props.list.data.length"
					class="px-1 lg:px-6 py-10 bg-gray-50  border-t grid grid-cols-6 gap-4 xl:gap-6 load-opacity">
					<list-item v-for="element in $page.props.list.data" :key="element.id" :element="element" />
				</div>

				<div v-else class="w-full px-5 py-5 text-lg text-center bg-gray-50 text-gray-700">Данных ещё нет</div>

				<t-pagination :pages="$page.props.list" class="border-t bg-gray-50" />

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
	}
</script>
