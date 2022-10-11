<template>

	<div class="col-span-6 grid grid-cols-6 gap-5">

		<!-- Title -->
		<FLabel title="Название" :error="form.errors.title">
			<FInput @change="stopSlugFromTitle" type="text" v-model="form.title" />
		</FLabel>

		<!-- Slug -->
		<FLabel title="Ярлык" :error="form.errors.slug">
			<FInput @change="stopSlugFromTitle" type="text" classes="opacity-60 text-xs max-h-9" v-model="form.slug" />
		</FLabel>

		<div class="col-span-6 xl:col-span-4 grid grid-cols-6 gap-4">
			<!-- is_published -->
			<FLabel classes="col-span-3 md:col-span-2" title="Опубликовано?" :error="form.errors.is_published">
				<FSwitcher v-model="form.is_published" />
			</FLabel>
			<!-- is_stock -->
			<FLabel classes="col-span-3 md:col-span-2" title="Наличие" :error="form.errors.is_stock">
				<FSwitcher v-model="form.is_stock" secondary/>
			</FLabel>
		</div>

		<!-- gallery -->
		<FLabel title="Фотографии" :error="form.errors.gallery">
			<FFileInput :isImage="true" v-model="form.gallery" multiple/>
		</FLabel>

		<!-- categories -->
		<FLabel as="div" title="Категория" :error="form.errors.categories">
			<o-checkbox-list v-model="form.categories" :list="categories" />
		</FLabel>

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

