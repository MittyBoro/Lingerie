import { Mark, mergeAttributes } from '@tiptap/core'
export default Mark.create({
  name: 'small',
  inline: true,
  addOptions() {
    return {
      HTMLAttributes: {},
    }
  },
  parseHTML() {
    return [
      {
        tag: 'small',
      },
    ]
  },
  renderHTML({ HTMLAttributes }) {
    return [
      'small',
      mergeAttributes(this.options.HTMLAttributes, HTMLAttributes),
      0,
    ]
  },
})
