<template>
    <label class="px-6 ml-auto">
        <FSelect :options="options" v-model.lazy="lang" @update:modelValue="setLang" />
    </label>
</template>

<script>
    export default {
        data() {
            return {
                lang: this.$page.props.list_lang,
            }
        },

        created() {
            this.values = this.values
        },

        computed: {
            options() {
                let list = {
                    'all': 'Все',
                    ...this.$page.props.langs
                }

                return list;
            }
        },

        methods: {
            setLang(lang) {
                this.$inertia.post( route('admin.list_lang.set'), {lang: lang}, {
                    preserveState: true,
                    preserveScroll: true,
                });
            }
        }
    }
</script>
