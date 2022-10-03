<template>
	<div class="col-span-6 grid grid-cols-6 gap-5">

		<f-label>
			<f-notice>
				Добавить на страницу информацию о партнёре
			</f-notice>
		</f-label>

		<f-label as="div" title="Партнёры" :error="form.errors.partner_id">
			<o-checkbox-list v-model="partner_id" :list="partners" single />
		</f-label>

		<f-label v-if="partner_id">
			<a :href="route('admin.partners.edit', partner_id)" target="_blank" class="btn-secondary">Редактировать выбранного партнёра</a>
		</f-label>

	</div>
</template>

<script>

	import OCheckboxList from '@/Elements/Other/CheckboxList'

	export default {

		components: {
			OCheckboxList,
		},

		props: ['form'],

		data() {
			return {
			}
		},

		computed: {
			partners() {
				return this.$page.props.partners.map(partner => {
					return {
						id: partner.id,
						title: partner.company_name + ' (' + partner.person_name + ')'
					}
				});
			},
			partner_id: {
				get() {
					return this.form.partner_id;
				},
				set(val) {
					this.form.partner_id = val[0] || null;
				},
			},
		}
	}

</script>
