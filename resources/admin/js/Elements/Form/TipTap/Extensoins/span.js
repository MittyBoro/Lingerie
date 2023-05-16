import { Mark, mergeAttributes } from '@tiptap/core'
export default Mark.create({
  name: 'span',
  inline: true,
  addOptions() {
    return {
      HTMLAttributes: {},
    }
  },
  parseHTML() {
    return [
      {
        tag: 'span',
      },
      {
        tag: 'span[class]',
        getAttrs: (dom) => {
          return {
            class: dom.getAttribute('class'),
          }
        },
      },
    ]
  },
  renderHTML({ HTMLAttributes }) {
    console.log('HTMLAttributes', this, HTMLAttributes)
    return [
      'span',
      mergeAttributes(this.options.HTMLAttributes, HTMLAttributes),
      0,
    ]
  },
  addAttributes() {
    return {
      class: {
        default: null,
        renderHTML: (attributes) => {
          return {
            class: attributes.class,
          }
        },
      },
    }
  },
})
