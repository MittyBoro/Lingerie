<template>
    <AppLayout :title="editorTitle(isEdit)">

        <FormSection :submit="submit" :form="form" :tabs="['Основное', 'SEO']" mini>
            <template #content="sb">
                <MLanguageRow class="mb-2"/>

                <div class="form-grid" v-show="sb.activeTab == 'Основное'">

                    <FTitleSlug :formTitle="translation" :formSlug="form"  />

                    <FLabel title="Родительская категория" :error="form.errors.parent_id">
                        <FSelect :options="categories" :keys="['id','title']" v-model="form.parent_id" />
                    </FLabel>

                    <FLabel title="Описание" :error="translation.errors?.description" as="div">
                        <FTextareaEditor v-model="translation.description" mini/>
                    </FLabel>

                </div>

                <MTabSeo v-show="sb.activeTab == 'SEO'" :form="translation" />

            </template>
        </FormSection>

    </AppLayout>
</template>

<script>

    import AppLayout from '@/Layouts/AppLayout'
    import FormSection from '@/Layouts/Sections/Form'

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
        },


        data() {
            return {
                form: this.setForm({
                    parent_id: null,
                    slug: null,

                    translations: this.defaultTranslations({
                        title: null,
                        description: null,
                        meta_title: null,
                        meta_keywords: null,
                        meta_description: null,
                    }),
                }),
            }
        },

        computed: {
            categories() {
                let list = [...this.$page.props.list];

                list.unshift({ id: null, title: '---' });
                return list;
            },
        },

    }
</script>

