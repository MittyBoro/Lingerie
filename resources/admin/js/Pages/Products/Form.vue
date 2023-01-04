<template>
    <AppLayout :title="editorTitle(isEdit)">

        <FormSection :submit="submit" :form="form"
            :tabs="['Основное', 'Описание', 'Дополнительно', 'SEO']" mini>

            <template #content="sb">

                <MLanguageRow class="mb-2"/>

                <TabMain v-show="sb.activeTab == 'Основное'" :form="form" :translation="translation" :isEdit="isEdit" />
                <TabDescription v-show="sb.activeTab == 'Описание'" :form="form" :translation="translation" />
                <TabAttributes v-show="sb.activeTab == 'Дополнительно'" :form="form" />
                <MTabSeo v-show="sb.activeTab == 'SEO'" :form="translation" />

            </template>
        </FormSection>

    </AppLayout>
</template>

<script>

    import AppLayout from '@/Layouts/AppLayout'
    import FormSection from '@/Layouts/Sections/Form'

    import TabMain from './Form/Main'
    import TabDescription from './Form/Description'
    import TabAttributes from './Form/Attributes'

    import Translation from '@/Mixins/Translation'
    import Form from '@/Mixins/Form'

    export default {

        mixins: [
            Translation,
            Form,
        ],

        components: {
            AppLayout,
            FormSection,

            TabMain,
            TabDescription,
            TabAttributes,
        },


        data() {
            return {
                form: this.setForm({
                    is_stock: true,
                    is_published: false,

                    gallery: null,
                    categories: null,

                    size_table: null,

                    attributes: null,

                    translations: this.defaultTranslations({
                        slug: null,
                        title: null,
                        meta_title: null,
                        meta_keywords: null,
                        meta_description: null,

                        price: null,
                        price_currency: this.$page.props.currencies[0],

                        texts: {
                            description: null,
                            composition: null,
                            care: null,
                        },
                    }),
                }),
            }
        },
    }
</script>

