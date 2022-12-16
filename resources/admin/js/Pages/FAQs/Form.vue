<template>
    <AppLayout :title="editorTitle(isEdit)">

        <FormSection :submit="submit" :form="form"
        v-model:activeTab="activeTab" :hideButtons="activeTab == 'Дополнительно'" mini
        >
            <template #buttons>
                <Link v-if="isEdit" :href="currentRoute('create')" class="btn btn-gray ml-auto">Добавить ещё</Link>
            </template>

            <template #content>
                <div class="col-span-full grid gap-4">
                    <FLabel title="Заголовок" :error="form.errors.title">
                        <FInput type="text" v-model="form.title" />
                    </FLabel>
                    <FLabel title="Описание" :error="form.errors.description">
                         <FTextarea rows="3" v-model="form.description" required/>
                    </FLabel>
                    <FLabel title="Язык" :error="form.errors.lang">
                        <FSelect :options="$page.props.langs" v-model="form.lang" required/>
                    </FLabel>
                </div>
            </template>
        </FormSection>

    </AppLayout>
</template>

<script>

    import AppLayout from '@/Layouts/AppLayout'
    import FormSection from '@/Layouts/Sections/Form'

    export default {
        components: {
            AppLayout,
            FormSection,
        },

        data() {
            return {
                form: this.$inertia.form(this.$page.props.item || {
                    title: null,
                    description: null,
                    lang: null,
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
                    .post(this.currentRoute('store'), {
                        preserveState: (page) => Object.keys(page.props.errors).length,
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
