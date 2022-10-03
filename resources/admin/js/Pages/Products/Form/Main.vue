<template>

	<div class="col-span-6 grid grid-cols-6 gap-5">

		<!-- Title -->
		<f-label title="Название" :error="form.errors.title">
			<f-input @change="stopSlugFromTitle" type="text" v-model="form.title" />
		</f-label>

		<!-- Slug -->
		<f-label title="Ярлык" :error="form.errors.slug">
			<f-input @change="stopSlugFromTitle" type="text" classes="opacity-60 text-xs max-h-9" v-model="form.slug" />
		</f-label>

		<div class="col-span-6 xl:col-span-4 grid grid-cols-6 gap-4">
			<!-- is_published -->
			<f-label classes="col-span-3 md:col-span-2" title="Опубликовано?" :error="form.errors.is_published">
				<f-switcher v-model="form.is_published" />
			</f-label>
			<!-- is_stock -->
			<f-label classes="col-span-3 md:col-span-2" title="Наличие" :error="form.errors.is_stock">
				<f-switcher v-model="form.is_stock" secondary/>
			</f-label>
		</div>

		<!-- gallery -->
		<f-label title="Фотографии" :error="form.errors.gallery">
			<f-file-input :isImage="true" v-model="form.gallery" multiple/>
		</f-label>

		<!-- categories -->
		<f-label as="div" title="Категория" :error="form.errors.categories">
			<o-checkbox-list v-model="form.categories" :list="categories" />
		</f-label>

	</div>

</template>

<script>

	import slugify from 'slugify'
	import OCheckboxList from '@/Elements/Other/CheckboxList'

	export default {

		components: {
			OCheckboxList,
		},

		props: ['form', 'isEdit'],

		data() {
			return {
				editSlug: !this.isEdit,

				categories: this.$page.props.categories,
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

