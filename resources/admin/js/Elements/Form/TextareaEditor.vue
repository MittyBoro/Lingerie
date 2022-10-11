<template>
	<div v-if="0">
		<div class="ckeditor-component form-textarea" :class="{'ckeditor-focused': focus, 'ckeditor-mini': mini, 'wo-upload': !uploadImages}">
			<div class="ckeditor" ref="ckeditor" v-html="content"></div>
			<div class="word-count" ref="words_count"></div>
		</div>
		<div v-if="0 && uploadImages">
			<FNotice v-if="!id">Сохраните страницу, что бы добавлять изображения в текст</FNotice>
			<div v-else-if="images.length">
				<div class="inline-block mt-3 px-2 py-0.5 bg-gray-50 cursor-pointer transition" :class="{'rounded-t-md ' : showImages, 'rounded-md shadow-sm': !showImages}" @click="showImages = !showImages">
					<span class="text-xs border-b border-current border-dotted">Файлы ({{ images.length }})</span>
				</div>

				<div v-if="showImages" class="px-3 py-2 bg-gray-50 rounded-b-md max-w-lg">
					<div class="flex items-center my-2" v-for="image of images" :key="image.id">
						<a :href="image.url" target="_blank">
							<img class="mr-4 w-9 shrink-0 border bg-white border-gray-200 rounded-sm" :src="image.url" alt="">
						</a>
						<input class="bg-gray-100 px-3 py-1 text-xs w-full border border-gray-300 rounded focus:ring-0 focus:border-primary-500 transition" type="text" readonly :value="image.url">
						<span @click="destroy(image.id)" class="ml-2 text-sm text-red-500 hover:text-red-600 transition material-icons-outlined cursor-pointer">close</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>

import Notify from '@/Layouts/AppComponets/Notify'

// import { Editor, UploadAdapter } from 'ckeditor5'

export default {

	// колхоз, но работает.
	// вывод картинок

	mixins: [Notify],

	props: {
		modelValue: null,
		id: null,
		type: null,
		name: null,
		mini: Boolean,
		uploadImages: Boolean,
		mediaList: Array,
		modelModifiers: {
			type: Object,
			default: {}
		},
	},
	emits: ['update:modelValue', 'change'],

	data() {
		let media = this.getMedia();

		return {
			focus: false,
			content: this.modelValue,

			collectionName: this.type + '_' + this.name,
			pageImages: media,
			showImages: false,
		};
	},

	computed: {
		images() {
			let pageImages = this.pageImages || [];
			let thisImages = pageImages.filter(el => el.collection_name == this.collectionName)
			return thisImages;
		}
	},

	mounted() {


        return ;

		let config = {
			toolbar: {
				items: [
					'heading', '|',
					'bold', 'italic', 'underline', 'link', 'blockQuote', 'removeFormat', '|',
					'alignment', 'bulletedList', 'numberedList', '|',
					'insertImage', 'insertTable', '|',
					'undo', 'redo', '|',
					'sourceEditing',
				]
			},
			language: 'ru',
			image: {
				toolbar: [
					'imageTextAlternative',
					'linkImage'
				]
			},
			table: {
				contentToolbar: [
					'tableColumn', 'tableRow', 'mergeTableCells'
				]
			},
			fieldData: {
				id: this.id,
				type: this.type,
				collection: this.collectionName,
			},
			notify: {
				error: this.notifyErrorByResponse,
			},
		}

		if (this.mini) {
			let exclude = ['blockQuote', 'insertTable', 'code'];
			config.toolbar.items = config.toolbar.items.filter(el => !exclude.includes(el));
		}

		Editor
			.create( this.$refs.ckeditor, config)
			.then(editor => {

				const wordCountPlugin = editor.plugins.get( 'WordCount' );
				const wordCountWrapper = this.$el.querySelector( '.word-count' );
				wordCountWrapper.appendChild( wordCountPlugin.wordCountContainer );

				editor.plugins.get( 'ImageUploadEditing' ).on( 'uploadComplete', () => {
					editor.focus();
				});

				editor.ui.focusTracker.on('change:isFocused', ( evt, name, value ) => {
					this.focus = value;

					if (!this.focus) {
						this.content = editor.getData();
						this.onInput('change');
					}
				});
				editor.model.document.on( 'change', () => {
					this.content = editor.getData();
					this.onInput('input');
				});

				this.$el.querySelector( '.ck-source-editing-button' ).addEventListener('click', (e) => {
					this.textareaSetEvents()
				});

			})
			.catch( error => {
				console.log('error', error)
			});

	},

	methods: {

		getMedia() {
			if (this.mediaList)
				return this.mediaList || []
			else
				return this.$page.props.item ? this.$page.props.item.admin_media : [];
		},

		onInput(type = 'input') {
			if (this.modelModifiers.lazy) {
				if (type == 'change') {
					this.$emit('update:modelValue', this.content);
				}
			} else {
				this.$emit('update:modelValue', this.content);
			}
		},

		uploader(editor) {
			editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
				return new UploadAdapter( loader, editor, route('admin.media.store') );
			};
		},

		textareaSetEvents() {
			let textarea = this.$el.querySelector( '.ck-source-editing-area textarea' )

			if (!textarea)
				return;
			textarea.blur();

			let eventFocus = () => {
				this.focus = true
			}
			let eventBlur = () => {
				this.focus = false
				this.content = textarea.value;
				this.onInput('change');
			}
			let eventInput = () => {
				this.content = textarea.value;
				this.onInput('input');
			}

			textarea.addEventListener('focus', eventFocus);
			textarea.addEventListener('blur', eventBlur);
			textarea.addEventListener('input', eventInput)

			setTimeout(() => {
				textarea.focus();
			}, 10);
		},

		destroy(image_id) {
			if (!confirm('Вы уверены?'))
				return;

			let form = this.$inertia.form({});
			form.delete(route('admin.media.destroy', image_id), {
				preserveScroll: true,
				preserveState: true,
				onSuccess: () => {
					this.pageImages = this.pageImages.filter(el => el.id != image_id);
				},
			})
		},
	}

}
</script>

