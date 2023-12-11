<template>
    <AppLayout title="Варианты">
        <IndexSection mini>

            <template #buttons>
                <Link :href="currentRoute('create')" class="btn">Добавить</Link>
            </template>

            <template #content>

                <TTable :table="table">
                    <template #row="sp">
                        <TData v-model="sp.element.type" @update:modelValue="update(sp.element)" />
                        <TData v-model="sp.element.value" @update:modelValue="update(sp.element)" />
                        <TData>
                            <div class="-mx-2 flex gap-3">
                                <input v-if="sp.element.type == 'color'" type="color" class="w-6 h-7 flex-shrink-0 rounded-full cursor-pointer" v-model="sp.element.extra"
                                    @input="update(sp.element)">
                                <FTextarea
                                    rows="1"
                                    class="max-h-16 focus:max-h-max"
                                    @change="update(sp.element)"
                                    v-model="sp.element.extra"
                                />
                            </div>
                        </TData>
                    </template>
                </TTable>

            </template>
        </IndexSection>
    </AppLayout>
</template>

<script>

    import AppLayout from '@/Layouts/AppLayout'
    import IndexSection from '@/Layouts/Sections/Index'

    export default {
        components: {
            AppLayout,
            IndexSection,
        },

        data() {
            return {
            }
        },

        computed: {
            table() {
                return {
                    headers: [
                        { key: 'type', text: 'Тип',  sortable: true },
                        { key: 'value', text: 'Значение',  sortable: true },
                        { key: 'extra', text: 'Доп.' },
                    ],
                    items: this.$page.props.list.data,
                    pagination: this.$page.props.list,
                }
            }
        },

        methods: {
            update(item) {
                item.index_edit = true;

                let form = this.$inertia.form(item);

                form.put( this.currentRoute('update', item.id) , {
                    preserveScroll: true,
                });
            },
        }
    }
</script>

<style lang="sass" scoped>
    input::-webkit-color-swatch
        border-radius: 50%
    textarea
        @apply bg-transparent block border-0 w-full rounded-sm shadow-none px-2 py-1 align-middle
        font-size: inherit
        &:not(:focus):hover
            @apply ring-primary-500 ring-opacity-20 ring bg-white bg-opacity-40
        &:disabled
            @apply bg-transparent pointer-events-none opacity-50

</style>
