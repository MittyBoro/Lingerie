<template>
    <AppLayout :title="editorTitle(isEdit)">

        <FormSection :submit="submit" :form="form"
            :tabs="['Основное', 'Описание', 'Варианты', 'SEO']" mini>

            <template #content="sb">

                <MLanguageRow v-if="sb.activeTab != 'Варианты'" class="mb-2"/>

                <TabMain v-show="sb.activeTab == 'Основное'" :form="form" :translation="translation" :isEdit="isEdit" />
                <TabDescription v-show="sb.activeTab == 'Описание'" :form="form" :translation="translation" />
                <TabOptions v-show="sb.activeTab == 'Варианты'" :form="form" />
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
    import TabOptions from './Form/Options'

    import Translation from '@/Mixins/Form/Translation'
    import Form from '@/Mixins/Form/Form'

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
            TabOptions,
        },


        data() {
            return {
                form: this.setForm({
                    is_stock: true,
                    is_published: false,
                    slug: null,

                    gallery: null,
                    categories: null,

                    size_table: null,

                    options: null,

                    translations: this.defaultTranslations({
                        title: null,
                        meta_title: null,
                        meta_keywords: null,
                        meta_description: null,

                        price: null,

                        details: {
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

