<template>
    <AppLayout title="Переводы">
        <IndexSection mini>

            <template #buttons>
                <div class="grid gap-6 sm:grid-flow-col">
                    <MLanguageRow withAll globLang />
                    <Link :href="currentRoute('create')" class="btn">Добавить</Link>
                </div>
            </template>

            <template #content>

                <TTable :table="table">
                    <template #pagination />

                    <template #row="sp">
                        <TData v-model="sp.element.key" @update:modelValue="update(sp.element)" />
                        <TData v-model="sp.element.value" @update:modelValue="update(sp.element)" />
                        <TData>
                            <FSelect class="min-w-max" :options="$page.props.langs" v-model="sp.element.lang" required @update:modelValue="update(sp.element)" mini/>
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
            AppLayout, IndexSection,
        },

        data() {
            return {
            }
        },

        computed: {
            table() {
                return {
                    headers: [
                        { key: 'key', text: 'Ключ',  sortable: true },
                        { key: 'value', text: 'Значение',  sortable: true },
                        { key: 'lang', text: 'Язык',  sortable: true },
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
