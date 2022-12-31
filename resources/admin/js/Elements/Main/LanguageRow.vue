<template>

    <div class="flex flex-wrap">
        <div
            v-for="item in langsList"
            :key="item[0]"
            class="px-4 py-2 text-xs mr-2 last:mr-0 bg-gray-100 rounded-md shadow-lg transition hover:bg-gray-200 cursor-pointer"
            @click="adminLang = item[0]"
            :class=" { 'bg-secondary-500 text-white pointer-events-none': adminLang == item[0] } "
            >{{ item[1] }}</div>
    </div>

</template>

<script>
    export default {

        emits: ['update:modelValue'],
        props: {
            withAll: Boolean,
            globLang: Boolean,
        },

        computed: {

            langsList() {
                let list = {
                    ...this.$page.props.langs
                }

                if (this.withAll) {
                    list = {
                        'all': 'Все',
                        ...list
                    }
                }

                return Object.entries(list);
            }
        },

        watch: {
            adminLang(val) {
                console.log(this.globLang)
                if (this.globLang)
                    this.setLang(val);
            },
        },

        methods: {
            setLang(lang) {
                this.$inertia.post( route('admin.admin_lang.set'), {lang: lang}, {
                    preserveState: true,
                    preserveScroll: true,
                });
            }
        }
    }
</script>
