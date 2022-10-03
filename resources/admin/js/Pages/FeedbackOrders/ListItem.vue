<template>

	<div class="col-span-6 rounded-xl shadow-lg bg-white overflow-hidden py-8 px-3 md:px-8">

		<div class="flex items-baseline mb-1">
			<div class="font-bold text-lg mr-3">#{{ element.id }}: {{ element.form_name }}</div>
			<font-awesome-icon @click="destroy(item)" icon="trash-can" class="text-gray-500 hover:text-primary-500 transition cursor-pointer ml-auto"/>
		</div>

		<div class="text-sm text-gray-500 mb-5">{{ formatDateTime(element.created_at) }}</div>

		<div class="customer-info gap-y-3 max-w-2xl">
			<template v-if="element.name">
				<div class="ci-title">Имя:</div>
				<div>{{ element.name }}</div>
			</template>
			<template v-if="element.phone">
				<div class="ci-title">Телефон:</div>
				<div>{{ element.phone }}</div>
			</template>
			<template v-if="element.email">
				<div class="ci-title">Email:</div>
				<div>{{ element.email }}</div>
			</template>
			<template v-if="element.city">
				<div class="ci-title">Город:</div>
				<div>{{ element.city }}</div>
			</template>
			<template v-if="element.comment">
				<div class="ci-title">Примечание:</div>
				<div class="whitespace-pre-line">{{ element.comment }}</div>
			</template>

		</div>

	</div>

</template>

<script>

	import moment from 'moment';

	export default {

		props: ['element'],

		methods: {
			destroy() {
				if (!confirm('Вы уверены?'))
					return;

				let form = this.$inertia.form({});
				form.delete(route('admin.feedback_orders.destroy', this.element.id), {
					preserveScroll: true,
				})
			},
		}
	}
</script>
