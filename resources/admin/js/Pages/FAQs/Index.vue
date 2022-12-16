<template>
    <AppLayout title="FAQ">
        <IndexSection class="max-w-3xl">

            <template #buttons>
                <Link :href="currentRoute('create')" class="btn">Добавить</Link>
            </template>

            <template #content>

                <TTable :table="table">
                    <template #row="sp">
                        <TData v-text="sp.element.title" :class="{'opacity-70': sp.element.is_hidden}" />
                        <TData v-text="sp.element.lang" :class="{'opacity-70': sp.element.lang}" />
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
                routePrefix: 'admin.faqs.',
            }
        },

        computed: {
            table() {
                return {
                    headers: [
                        { key: 'title', text: 'Заголовок',  sortable: true },
                        { key: 'lang', text: 'Язык',  sortable: true },
                    ],
                    items: this.$page.props.list.data,
                    pagination: this.$page.props.list,

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

                form.put( this.currentRoute('update', item.id), {
                    preserveScroll: true,
                });
            },
        }
    }
</script>
