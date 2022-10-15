<template>
	<div class="grid gap-4" :class="{'md:grid-cols-6': isSingleImage}">

		<Draggable
			class="grid"
			:class="dragClasses"
			v-if="showList"
			v-model="files"
			:group="rand"
			item-key="index"
			draggable=".drag-preview"
			>
			<template #item="{element, index}">
				<div class="drag-preview" v-if="!element.del">
					<div
						:class="[isImage ? 'file-image' : 'file-simple']"
						:style="getStyle(element)"
						>
						<div v-if="element.url" @click="openFile(element)" class="absolute inset-0 cursor-pointer transition opacity-10 hover:bg-gray-500"></div>
						<div v-if="!isImage" class="text-gray-600 text-sm">{{ element.name }}</div>
						<span
							@click.prevent="removeAt(element, index)"
							class="flex items-center justify-center bg-red-500 text-white h-3 w-3 rounded-sm shadow-sm text-xs cursor-pointer"
							:class="[isImage ? 'absolute top-1 right-1' : 'relative']"
							>
								<Icon icon="xmark" />
							</span>
					</div>
				</div>

			</template>
		</Draggable>

		<label :class="{'drop-area': drop, 'md:col-span-5': isSingleImage}">
			<div class="form-input flex-wrap">
				<span v-if="multiple">Выберите файлы</span>
				<span v-else>Выберите файл</span>
				<span v-if="drop"> или перетащите сюда</span>
				<Icon icon="cloud-arrow-up" class="opacity-60 ml-1" />
				<input type="file"
					@change="addFiles"
					class="hidden"
					:accept="isImage ? 'image/jpeg,image/png' : accept"
					:multiple="multiple"
					>
			</div>
		</label>

	</div>
</template>

<script>
	import Draggable from 'vuedraggable'

	export default {
		components: {
			Draggable,
		},

		props: {
			modelValue: {
				type: [Array, Object],
				default: []
			},
			isImage: Boolean,
			multiple: Boolean,
			drop: {
				type: Boolean,
				default: true
			},
			paste: {
				type: Boolean,
				default: true
			},
			accept: {
				type: String,
				default: ''
			},
		},

		emits: ['update:modelValue'],

		data() {
			return {
				rand: Math.random(),

				base64URLs: {},
			}
		},

		computed: {
			files: {
				get() {
					if (!this.modelValue || !Object.keys(this.modelValue).length)
						return [];

					return [...this.modelValue];
				},
				set(val) {
					this.$emit('update:modelValue', val);
				},
			},

			isSingleImage() {
				return !this.multiple && this.files.length == 1 && this.isImage;
			},

			showList() {
				return this.files.length;
			},

			dragClasses() {
				return [
                    isImage ? 'gap-3' : 'gap-1 max-w-xs',
                    {
                        'grid-cols-3 sm:grid-cols-4 md:grid-cols-6': !isSingleImage && isImage,
                        "w-28 md:w-auto": isSingleImage
                    }
                ]
			}
		},

		mounted() {
			if (this.drop)
				this.addDropEvents();
			if (this.paste)
				this.addPasteEvents();
		},


		methods: {
			addFiles(e) {
				let formFiles = [];

				if ( e.target && e.target.files )
					formFiles = e.target.files;
				else if ( e.dataTransfer && e.dataTransfer.files )
					formFiles = e.dataTransfer.files;
				else if ( e.clipboardData && e.clipboardData.files )
					formFiles = e.clipboardData.files;

				if (!formFiles.length)
					return;

				let files = this.files

				Array.from(formFiles).forEach(el => {
					files.push({
						file: el,
						name: el.name,
						rand_id: this.setBase64URL(el),
					});
				});

				if (!this.multiple) {
					files = files.slice(-1)
				}

				this.files = files;

			},

			removeAt(element, index) {
				if (element.id) {
					element.del = true;
				} else {
					let files = this.files;
					files.splice(index, 1);
					this.files = files;
				}
			},

			addPasteEvents() {
				window.addEventListener('paste', (e) => {
    				document.querySelectorAll(':hover').forEach(el => {
						if (el == this.$el)
							this.addFiles(e);
					})
				}, false)
			},

			addDropEvents() {
				let dropArea = this.$el.querySelector('.drop-area');

				if (!dropArea)
					return;

				['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
					this.$el.addEventListener(eventName, (e) => {
						e.preventDefault();
						e.stopPropagation();
					}, false);
				});

				['dragenter', 'dragover'].forEach(eventName => {
					this.$el.addEventListener(eventName, (e) => {
						dropArea.classList.add('highlight')
					}, false);
				});
				['dragleave', 'drop'].forEach(eventName => {
					this.$el.addEventListener(eventName, (e) => {
						dropArea.classList.remove('highlight')
					}, false);
				});

				this.$el.addEventListener('drop', this.addFiles, false)
			},

		 	getStyle(file) {
				if (!this.isImage)
					return {};

				return {
					backgroundImage: 'url(' + ( file.url || this.base64URLs[file.rand_id] ) + ')'
				}
			},

		 	setBase64URL(file) {

				let rand_id = Math.random();

				if (this.isImage) {
					let reader = new FileReader();
					reader.readAsDataURL(file);
					reader.onload = (e) => {
						this.base64URLs[rand_id] = e.target.result;
					}
				}

				return rand_id;
			},

		 	openFile(file) {
				if (file.url)
					window.open(file.url);
			},

		}
	}
</script>

<style lang="sass" scoped>
	.form-input
		@apply flex items-center justify-center bg-gray-50 text-xs py-3
		height: auto
		max-height: none !important
		&:hover
			@apply bg-gray-50 ring-4 ring-primary-600 ring-opacity-20

	.drop-area
		@apply flex justify-center rounded-lg w-full border-dashed border-4 border-gray-300 cursor-pointer transition
		padding: 15px 20px
		span
			display: inline-block
			text-align: center
		&:hover
			@apply bg-gray-50

	@screen sm
		.drop-area
			padding: 25px 30px

	.drop-area.highlight
		@apply bg-primary-500 border-primary-700

	.file-image
		@apply relative block border shadow-sm rounded-sm bg-gray-50 bg-center bg-contain bg-no-repeat
		padding-bottom: 100%

	.file-simple
		@apply relative flex items-center justify-between pr-1
		background-size: 0


</style>
