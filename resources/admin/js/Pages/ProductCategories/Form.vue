<template>
    <AppLayout :title="editorTitle(isEdit)">

        <FormSection :submit="submit" :form="form" :tabs="['Основное', 'SEO']" v-model:activeTab="activeTab" :showLink="frontUrl('product/' + form.slug)" mini>
            <template #title>
                <div v-if="!isEdit">Добавить</div>
                <div v-else>Редактировать</div>
            </template>
            <template #buttons>
                <Link v-if="isEdit" :href="currentRoute('create')" class="btn btn-gray ml-auto">Добавить ещё</Link>
            </template>

            <template #content>

                <MLanguageRow class="mb-2"/>

                <div class="form-grid" v-show="activeTab == 'Основное'">

                    <MTitleSlug :form="translation" />

                    <FLabel title="Родительская категория" :error="form.errors.parent_id">
                        <FSelect :options="categories" :keys="['id','title']" v-model="form.parent_id" />
                    </FLabel>

                    <FLabel title="Описание" :error="translation.errors?.description" as="div">
                        <FTextareaEditor v-model="translation.description" mini/>
                    </FLabel>

                </div>

                <MTabSeo v-show="activeTab == 'SEO'" :form="translation" />

            </template>
        </FormSection>

    </AppLayout>
</template>

<script>

    import AppLayout from '@/Layouts/AppLayout'
    import FormSection from '@/Layouts/Sections/Form'

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
        },


        data() {
            return {
                form: this.setForm({
                    parent_id: null,

                    translations: this.defaultTranslations({
                        slug: null,
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

