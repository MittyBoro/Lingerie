<template>
    <div v-if="!sorting" @click="start" class="btn-gray mt-3">Сортировать</div>
    <div v-else @click="end" class="btn-gray mt-3">Назад</div>
</template>

<script>

    export default {
        props: ['modelValue', 'pages'],
        props: {
            modelValue: Boolean,
            pages: Object,
            query: {
                type: Object,
                default: {}
            },
        },
        emits: ['update:modelValue'],

        computed:
        {
            sorting: {
                get() {
                    return this.modelValue;
                },
                set(val) {
                    this.$emit('update:modelValue', val);
                },
            },
        },

        mounted() {
            this.opened = this.activeSubRoute;
        },

        methods: {
            start() {
                this.sorting = true;
                let count = this.pages ? this.pages.total : 9999;

                this.$inertia.visit( route(route().current(), {...this.query, perPage:  count} ), {
                    preserveState: true,
                })
            },
            end() {
                this.sorting = false;
                this.$inertia.visit( route(route().current(), {...this.query}) )
            },
        }

    }
</script>
