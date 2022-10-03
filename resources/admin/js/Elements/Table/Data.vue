<template>
	<td :class="{'w-min': mini}">
		<div v-if="modelValue !== undefined">
			<div class="max-h-0 overflow-hidden invisible" v-html="modelValue"></div>
			<div class="-mx-2">
				<f-textarea
					rows="1"
					@update:modelValue="$emit('update:modelValue', $event)"
					v-model.lazy="modelValue"
					:disabled="disabled"
				/>
			</div>
		</div>
		<template v-else>
			<slot></slot>
		</template>
	</td>
</template>

<script>

	export default {

		props: {
			modelValue: [String, Number],
			mini: Boolean,
			disabled: Boolean,
		},

		emits: ['update:modelValue'],

	}
</script>

<style lang="sass" scoped>

	textarea
		@apply bg-transparent block border-0 w-full rounded-sm shadow-none px-2 py-1 align-middle
		font-size: inherit
		&:not(:focus):hover
			@apply ring-primary-500 ring-opacity-20 ring bg-white bg-opacity-40
		&:disabled
			@apply bg-transparent pointer-events-none opacity-50

</style>
