<template>
    <AppLayout :title="editorTitle(isEdit)">

        <FormSection :submit="submit" :form="form" mini>

            <template #content>
                <FLabel title="Заголовок" :error="form.errors.title">
                    <FInput type="text" v-model="form.title" />
                </FLabel>
                <FLabel title="Описание" :error="form.errors.description">
                        <FTextarea rows="3" v-model="form.description" required/>
                </FLabel>
                <FLabel title="Язык" :error="form.errors.lang">
                    <FSelect :options="$page.props.langs" v-model="form.lang" required/>
                </FLabel>
            </template>
        </FormSection>

    </AppLayout>
</template>

<script>

    import AppLayout from '@/Layouts/AppLayout'
    import FormSection from '@/Layouts/Sections/Form'

    import Form from '@/Mixins/Form/Form'

    export default {
        mixins: [
            Form,
        ],
        components: {
            AppLayout,
            FormSection,
        },

        data() {
            return {
                form: this.setForm({
                    title: null,
                    description: null,
                    lang: null,
                }),
            }
        },
    }
</script>
