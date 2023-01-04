/**
 * подключать в конкретных случаях
 */
export default {
    data() {
        return {
            form: {},
        }
    },

    computed: {
        isEdit() {
            return !!this.$page.props.item?.id;
        },
    },


    methods: {

        setForm(defaultValue) {
            return this.$inertia.form(
                    this.$page.props.item ||
                    JSON.parse(JSON.stringify(defaultValue)),
                )
        },

        submit() {
            this.isEdit ?
                        this.update() :
                        this.store()
        },

        store() {
            this.form
                .post(this.currentRoute('store'), {
                    preserveState: (page) => Object.keys(page.props.errors).length,
                    preserveScroll: true,
                });
        },

        update() {
            this.form
                .transform((data) => ({
                    ...data,
                    _method : 'PUT',
                }))
                .post(this.currentRoute('update', this.form.id), {
                    preserveState: (page) => Object.keys(page.props.errors).length,
                    preserveScroll: true,
                });
        },
    }
}
