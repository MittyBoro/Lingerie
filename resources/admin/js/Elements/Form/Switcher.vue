<template>
	<label
		class="flex items-center cursor-pointer" :class="{secondary: secondary !== false}" >
		<div class="relative">
			<input
				type="checkbox"
				class="hidden"
				@input="(event) => $emit('update:modelValue', !!event.target.checked)"
				:checked="modelValue"
			/>
			<div
				:class="[mini ? 'w-7 h-4' : 'w-12 h-7']"
				class="toggle__line bg-gray-300 rounded-full inner transition"></div>
			<div
				:class="[mini ? 'w-3 h-3 left-0.5' : 'w-5 h-5 left-1']"
				class="toggle__dot absolute my-auto bg-white rounded-full shadow inset-y-0 transition pointer-events-none"></div>
		</div>
	</label>
</template>

<script>

export default {
	props: {
		modelValue:  {
			default: false,
		},
		secondary: Boolean,
		mini: Boolean,
	},
	emits: ['update:modelValue'],
}

</script>


<style lang="sass" scoped>

	input:checked ~ .toggle__line
		@apply bg-primary-500 transition
		&:hover
			@apply bg-primary-600
	input:checked ~ .toggle__dot
		transform: translateX(100%)
	.secondary
		input:checked ~ .toggle__line
			@apply bg-secondary-600
			&:hover
				@apply bg-secondary-700

</style>
