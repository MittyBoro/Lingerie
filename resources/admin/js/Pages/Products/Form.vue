<template>
    <AppLayout title="Товары" >

        <FormSection :submit="submit" :form="form" :tabs="['Основное', 'Описание', 'Цена', 'SEO']" v-model:activeTab="activeTab" :showLink="frontUrl('product/' + form.slug)">
            <template #title>
                <div v-if="!isEdit">Добавить</div>
                <div v-else>Редактировать</div>
            </template>
            <template #buttons>
                <Link v-if="isEdit" :href="route(routePrefix + 'create')" class="btn btn-gray ml-auto">Добавить ещё</Link>
            </template>

            <template #content>

                <TabMain v-show="activeTab == 'Основное'" :form="form" :isEdit="isEdit" />
                <TabDescription v-show="activeTab == 'Описание'" :form="form" />
                <TabVariations v-show="activeTab == 'Цена'" :form="form" />
                <TabSEO v-show="activeTab == 'SEO'" :form="form" />

            </template>
        </FormSection>

    </AppLayout>
</template>

<script>

    import AppLayout from '@/Layouts/AppLayout'
    import FormSection from '@/Layouts/Sections/Form'

    import TabMain from './Form/Main'
    import TabDescription from './Form/Description'
    import TabVariations from './Form/Variations'
    import TabSEO from './Form/SEO'

    export default {
        components: {
            AppLayout,
            FormSection,

            TabMain,
            TabDescription,
            TabVariations,
            TabSEO,
        },


        data() {
            return {
                routePrefix: 'admin.products.',

                form: this.$inertia.form(this.$page.props.item || {
                    title: null,
                    slug: null,
                    is_stock: false,
                    is_published: false,
                    gallery: null,
                    categories: null,

                    description: null,
                    characteristics: null,

                    variations: null,

                    meta_title: null,
                    meta_keywords: null,
                    meta_description: null,
                }),

                isEdit: !!this.$page.props.item?.id,
                activeTab: null,
            }
        },


        methods: {

            submit() {
                this.isEdit ?
                            this.update() :
                            this.store()
            },

            store() {
                this.form
                    .post(this.currentRoute('store'), {
                        preserveState: (page) => Object.keys(page.props.errors).length,
                        preserveScroll: true,
                    });
            },

            update() {
                this.form
                    .transform((data) => ({
                        ...data,
                        _method : 'PUT',
                    }))
                    .post(this.currentRoute('update', this.form.id), {
                        preserveState: (page) => Object.keys(page.props.errors).length,
                        preserveScroll: true,
                    });
            },
        },
    }
</script>

