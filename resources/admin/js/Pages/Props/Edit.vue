<template>
    <AppLayout title="Настройки">
        <IndexSection>

            <template #title>Редактировать настройки</template>
            <template #buttons>
                <Link :href="route(routePrefix + 'create')" class="btn">Добавить</Link>
            </template>

            <template #content>

                <TTable :table="table">
                    <template #row="sp">
                        <TData v-model="sp.element.key" @update:modelValue="update(sp.element)" />
                        <TData v-model="sp.element.title" @update:modelValue="update(sp.element)" />
                        <TData v-if="sp.element.model_name && route().has('admin.' + sp.element.model_name + '.edit')">
                            <Link class="link inline-flex items-center" :href="route('admin.' + sp.element.model_name + '.edit', sp.element.model_id)">
                                <Icon icon="note-sticky" class="mr-1" />
                                <span>{{ sp.element.model.title.substr(0, 6) }}</span>
                            </Link>
                        </TData>
                        <TData v-else v-model="sp.element.tab" @update:modelValue="update(sp.element)" />
                        <TData class="text-xs opacity-80" v-text="types[sp.element.type]" />
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
                routePrefix: 'admin.props.',

                types: this.$page.props.types,
            }
        },

        computed: {
            table() {
                return {
                    headers: [
                        { key: 'key', text: 'Ключ', sortable: true },
                        { key: 'title', text: 'Заголовок', sortable: true },
                        { key: 'tab', text: 'Вкладка', sortable: true },
                        { key: 'type', text: 'Тип', sortable: true },
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
