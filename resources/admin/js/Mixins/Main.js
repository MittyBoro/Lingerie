
export default {
    data() {
        return {
        }
    },



    methods: {

        editorText(isEdit) {
           return isEdit ? 'Редактировать' : 'Добавить'
        },
        confirm(e) {
            if (!confirm('Вы уверены?'))
                e.preventDefault()
        },
    }
}
