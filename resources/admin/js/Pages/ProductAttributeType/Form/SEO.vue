<template>
	<div class="col-span-6 grid grid-cols-6 gap-5">

		<f-notice class="col-span-6 xl:col-span-4">
			Укажите <code class="monfont-mono font-semibold">%replace%</code>, для замены на значение из дочернего элемента
		</f-notice>

		<f-label title="Meta title" :error="form.errors.meta_title">
			<f-input type="text" v-model="form.meta_title" />
		</f-label>

		<f-label title="Meta keywords" :error="form.errors.meta_keywords">
			<f-input type="text" v-model="form.meta_keywords" />
		</f-label>

		<f-label title="Meta description" :error="form.errors.meta_description">
			<f-textarea rows="3" v-model="form.meta_description" />
		</f-label>

	</div>
</template>


<script>

	export default {

		props: ['form'],

	}

</script>

