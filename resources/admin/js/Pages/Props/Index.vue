<template>
    <AppLayout title="Параметры" >
        <FormSection class="max-w-3xl load-opacity" :tabs="tabs" :submit="submit" :form="form" hideAdder>
            <template #buttons>
                <div class="flex items-center">
                    <Link :href="currentRoute('index', {edit: true})" class="mr-2 btn-gray btn-square">
                        <Icon icon="gear" />
                    </Link>
                    <Link :href="route('admin.optimize')" class="btn-danger">Кэш</Link>
                </div>
            </template>

            <template #content="sp">
                <props-list :activeTab="sp.activeTab" :list="form.list" @update="form.list = $event" />
            </template>

        </FormSection>
    </AppLayout>
</template>

<script>

    import AppLayout from '@/Layouts/AppLayout'
    import FormSection from '@/Layouts/Sections/Form'

    import PropsList from '@/Elements/Props/List'

    import Form from '@/Mixins/Form'


    export default {

        mixins: [
            Form,
        ],

        components: {
            AppLayout,
            FormSection,
            PropsList,
        },

        data() {
            return {
                tabs: Object.values(this.$page.props.tabs),
                form: this.setForm({}),
            }
        },

    }
</script>
