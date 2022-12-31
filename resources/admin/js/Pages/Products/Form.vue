<template>
    <AppLayout :title="editorTitle(isEdit)">

        <FormSection :submit="submit" :form="form" :tabs="['Основное', 'Описание', 'Цена', 'SEO']" v-model:activeTab="activeTab" :showLink="frontUrl('product/' + form.slug)" mini>
            <template #title>
                <div v-if="!isEdit">Добавить</div>
                <div v-else>Редактировать</div>
            </template>
            <template #buttons>
                <Link v-if="isEdit" :href="currentRoute('create')" class="btn btn-gray ml-auto">Добавить ещё</Link>
            </template>

            <template #content>

                <MLanguageRow class="mb-2"/>

                <TabMain v-show="activeTab == 'Основное'" :form="form" :translation="translation" :isEdit="isEdit" />
                <TabDescription v-show="activeTab == 'Описание'" :form="form" :translation="translation" />
                <!-- <TabVariations v-show="activeTab == 'Цена'" :form="form" :translation="translation" /> -->
                <MTabSeo v-show="activeTab == 'SEO'" :form="translation" />

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
            TabVariations,
        },


        data() {
            return {
                form: this.setForm({
                    is_stock: true,
                    is_published: false,

                    gallery: null,
                    categories: null,

                    size_table: null,

                    translations: this.defaultTranslations({
                        slug: null,
                        title: null,
                        meta_title: null,
                        meta_keywords: null,
                        meta_description: null,

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

