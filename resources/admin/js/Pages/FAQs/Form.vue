<template>
    <AppLayout title="Страницы">

        <FormSection :submit="submit" :form="form"
        :tabs="isEdit ? ['Основное', 'SEO', 'Дополнительно'] : ['Основное', 'SEO']"
        :showLink="frontUrl(form.slug)"
        v-model:activeTab="activeTab" :hideButtons="activeTab == 'Дополнительно'">
            <template #title>
                <div v-if="!isEdit">Добавить страницу</div>
                <div v-else>Редактировать страницу</div>
            </template>
            <template #buttons>
                <Link v-if="isEdit" :href="route(routePrefix + 'create')" class="btn btn-gray ml-auto">Добавить ещё</Link>
            </template>

            <template #content>

                <TabMain v-show="activeTab == 'Основное'" :form="form" :isEdit="isEdit" />
                <TabSEO v-show="activeTab == 'SEO'" :form="form" />
                <TabProps v-if="isEdit" v-show="activeTab == 'Дополнительно'" :page_id="form.id" />

            </template>
        </FormSection>

    </AppLayout>
</template>

<script>

    import AppLayout from '@/Layouts/AppLayout'
    import FormSection from '@/Layouts/Sections/Form'

    import TabMain from './Form/Main'
    import TabSEO from './Form/SEO'
    import TabProps from './Form/Props'

    export default {
        components: {
            AppLayout,
            FormSection,

            TabMain,
            TabSEO,
            TabProps,
        },

        data() {
            return {
                routePrefix: 'admin.pages.',

                form: this.$inertia.form(this.$page.props.item || {
                    title: null,
                    slug: null,
                    is_hidden: false,
                    route: null,

                    description: null,

                    meta_title: null,
                    meta_keywords: null,
                    meta_description: null,
                }),

                isEdit: !!this.$page.props.item,

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
                    .post(route(this.routePrefix + 'store'), {
                        preserveState: (page) => Object.keys(page.props.errors).length,
                    });
            },

            update() {
                this.form
                    .transform((data) => ({
                        ...data,
                        _method : 'PUT',
                    }))
                    .post(route(this.routePrefix + 'update', this.form.id), {
                        preserveState: (page) => Object.keys(page.props.errors).length,
                        preserveScroll: true,
                    });
            },
        },
    }
</script>
