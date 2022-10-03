<template>
	<div v-if="hasErrors">

		<div class="px-4 py-3 rounded-xl bg-red-600 text-red-100">
			<div class="font-semibold">Упс! Что-то пошло не так.</div>

			<ul class="mt-2 list-none text-sm">
				<li v-for="(error, key) in errors" :key="key">{{ error }}</li>
			</ul>
		</div>

	</div>
</template>

<script>
	export default {
		computed: {
			errors() {
				return this.$page.props.errors || {}
			},

			hasErrors() {
				return Object.keys(this.errors).length > 0;
			},
		}
	}
</script>
