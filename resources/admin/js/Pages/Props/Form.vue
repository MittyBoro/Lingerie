<template>
    <AppLayout :title="editorTitle(isEdit)">

        <FormSection :submit="submit" :form="form" mini>
            <template #content>

                <MTitleSlug :form="form" :slugKey="'key'" :slugName="'Ключ'"/>

                <FLabel title="Тип" :error="form.errors.type">
                    <FSelect :options="types" v-model="form.type" />
                </FLabel>

                <FLabel v-if="!page_id" title="Имя вкладки (только в панели)" :error="form.errors.tab">
                    <FInput v-model="form.tab" :options="tabs" />
                </FLabel>

                <!-- можно дополнять -->
                <FLabel title="Прикрепить к странице" :error="form.errors.model_id">
                    <FSelect :options="pages" :keys="['id','title']" v-model="page_id" />
                    <Link v-if="page_id" :href="route('admin.pages.edit', page_id)" class="link flex text-xs items-center mt-3">
                        <Icon icon="pencil" class="mr-1.5" />
                        <span>Редактировать страницу</span>
                    </Link>
                </FLabel>

            </template>

            <template v-if="isEdit" #actions>
                <Link @click.prevent :href="currentRoute('destroy', form.id)" method="delete" as="button" class="ml-3">
                    <div @click="confirm" class="btn-danger btn-square block">
                        <Icon icon="trash-can"/>
                    </div>
                </Link>
            </template>

        </FormSection>
    </AppLayout>
</template>

<script>

    import AppLayout from '@/Layouts/AppLayout'
    import FormSection from '@/Layouts/Sections/Form'

    import Form from '@/Mixins/Form'

    export default {
        mixins: [
            Form,
        ],

        components: {
            AppLayout,
            FormSection,
        },


        data() {

            let page_id = route().params.page_id;

            return {
                form: this.setForm({
                    title: null,
                    key: null,
                    type: 'string',
                    tab: null,
                    model_id: page_id,
                    model_type: page_id ? 'pages' : null,
                }),

                types: this.$page.props.types,
                tabs: this.$page.props.tabs,
            }
        },

        computed: {
            pages() {
                let list = [...this.$page.props.pages].map(el => {
                    el.title = `[${el.slug}] ${el.title}`
                    return el
                });

                list.unshift({ id: null, title: '---' });
                return list;
            },

            page_id: {
                get() {
                    return this.form.model_id;
                },
                set(val) {
                    if (val) {
                        this.form.model_id = val
                        this.form.model_type = 'pages'
                    } else {
                        this.form.model_id = null
                        this.form.model_type = null
                    }
                }
            },
        },
    }
</script>

