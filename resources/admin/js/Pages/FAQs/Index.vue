<template>
    <AppLayout title="FAQ">
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
                        <TData v-model="sp.element.title" @update:modelValue="update(sp.element)" />
                        <TData v-text="sp.element.lang" class="uppercase font-bold text-gray-500" />
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
                        { key: 'title', text: 'Заголовок',  sortable: true },
                        { key: 'lang', text: 'Язык',  sortable: true },
                    ],
                    items: this.$page.props.list,

                    sortRoute: this.currentRouteStr('sort'),
                    editRoute: this.currentRouteStr('edit'),
                    destroyRoute: this.currentRouteStr('destroy'),
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
