<template>
  <div
    :class="{
      big: isFullscreen,
      '-mb-9': editor.isActive('table') && !isFullscreen,
    }"
  >
    <template v-for="(item, index) in items">
      <template v-if="!item.hidden">
        <div
          class="divider"
          v-if="item.type === 'divider'"
          :key="`divider${index}`"
        />
        <MenuItem
          v-else
          :key="index"
          v-bind="item"
          :disabled="!item.always && isSource"
        />
      </template>
    </template>
    <MenuItem
      class="ml-auto"
      v-bind="{
        icon: 'up-right-and-down-left-from-center',
        title: 'Full screen',
        action: () => {
          this.toggleFullScreen()
        },
        isActive: () => this.isFullscreen,
      }"
    />
    <div
      class="w-full border-t flex pt-1.5 mt-1.5"
      v-if="editor.isActive('table')"
    >
      <template v-for="(item, index) in tableItems">
        <div
          class="divider"
          v-if="item.type === 'divider'"
          :key="`divider${index}`"
        />
        <MenuItem v-else :key="index" v-bind="item" :disabled="isSource" />
      </template>
    </div>
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
      toggleFullScreen: Function,
      isFullscreen: Boolean,
      mini: Boolean,
      editor: {
        type: Object,
        required: true,
      },
    },

    data() {
      return {
        items: [
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
          {
            type: 'divider',
          },
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
            icon: 'align-left',
            title: 'Align left',
            action: () =>
              this.editor.chain().focus().setTextAlign('left').run(),
            isActive: () => this.editor.isActive({ textAlign: 'left' }),
          },
          {
            icon: 'align-center',
            title: 'Align center',
            action: () =>
              this.editor.chain().focus().setTextAlign('center').run(),
            isActive: () => this.editor.isActive({ textAlign: 'center' }),
          },
          {
            icon: 'align-right',
            title: 'Align right',
            action: () =>
              this.editor.chain().focus().setTextAlign('right').run(),
            isActive: () => this.editor.isActive({ textAlign: 'right' }),
          },
          // {
          //   icon: 'align-justify',
          //   title: 'Align justify',
          //   action: () =>
          //     this.editor.chain().focus().setTextAlign('justify').run(),
          //   isActive: () => this.editor.isActive({ textAlign: 'justify' }),
          // },
          {
            type: 'divider',
          },
          {
            icon: 'h1',
            title: 'Heading 1',
            action: () =>
              this.editor.chain().focus().toggleHeading({ level: 1 }).run(),
            isActive: () => this.editor.isActive('heading', { level: 1 }),
          },
          {
            icon: 'h2',
            title: 'Heading 2',
            action: () =>
              this.editor.chain().focus().toggleHeading({ level: 2 }).run(),
            isActive: () => this.editor.isActive('heading', { level: 2 }),
          },
          {
            hidden: this.mini,
            icon: 'h3',
            title: 'Heading 3',
            action: () =>
              this.editor.chain().focus().toggleHeading({ level: 3 }).run(),
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
          // {
          //   hidden: this.mini,
          //   icon: 'rectangle-code',
          //   title: 'Code Block',
          //   action: () => this.editor.chain().focus().toggleCodeBlock().run(),
          //   isActive: () => this.editor.isActive('codeBlock'),
          // },
          {
            icon: 'text-slash',
            title: 'Clear Format',
            action: () =>
              this.editor.chain().focus().clearNodes().unsetAllMarks().run(),
          },
          {
            type: 'divider',
            hidden: this.mini,
          },
          {
            hidden: this.mini,
            icon: 'image',
            title: 'Add Image',
            action: () => {
              const url = window.prompt('URL')
              if (url) {
                this.editor.chain().focus().setImage({ src: url }).run()
              }
            },
          },
          {
            hidden: this.mini,
            icon: 'table',
            title: 'Table',
            action: () =>
              this.editor
                .chain()
                .focus()
                .insertTable({ rows: 3, cols: 3, withHeaderRow: false })
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
        ],

        tableItems: [
          {
            icon: 'left-from-line',
            title: 'Добавить столбец перед',
            action: () => this.editor.chain().focus().addColumnBefore().run(),
          },
          {
            icon: 'right-from-line',
            title: 'Добавить столбец после',
            action: () => this.editor.chain().focus().addColumnAfter().run(),
          },
          {
            icon: 'up-from-line',
            title: 'Добавить строку перед',
            action: () => this.editor.chain().focus().addRowBefore().run(),
          },
          {
            icon: 'down-from-line',
            title: 'Добавить строку после',
            action: () => this.editor.chain().focus().addRowAfter().run(),
          },
          {
            type: 'divider',
          },
          {
            icon: 'frame',
            title: 'Объединить ячейки',
            action: () => this.editor.chain().focus().mergeCells().run(),
          },
          {
            icon: 'crop',
            title: 'Разделить ячейку',
            action: () => this.editor.chain().focus().splitCell().run(),
          },
          {
            type: 'divider',
          },
          {
            icon: 'diagram-cells',
            title: 'Переключить заголовок',
            action: () => this.editor.chain().focus().toggleHeaderRow().run(),
          },
          {
            type: 'divider',
          },
          {
            icon: 'wrench',
            title: 'Исправить таблицу',
            action: () => this.editor.chain().focus().fixTables().run(),
          },
          {
            type: 'divider',
          },
          {
            icon: 'table',
            classes: 'red',
            title: 'Удалить таблицу',
            action: () => this.editor.chain().focus().deleteTable().run(),
          },
          {
            icon: 'xmarks-lines',
            classes: 'red rotate-90',
            title: 'Удалить столбец',
            action: () => this.editor.chain().focus().deleteColumn().run(),
          },
          {
            icon: 'xmarks-lines',
            classes: 'red',
            title: 'Удалить строку',
            action: () => this.editor.chain().focus().deleteRow().run(),
          },
        ],
      }
    },
  }
</script>

<style lang="scss" scoped>
  .divider {
    width: 2px;
    height: 1.25em;
    background-color: rgba(#000, 0.1);
    margin-left: 0.3rem;
    margin-right: 0.3rem;
  }
  .big {
    :deep(.menu-item) {
      height: theme('height.7');
      width: theme('width.7');
    }
  }

  :deep(.menu-item) {
    margin-right: theme('spacing[0.5]');
    display: flex;
    height: theme('height.6');
    width: theme('width.6');
    align-items: center;
    justify-content: center;
    border-radius: theme('borderRadius.DEFAULT');
    padding-top: theme('spacing[1.5]');
    padding-bottom: theme('spacing[1.5]');
    color: theme('colors.gray.500');
    transition-property: theme('transitionProperty.DEFAULT');
    transition-timing-function: theme('transitionTimingFunction.DEFAULT');
    transition-duration: theme('transitionDuration.DEFAULT');
    cursor: pointer;

    svg {
      width: 100%;
      height: 100%;
      fill: currentColor;
    }

    &.disabled {
      pointer-events: none;
      opacity: 0.3;
    }

    &.is-active {
      background-color: theme('colors.gray.500');
      color: theme('colors.white');
    }
    &.red {
      color: theme('colors.red.400');
      &:hover {
        background-color: theme('colors.red.500');
        color: theme('colors.white');
      }
    }

    &:hover {
      background-color: theme('colors.gray.600');
      color: theme('colors.white');
    }
  }
</style>
