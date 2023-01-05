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
            return !!this.$page.props.item;
        },
    },

    created() {

        let formErrors;

        this.$inertia.on('error', (errors) => {
            formErrors = this.errorKeysToObject(errors.detail.errors)
        });

        this.$inertia.on('finish', (finish) => {
            this.form.errors = formErrors
        });
    },


    methods: {

        errorKeysToObject(errors) {
            let object = {};

            Object.entries(errors).forEach(element => {
                let path = element[0].split('.'),
                    last = path.pop();
                path.reduce((o, k) => o[k] = o[k] || {}, object)[last] = element[1];
            });

            return object
        },

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
