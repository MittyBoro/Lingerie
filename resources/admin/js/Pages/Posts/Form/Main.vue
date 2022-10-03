<template>
	<div class="col-span-6 grid grid-cols-6 gap-4">

		<f-label title="Название" :error="form.errors.title">
			<f-input @change="stopSlugFromTitle" type="text" v-model="form.title" />
		</f-label>

		<f-label title="Ярлык" :error="form.errors.slug">
			<f-input @change="stopSlugFromTitle" type="text" classes="opacity-60 text-xs max-h-9" v-model="form.slug" />
		</f-label>

		<f-label title="Опубликовано?" :error="form.errors.is_hidden">
			<f-switcher v-model="form.is_published"/>
		</f-label>

		<f-label title="Дата публикации" :error="form.errors.published_at">
			<f-input placeholer="ДД.ММ.ГГГ" type="date" v-model="published_at" min="2010-01-01" max="2090-01-01" />
		</f-label>

		<f-label title="Превью" :error="form.errors.preview">
			<f-file-input :isImage="true" v-model="form.preview"/>
		</f-label>

		<f-label title="Описание" :error="form.errors.description" as="div">
			<f-textarea-editor v-model="form.description" />
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

		computed: {
			published_at: {
				get() {
					return this.dateToInput(this.form.published_at);
				},
				set(val) {
					this.form.published_at = val;
				}
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

