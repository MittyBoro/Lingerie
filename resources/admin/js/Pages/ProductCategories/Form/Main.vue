<template>

	<div class="col-span-6 grid grid-cols-6 xl:grid-cols-4 gap-5">

		<FLabel title="Название" :error="form.errors.title">
			<FInput @change="stopSlugFromTitle" type="text" v-model="form.title" />
		</FLabel>

		<FLabel title="Ярлык" :error="form.errors.slug">
			<FInput @change="stopSlugFromTitle" type="text" classes="opacity-60 text-xs max-h-9" v-model="form.slug" />
		</FLabel>

		<FLabel title="Родительская категория" :error="form.errors.parent_id">
			<FSelect :options="categories" :keys="['id','title']" v-model="form.parent_id" />
		</FLabel>

		<FLabel title="Описание" :error="form.errors.description" as="div">
			<FTextareaEditor v-model="form.description" mini/>
		</FLabel>

		<FLabel title="Описание внизу" :error="form.errors.footer_description" as="div">
			<FTextareaEditor v-model="form.footer_description" mini/>
		</FLabel>

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

		computed: {
			categories() {
				let list = [...this.$page.props.list];

				list.unshift({ id: null, title: '---' });
				return list;
			},
		},

		methods: {
			stopSlugFromTitle() {
				this.editSlug = this.form.slug === '';
			},
		},
	}
</script>
