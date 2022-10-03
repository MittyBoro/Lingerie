<template>

	<div class="flex flex-wrap px-6 md:px-10 py-3">

		<label class="mr-8 my-2">
			<f-select @update:modelValue="setFilter" :options="roles" v-model.lazy="filter.role" />
		</label>

		<label class="my-2">
			<f-input placeholder="Поиск…" @update:modelValue="setFilter" v-model.lazy="filter.q" />
		</label>
	</div>

</template>

<script>

	export default {

		data() {
			let urlParams = new URLSearchParams(location.search);
			let filter = {
				q: urlParams.get('q'),
				role: urlParams.get('role') || '',
			};

			let roles = { '': 'Все роли', ...this.$page.props.roles}

			return {
				roles: roles,
				filter: Object.assign({
					q: '',
					role: '',
				}, filter)
			}
		},

		methods: {
			setFilter() {
				setTimeout(() => {
					let urlParams = new URLSearchParams(location.search);
					let params = Object.fromEntries(urlParams);

					let filter = Object.assign(params, this.filter);

					this.$inertia.visit( route(route().current(), filter ), {
						preserveState: true,
						preserveScroll: true,
					});
				}, 40);
			},
		},

	}
</script>

<style lang="sass" scoped>

	:deep(label)
		.text-sm
			@apply text-xs
		.form-input
			@apply max-h-7 pl-3 text-xs

</style>
