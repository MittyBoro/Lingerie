<template>
    <AppLayout title="Все страницы">
        <IndexSection class="max-w-3xl">

            <template #buttons>
                <Link :href="route(routePrefix + 'create')" class="btn">Добавить</Link>
            </template>

            <template #content>

                <TTable :table="table">
                    <template #row="sp">
                        <TData v-text="sp.element.title" :class="{'opacity-70': sp.element.is_hidden}" />
                        <TData v-text="sp.element.slug" :class="{'opacity-70': sp.element.is_hidden}" />
                        <TData mini>
                            <a :href="frontUrl(sp.element.slug)" target="_blank" class="text-gray-500 hover-link">
                                <font-awesome-icon icon="eye"/>
                            </a>
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
                routePrefix: 'admin.pages.',
            }
        },

        computed: {
            table() {
                return {
                    headers: [
                        { key: 'title', text: 'Заголовок',  sortable: true },
                        { key: 'slug', text: 'Ярлык',  sortable: true },
                        {},
                    ],
                    items: this.$page.props.list.data,
                    pagination: this.$page.props.list,

                    editRoute: this.routePrefix + 'edit',
                    destroyRoute: this.routePrefix + 'destroy',
                }
            }
        },

        methods: {
            update(item) {
                item.index_edit = true;

                let form = this.$inertia.form(item);

                form.put( route(this.routePrefix + 'update', item.id) , {
                    preserveScroll: true,
                });
            },
        }
    }
</script>
