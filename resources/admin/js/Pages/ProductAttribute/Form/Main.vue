<template>

	<div class="col-span-6 grid grid-cols-6 gap-4">

		<f-notice class="col-span-6 xl:col-span-4">
			Укажите <code class="monfont-mono font-semibold">%replace%</code> для замены на значение из дочернего элемента
		</f-notice>

		<f-label title="Название" :error="form.errors.title">
			<f-input @change="stopSlugFromTitle" type="text" v-model="form.title" />
		</f-label>

		<f-label title="Ярлык" :error="form.errors.slug">
			<f-input @change="stopSlugFromTitle" type="text" classes="opacity-60 text-xs max-h-9" v-model="form.slug" />
		</f-label>

		<!-- <f-label title="Скрытая страница?" :error="form.errors.is_hidden">
			<f-switcher v-model="form.is_hidden" secondary/>
			<f-notice v-text="'Не будет доступно для просмотра, рекомендуется для шаблонных страниц'" />
		</f-label> -->

		<f-label title="Описание" :error="form.errors.description" as="div">
			<f-textarea-editor v-model="form.description" />
		</f-label>

		<f-label title="Роутер" :error="form.errors.route">
			<f-input type="text" v-model="form.route" />
		</f-label>

	</div>


</template>

<script>

	import slugify from 'slugify'

	export default {

		props: ['form', 'isEdit'],

		data() {
			return {
				editSlug: !this.isEdit,
			}
		},

		watch: {
			'form.title'(val) {
				if (!this.isEdit && this.editSlug)
					this.form.slug = val
			},
			'form.slug'(val) {
				this.form.slug = slugify(val, {lower: true, strict: true});
			},
		},

		methods: {
			stopSlugFromTitle() {
				this.editSlug = this.form.slug === '';
			},
		},
	}
</script>

