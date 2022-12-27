
export default {
    data() {
        return {
        }
    },

    computed: {
        adminLang: {
            get() {
                return this.$page.props.admin_lang
            },
            set(val) {
                this.$page.props.admin_lang = val;
            }
        },
        validAdminLang() {
            return this.$page.props.langs[this.adminLang] ? this.adminLang : 'ru';
        },
    },

    methods: {

        editorTitle(isEdit) {
           return isEdit ? 'Редактировать' : 'Добавить'
        },
        confirm(e) {
            if (!confirm('Вы уверены?'))
                e.preventDefault()
        },

        errorKeysToObject(errors) {
            let object = {};

            Object.entries(errors).forEach(element => {
                let path = element[0].split('.'),
                    last = path.pop();
                path.reduce((o, k) => o[k] = o[k] || {}, object)[last] = element[1];
            });

            return object
        },
    }
}
