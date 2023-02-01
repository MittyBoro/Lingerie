
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
        isAdmin() {
            return this.$page.props.auth.user.role == 'admin'
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

        truncateString(str, num) {
            return (str.length > num) ? str.substr(0, num) + '...' : str;
        }
    }
}
