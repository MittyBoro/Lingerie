<template>
	<textarea
		:class="{'resize-none overflow-hidden': autoResize, 'form-input w-full leading-5': addClasses }"
		:style="{minHeight: parseInt(rows) > 1 ? '72px' : '1em' }"
		v-bind="$attrs"
		:rows="rows"
		:value="modelValue"
		@input="onInput"
		@change="onInput($event, 'change')"
		></textarea>
</template>

<script>
export default {
	props: {
		modelValue: null,
		modelModifiers: {
			type: Object,
			default: {}
		},
		autoResize: {
			type: Boolean,
			default: true
		},
		rows: {
			default: '4'
		},
		addClasses: {
			type: Boolean,
			default: true
		}
	},
	emits: ['update:modelValue', 'change'],
	mounted() {
		this.resize();

		new ResizeObserver(entries => {
			this.resize()
		}).observe(document.body);
	},
	updated() {
		this.resize();
	},
	methods: {
		resize() {
			if ( !this.autoResize )
				return;

			const style = window.getComputedStyle(this.$el);
			this.$el.style.height = 'auto';
			this.$el.style.height = `calc(${style.borderTopWidth} + ${style.borderBottomWidth} + ${this.$el.scrollHeight}px)`;

			if (parseFloat(this.$el.style.height) >= parseFloat(this.$el.style.maxHeight)) {
				this.$el.style.overflowY = "scroll";
				this.$el.style.height = this.$el.style.maxHeight;
			}
			else
				this.$el.style.overflow = "hidden";
		},
		onInput(event, type = 'input') {
			if (this.autoResize) {
				this.resize();
			}

			let value = event.target.value;

			if (this.modelModifiers.lazy) {
				if (type == 'change') {
					this.$emit('update:modelValue', value);
				}
			} else {
				this.$emit('update:modelValue', value);
			}
		}
	},
}
</script>
