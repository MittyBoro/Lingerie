/**
 * подключать в конкретных случаях
 */
export default {
    data() {
        return {
        }
    },

    computed: {
        translation: {
            get() {
                let index = this.form.translations?.findIndex(el => el.lang == this.validAdminLang);
                if (index === undefined)
                    return {}
                let translations = this.form.translations[index];
                    translations.errors = this.form.errors?.translations?.[index];

                return translations;
            },
            set(val) {
                this.form.translations = this.form.translations.map(item => {
                    if (this.validAdminLang == item.lang)
                        item = val;
                    return item;
                })
            },
        }
    },

    methods: {
        defaultTranslations(object) {
            let translations = [];
            Object.keys(this.$page.props.langs).forEach(lang => {
                translations.push({
                    lang: lang,
                    ...object
                })
            })
            return translations;
        },
    }
}
