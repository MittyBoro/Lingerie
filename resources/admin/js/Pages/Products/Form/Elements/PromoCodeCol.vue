<template>
	<f-label :title="code.code" classes="text-xs">
		<f-input classes="text-xs max-h-9" type="number" v-model.number="price" mini />
	</f-label>
</template>

<script>

	export default {

		props: {
			code: Object,
			modelValue: {
				type: Array,
				default: [],
			},
		},

		emits: ['update:modelValue'],

		computed: {
			price: {
				get() {
					if (!this.modelValue)
						return 0;

					let currentPromo = this.modelValue.find(el => el && el.promo_code_id == this.code.id);

					return currentPromo ? currentPromo.price : 0;
				},
				set(val) {
					let promocodes = JSON.parse(JSON.stringify(this.modelValue));

					let push = true;

					promocodes = promocodes.map(el => {
						if (el.promo_code_id == this.code.id) {
							el.price = val;
							push = false;
						}
						return el;
					});

					if (push) {
						promocodes.push({
							promo_code_id: this.code.id,
							price: val,
						});
					}

					this.$emit('update:modelValue', promocodes)
				}
			}
		},

	}
</script>
