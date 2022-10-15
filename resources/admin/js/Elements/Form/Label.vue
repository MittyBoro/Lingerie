<template>
	<component :is="as" :class="classes" class="text-sm">
		<div v-if="title" class="font-semibold text-gray-700 mb-1">{{ title }}</div>
		<slot></slot>
		<FInputError v-if="error" :message="error" class="mt-2" />
	</component>
</template>

<script>
    export default {
        props: {
			title: String,
			error: String,
			as: {
				type: String,
				default: 'label'
			},
			classes: {
				type: String,
				default: 'flex flex-col'
			},
		}
    }
</script>
