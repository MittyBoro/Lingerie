<template>
	<div class="grid gap-2 md:grid-cols-2">
		<f-label title="Тип" classes>
			<f-select :options="info_types" :keys="[0, 1]" v-model="element.type" required mini />
		</f-label>

		<f-label title="Значение" classes>
			<f-input :placeholder="placeholder" v-model="element.value" @update:modelValue="element.value = valueByType($event)" required mini />
		</f-label>
	</div>
</template>

<script>

	import {parsePhoneNumberFromString} from 'libphonenumber-js';


	export default {

		props: ['modelValue'],
		emits: ['update:modelValue'],
		data() {
			return {
				info_types: Object.entries(this.$page.props.info_types),
			}
		},

		watch: {
			modelValue: {
				deep: true,
				handler() {
					if (!this.modelValue.type)
						this.setTypeForEmpty(this.modelValue.value);
				}
			}
		},

		computed: {
			element: {
				get() {
					return this.modelValue;
				},
				set(val) {
					this.$emit('update:modelValue', val);
				},
			},

			placeholder() {
				if (this.element.type == 'phone')
					return '+7 ... ... .. ..';
				if (this.element.type == 'vk')
					return 'https://vk.com/...';
				if (this.element.type == 'instagram')
					return 'https://instagram.com/...';
				if (this.element.type == 'url')
					return 'https://...';
				return '';
			},
		},

		mounted() {
			if (!this.modelValue.type)
				this.setTypeForEmpty(this.modelValue.value);

			this.element.value = this.valueByType(this.element.value)

		},

		methods: {

			formattingPhone( value ) {
				let phone = parsePhoneNumberFromString(value, 'RU');
				if (!phone)
					return value
				return phone.formatInternational();
			},

			formattingUrl( value ) {
				let trimmed = value.trim();
				if (this.isUrl(trimmed) && !this.isParseUrl(trimmed)) {
					value = 'http://' + trimmed;
				}
				return value;
			},

			isUrl( str ) {
				let pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
					'((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
					'((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
					'(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
					'(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
					'(\\#[-a-z\\d_]*)?$','i'); // fragment locator
				return pattern.test(str);
			},

			isParseUrl( str ) {
				let url;
				try {
					url = new URL(str);
				} catch (_) {
					return false;
				}
				return url.protocol === "http:" || url.protocol === "https:";
			},

			setTypeForEmpty( str ) {
				if (this.isUrl(str)) {
					str = this.formattingUrl(str);
					let url = new URL(str);

					if (url.host == "vk.com") {
						this.element.type = 'vk';
					} else if (url.host == "instagram.com") {
						this.element.type = 'instagram';
					} else {
						this.element.type = 'url';
					}
				} else {
					let phone = parsePhoneNumberFromString(str, 'RU');
					if(phone && phone.isValid()) {
						this.element.type = 'phone';
					} else {
						this.element.type = 'text'
					}
				}
			},

			valueByType( str ) {
				if (['url', 'vk', 'instagram'].includes(this.element.type)) {
					return this.formattingUrl(str);
				} else if(this.element.type == 'phone') {
					return this.formattingPhone(str);
				}
				return str;
			},
		},

	}
</script>
