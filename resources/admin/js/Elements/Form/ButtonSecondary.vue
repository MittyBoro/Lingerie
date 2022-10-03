<template>
	<button :type="type" class="btn-secondary">
		<slot></slot>
	</button>
</template>

<script>
	export default {
		props: {
			type: {
				type: String,
				default: 'submit',
			},
		}
	}
</script>
