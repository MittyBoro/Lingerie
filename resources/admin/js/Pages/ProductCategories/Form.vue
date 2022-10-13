<template>
    <AppLayout title="Категории" >

        <FormSection :submit="submit" :form="form" :tabs="['Основное', 'SEO']" v-model:activeTab="activeTab"  class="max-w-xl">
            <template #title>
                <div v-if="!isEdit">Добавить категорию</div>
                <div v-else>Редактировать категорию</div>
            </template>
            <template #buttons>
                <Link v-if="isEdit" :href="route(routePrefix + 'create', {type: type})" class="btn btn-gray ml-auto">Добавить ещё</Link>
            </template>

            <template #content>

                <TabMain v-show="activeTab == 'Основное'" :form="form" :isEdit="isEdit" />
                <TabSEO v-show="activeTab == 'SEO'" :form="form" />

            </template>
        </FormSection>

    </AppLayout>
</template>

<script>

    import AppLayout from '@/Layouts/AppLayout'
    import FormSection from '@/Layouts/Sections/Form'

    import TabMain from './Form/Main'
    import TabSEO from './Form/SEO'

    export default {
        components: {
            AppLayout,
            FormSection,

            TabMain,
            TabSEO,
        },


        data() {
            let urlParams = new URLSearchParams(window.location.search);

            return {
                routePrefix: 'admin.categories.',

                form: this.$inertia.form(this.$page.props.item || {
                    title: '',
                    slug: '',

                    parent_id: null,

                    description: '',

                    meta_title: '',
                    meta_keywords: '',
                    meta_description: '',
                }),

                isEdit: !!this.$page.props.item?.id,
                type: urlParams.get('type'),
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
                    .post(route(this.routePrefix + 'store', {type: this.type}), {
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
                    .post(route(this.routePrefix + 'update', {category: this.form.id, type: this.type}), {
                        preserveState: (page) => Object.keys(page.props.errors).length,
                        preserveScroll: true,
                    });
            },
        },
    }
</script>

