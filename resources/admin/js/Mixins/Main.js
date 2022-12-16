
export default {
    data() {
        return {
        }
    },



    methods: {

        editorTitle(isEdit) {
           return isEdit ? 'Редактировать' : 'Добавить'
        },
        confirm(e) {
            if (!confirm('Вы уверены?'))
                e.preventDefault()
        },
    }
}
