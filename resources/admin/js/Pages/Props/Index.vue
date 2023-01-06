<template>
    <AppLayout title="Параметры" >
        <FormSection class="max-w-3xl load-opacity" :tabs="tabs" :submit="updateList" :form="form" hideAdder>
            <template #buttons>
                <div class="flex items-center">
                    <Link :href="currentRoute('index', {edit: true})" class="mr-2 btn-gray btn-square">
                        <Icon icon="gear" />
                    </Link>
                </div>
            </template>

            <template #content="sp">
                <MPropsList :activeTab="sp.activeTab" :errors="form.errorsObj?.props" :list="form.props" @update="form.props = $event" />
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
                tabs: Object.values(this.$page.props.tabs),
                form: this.setForm({}),
            }
        },

        methods: {
            updateList() {
                this.form
                    .post(this.currentRoute('update_list'), {
                        forceFormData: true,
                        preserveState: (page) => Object.keys(page.props.errors).length,
                        preserveScroll: true,
                    });
            }
        },

    }
</script>
