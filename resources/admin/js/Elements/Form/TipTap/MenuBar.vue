<template>
    <div>
        <template v-for="(item, index) in items">
            <template v-if="!item.hidden">
                <div class="divider" v-if="item.type === 'divider'" :key="`divider${index}`" />
                <MenuItem v-else :key="index" v-bind="item" :disabled="!item.always && isSource" />
            </template>
        </template>
    </div>
</template>

<script>
import MenuItem from './MenuItem.vue'

export default {
    components: {
      MenuItem,
    },

    props: {
        toggleSource: Function,
        isSource: Boolean,
        mini: Boolean,
        editor: {
            type: Object,
            required: true,
        },
    },
    emits: ['sourceCode'],

    data() {
        return {
            items: [
                {
                    icon: 'bold',
                    title: 'Bold',
                    action: () => this.editor.chain().focus().toggleBold().run(),
                    isActive: () => this.editor.isActive('bold'),
                },
                {
                    icon: 'italic',
                    title: 'Italic',
                    action: () => this.editor.chain().focus().toggleItalic().run(),
                    isActive: () => this.editor.isActive('italic'),
                },
                {
                    icon: 'strikethrough',
                    title: 'Strike',
                    action: () => this.editor.chain().focus().toggleStrike().run(),
                    isActive: () => this.editor.isActive('strike'),
                },
                {
                    hidden: this.mini,
                    icon: 'code-simple',
                    title: 'Code',
                    action: () => this.editor.chain().focus().toggleCode().run(),
                    isActive: () => this.editor.isActive('code'),
                },
                {
                    hidden: this.mini,
                    icon: 'highlighter',
                    title: 'Highlight',
                    action: () => this.editor.chain().focus().toggleHighlight().run(),
                    isActive: () => this.editor.isActive('highlight'),
                },
                {
                    type: 'divider',
                },
                {
                    icon: 'h1',
                    title: 'Heading 1',
                    action: () => this.editor.chain().focus().toggleHeading({ level: 1 }).run(),
                    isActive: () => this.editor.isActive('heading', { level: 1 }),
                },
                {
                    icon: 'h2',
                    title: 'Heading 2',
                    action: () => this.editor.chain().focus().toggleHeading({ level: 2 }).run(),
                    isActive: () => this.editor.isActive('heading', { level: 2 }),
                },
                {
                    hidden: this.mini,
                    icon: 'h3',
                    title: 'Heading 3',
                    action: () => this.editor.chain().focus().toggleHeading({ level: 3 }).run(),
                    isActive: () => this.editor.isActive('heading', { level: 3 }),
                },
                {
                    icon: 'paragraph',
                    title: 'Paragraph',
                    action: () => this.editor.chain().focus().setParagraph().run(),
                    isActive: () => this.editor.isActive('paragraph'),
                },
                {
                    icon: 'list-ul',
                    title: 'Bullet List',
                    action: () => this.editor.chain().focus().toggleBulletList().run(),
                    isActive: () => this.editor.isActive('bulletList'),
                },
                {
                    icon: 'list-ol',
                    title: 'Ordered List',
                    action: () => this.editor.chain().focus().toggleOrderedList().run(),
                    isActive: () => this.editor.isActive('orderedList'),
                },
                {
                    icon: 'block-quote',
                    title: 'Blockquote',
                    action: () => this.editor.chain().focus().toggleBlockquote().run(),
                    isActive: () => this.editor.isActive('blockquote'),
                },
                {
                    hidden: this.mini,
                    icon: 'horizontal-rule',
                    title: 'Horizontal Rule',
                    action: () => this.editor.chain().focus().setHorizontalRule().run(),
                },
                {
                    hidden: this.mini,
                    icon: 'rectangle-code',
                    title: 'Code Block',
                    action: () => this.editor.chain().focus().toggleCodeBlock().run(),
                    isActive: () => this.editor.isActive('codeBlock'),
                },
                {
                    hidden: this.mini,
                    icon: 'image',
                    title: 'Add Image',
                    action: () =>  {
                        const url = window.prompt('URL')
                        if (url) {
                            this.editor.chain().focus().setImage({ src: url }).run()
                        }
                    },
                },
                {
                    type: 'divider',
                },
                // {
                //     icon: 'turn-down-left',
                //     title: 'Hard Break',
                //     action: () => this.editor.chain().focus().setHardBreak().run(),
                // },
                {
                    icon: 'text-slash',
                    title: 'Clear Format',
                    action: () => this.editor.chain()
                                    .focus()
                                    .clearNodes()
                                    .unsetAllMarks()
                                    .run(),
                },
                {
                    type: 'divider',
                },
                {
                    icon: 'rotate-left',
                    title: 'Undo',
                    always: true,
                    action: () => this.editor.chain().focus().undo().run(),
                },
                {
                    icon: 'rotate-right',
                    title: 'Redo',
                    always: true,
                    action: () => this.editor.chain().focus().redo().run(),
                },
                {
                    type: 'divider',
                },
                {
                    icon: 'code',
                    always: true,
                    title: 'Source Code',
                    action: () => {
                        this.toggleSource()
                        this.editor.commands.focus()
                    },
                    isActive: () => this.isSource,
                },
            ],
        }
    },
}
</script>

<style lang="sass">
    .divider
        width: 2px
        height: 1.25em
        background-color: rgba(#000, 0.1)
        margin-left: 0.3rem
        margin-right: 0.3rem
</style>
