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

    export default {
        components: {
            AppLayout,
            FormSection,

            TabMain,
            TabDescription,
            TabVariations,
        },


        data() {
            return {
                form: this.$inertia.form(this.$page.props.item || {
                    is_stock: true,
                    is_published: false,

                    gallery: null,
                    categories: null,

                    size_table: null,
                    translations: this.getDefaultTranslations(),
                }),

                isEdit: !!this.$page.props.item?.id,
                activeTab: null,
            }
        },

        computed: {
            translation: {
                get() {
                    let index = this.form.translations.findIndex(el => el.lang == this.validAdminLang);
                    let translations = this.form.translations[index];
                        translations.errors =
                                this.errorKeysToObject(this.form.errors)?.translations?.[index];

                    return translations;
                },
                set(val) {
                    this.form.translations = this.form.translations.map(item => {
                        if (this.validAdminLang == item.lang)
                            item = val;
                        return item;
                    })
                },
            }
        },

        methods: {
            getDefaultTranslations() {
                let translations = [];
                Object.keys(this.$page.props.langs).forEach(lang => {
                    translations.push({
                        lang: lang,
                        slug: null,
                        title: null,
                        meta_title: null,
                        meta_keywords: null,
                        meta_description: null,

                        attributes: {
                            description: null,
                            composition: null,
                            care: null,
                        },
                    })
                })
                return translations;
            },

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

