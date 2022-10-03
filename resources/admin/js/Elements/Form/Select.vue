<template>
	<select class="form-input w-full" :class="{'f-mini': mini}" v-model="selected">
		<option v-if="title" value="" disabled selected hidden>{{ title }}</option>
		<option v-if="showEmpty && !value"></option>
		<option v-for="option in optionsList" :value="optionValue(option.key)" :key="option.key">
			<span v-if="option.depth">{{ '-'.repeat(option.depth) }}</span>
			{{ option.value }}
		</option>
	</select>
</template>

<script>

	/**
	 * если есть «keys», то key/value для option берётся из них
	 * если каждый элемент массив, то key/value = [o]/[1]
	 * иначе зачение элемента = key = value
	 */

	export default {
		props: {
			modelValue: [String, Number],
			options: [Array, Object],
			keys: [Array, Object],
			title: String,
			mini: Boolean,
		},

		emits: ['update:modelValue'],

		data() {
			return {
				showEmpty: false,
			}
		},


		computed: {
			selected: {
				get() {
					return this.modelValue === null ? 'null' : this.modelValue
				},
				set(value) {
					if (value === 'null') {
						value = null;
					}
					this.$emit('update:modelValue', value);
				}
			},

			optionsList() {
				let list = this.options,
					keys = this.keys;

				if (typeof list === 'object' && list !== null && !list.length) {
					list = Object.entries(list);
					keys = [0, 1];
				} else if ( Array.isArray(list) && list.length && Array.isArray(list[0]) ) {
					keys = [0, 1];
				}

				if (keys) {
					let key = keys[0];
					let value = keys[1] || key;

					list = list.map((el) => {
						return {
							key: el[key],
							value: el[value],
							depth: el.depth,
						}
					})
				} else {
					list = list.map((el) => {
						return {
							key: el,
							value: el,
						}
					})
				}

				return list;
			}
		},

		methods: {
			optionValue(value) {
				if (value === null) {
					value = 'null';
				}
				return value;
			}
		}
	}
</script>

<style lang="sass" scoped>
	select.form-input
		background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e")
		background-repeat: no-repeat
		background-position: right 0.5rem center
		background-size: 1.5em 1.5em
		padding-top: 0
		padding-bottom: 0
		padding-right: 2.5rem
</style>
