<template>
    <AppLayout title="Товары" >
        <IndexSection class="max-w-5xl">

            <template #buttons>
                <Link :href="currentRoute('create')" class="btn">Добавить</Link>
            </template>


            <template #content>

                <ListFilter v-if="table.items.length" class="border-t bg-gray-50" />

                <TTable :table="table">
                    <template #row="sp">
                        <TData mini>
                            <div class="min-w-max">
                                <img :src="sp.element.preview" class="h-8 w-8 rounded borderobject-cover bg-gray-100" alt="">
                            </div>
                        </TData>
                        <TData v-text="sp.element.translations[0]?.title" />
                        <TData>
                            {{ formatPrice(sp.element.translations[0]?.price) }}
                            {{ currencies[sp.element.translations[0]?.price_currency] }}
                        </TData>
                        <TData mini>
                            <FSwitcher v-model="sp.element.is_published" @update:modelValue="update(sp.element)" mini/>
                        </TData>
                        <TData mini>
                            <a :href="frontUrl('product/' + sp.element.slug)" target="_blank" class="text-gray-500 hover-link">
                                <Icon icon="eye"/>
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

    import ListFilter from './Index/ListFilter'

    export default {
        components: {
            AppLayout, IndexSection, ListFilter,
        },

        data() {
            return {
                routePrefix: 'admin.products.',
                roles: this.$page.props.roles,
            }
        },

        computed: {
            table() {
                return {
                    headers: [
                        {},
                        { key: 'title', text: 'Название' },
                        { key: 'price', text: 'Цена' },
                        { key: 'is_published', fa: 'eye', sortable: true, class: 'text-center' },
                        {},
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

                form.put( this.currentRoute('update', item.id) , {
                    preserveScroll: true,
                });
            },
        },
    }
</script>
