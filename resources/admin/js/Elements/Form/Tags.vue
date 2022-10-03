<template>
	<div class="form-input">
		<div @click.prevent class="flex items-center justify-between pl-3 py-1 my-1 ml-1 text-sm rounded bg-gray-100 text-gray-600 h"
			v-for="(word, i) in modelValue" :key="i">
			{{ word }}
			<span @click="removeAt(i)" class="flex flex-s items-center justify-center h-4 w-4 mx-2 bg-gray-300 rounded cursor-pointer">×</span>
		</div>

		<input
			class="px-3 py-1 my-1 ml-1 text-sm border-0 outline-none w-auto"
			@focus="focused = true" @blur="focused = false"
			@keydown.enter.prevent="setValue(currentWord)"
			@keydown.delete="removeByDel"
			v-model="currentWord"
			ref="input"
			onkeydown="this.style.width = ((this.value.length + 1) * 8) + 'px';"
		>

		<div :class="{ invisible: !focused }" v-if="options && options.length"
			class="options absolute w-full left-0 top-full z-50 border rounded-md shadow-lg text-gray-700 bg-white
				transition max-h-40 overflow-auto">
			<div
				class="block px-4 py-1 text-sm leading-5 cursor-pointer hover:bg-gray-100 transition"
				v-for="(option, i) in filterOptions"
				@click="setValue(option)"
				:key="i">
				{{ option }}
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		props: {
			modelValue: {
				type: Array,
				default: []
			},
			options: Array,
			classes: String,
			type: {
				type: String,
				default: 'text'
			},
			showAll: Boolean,
		},
		emits: ['update:modelValue'],

		data() {
			return {
				focused: false,
				currentWord: '',
				lastWord: '',
			}
		},

		watch: {
			focused() {
				if (this.focused)
					return;
				let beforeWord = this.currentWord;
				setTimeout(() => {
					if (beforeWord == this.currentWord)
						this.setValue(this.currentWord)
				}, 200);
			}
		},

		computed: {
			filterOptions() {

				if (!this.options) return;

				let options = new Array(...this.options);

				if (this.showAll)
					return options;

				let reg = new RegExp(this.currentWord, 'i')

				return options.filter( str =>
				{
					if (this.modelValue.indexOf( str ) >= 0) return false;
					return reg.test(str)
				});
			}
		},
 		methods: {

			setValue(value) {
				if (!value)
					return;

				let newMW = this.modelValue;
					newMW.push(value);

				this.$emit('update:modelValue', newMW);

				this.currentWord = '';

				setTimeout(() => {
					this.$refs.input.focus();
				}, 150);
			},

			removeAt(index) {
				let newMW = this.modelValue;
					newMW.splice(index, 1);

				this.$emit('update:modelValue', newMW);
			},

			removeByDel() {
				if (this.currentWord.length)
					return;
				let newMW = this.modelValue;
					newMW.pop()

				this.$emit('update:modelValue', newMW);
			},
		}
	}
</script>

<style lang="sass" scoped>
	.options
		transition: .15s
	.options:empty
		display: none
	.form-input
		@apply px-2 relative w-full flex flex-wrap items-center h-auto
	input
		width: auto
		min-width: 180px
</style>