<style lang="sass">

	.ckeditor-component
		padding: 0
		height: auto
		&.ckeditor-focused
			@apply border-primary-200 ring-4 ring-primary-200
			.ck-rounded-corners .ck.ck-editor__top .ck-sticky-panel .ck-toolbar, .ck.ck-editor__top .ck-sticky-panel .ck-toolbar.ck-rounded-corners
				@apply border-primary-200
		.ck-content,
		.ck-source-editing-area
			min-height: 230px
			textarea
				background: #fefefe
				border: 0
				outline: 0
				line-height: 1.3
				&:focus
					border: 0
					box-shadow: none
		&.ckeditor-mini
			.ck-content,
			.ck-source-editing-area
				min-height: 150px


		.ck-rounded-corners .ck.ck-editor__top .ck-sticky-panel .ck-toolbar, .ck.ck-editor__top .ck-sticky-panel .ck-toolbar.ck-rounded-corners
			@apply rounded-t-md bg-white border-0 border-b border-gray-200

		.ck.ck-list__item .ck-button.ck-on
			@apply transition bg-primary-500
			&:hover:not(.ck-disabled)
				@apply bg-primary-600
		.ck.ck-button:active, .ck.ck-button:focus, a.ck.ck-button:active, a.ck.ck-button:focus
			@apply border border-primary-200
		.ck.ck-list__item .ck-button:hover:not(.ck-disabled)
			@apply bg-gray-50
		.ck.ck-dropdown__panel
			@apply rounded-md shadow-md border-0
		.ck.ck-editor__editable_inline
			padding-top: 1em
			padding-bottom: 1em
		.ck.ck-editor__editable:not(.ck-editor__nested-editable)
			background: transparent
			border: 0
			outline: 0
			&.ck-focused
				box-shadow: none
		.ck-source-editing-button
			svg
				margin: 0 !important
			.ck-button__label
				display: none !important
		.ck-word-count
			@apply flex flex-wrap px-2 py-1 bg-gray-50 text-xs rounded-b-md opacity-90 border-t border-gray-200
			.ck-word-count__words
				@apply mr-2

	.ck-content
		& > *:first-child
			margin-top: 0 !important

		p
			margin-bottom: 8px
		h1
			margin-bottom: 8px
			font-size: 25px
			font-weight: 700
		h2
			margin-bottom: 8px
			font-size: 22px
			font-weight: 700
		h3
			margin-bottom: 8px
			font-size: 19px
			font-weight: 700
		h4
			margin-bottom: 8px
			font-size: 17px
			font-weight: 700
		ul, ol
			margin: 8px 0
			padding-left: 5px
		ol
			list-style: decimal inside
		ul
			list-style: disc inside
		blockquote
			padding: .5em 1em
			margin-left: 0
			margin-right: 0
			margin-bottom: 8px
			font-style: italic
			border-left: 5px solid #ccc
			background: #fafafa
			p
				margin: .25em
	.ck-button
		zoom: .95
	.ck-button
		zoom: .95

	.wo-upload
		.ck-file-dialog-button ~ .ck-button
			position: absolute
			top: 0
			left: 0
			right: 0
			bottom: 0
			opacity: 0


</style>
