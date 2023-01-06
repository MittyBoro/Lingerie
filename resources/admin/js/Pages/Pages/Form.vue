<template>
    <AppLayout :title="editorTitle(isEdit)">

        <FormSection :submit="submit" :form="form"
        :tabs="isEdit ? ['Основное', 'Дополнительно', 'SEO'] : ['Основное', 'SEO']"
        mini
        >
            <template #content="sb">
                <TabMain v-show="sb.activeTab == 'Основное'" :form="form" />
                <TabProps v-show="sb.activeTab == 'Дополнительно'" :form="form" />
                <MTabSeo v-show="sb.activeTab == 'SEO'" :form="form" />
            </template>
        </FormSection>

    </AppLayout>
</template>

<script>

    import AppLayout from '@/Layouts/AppLayout'
    import FormSection from '@/Layouts/Sections/Form'

    import TabMain from './Form/Main'
    import TabProps from './Form/Props'

    import Form from '@/Mixins/Form/Form'

    export default {
        mixins: [
            Form,
        ],

        components: {
            AppLayout,
            FormSection,

            TabMain,
            TabProps,
        },

        data() {
            return {
                form: this.setForm({
                    title: null,
                    slug: null,
                    is_hidden: false,
                    route: null,
                    lang: null,

                    description: null,

                    meta_title: null,
                    meta_keywords: null,
                    meta_description: null,
                }),
            }
        },

    }
</script>
