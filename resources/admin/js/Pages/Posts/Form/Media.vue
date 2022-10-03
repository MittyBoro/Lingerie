<template>
	<div class="col-span-6 grid grid-cols-6 gap-4">

		<f-label title="Фотографии" :error="form.errors.photos">
			<f-file-input v-model="form.photos" isImage multiple/>
		</f-label>

		<f-label title="Видео" :error="form.errors.videos">
			<f-file-input v-model="form.videos" multiple accept="video/*"/>
		</f-label>

	</div>
</template>

<script>

	export default {

		props: ['form'],

	}
</script>

