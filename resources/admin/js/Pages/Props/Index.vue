<template>
    <AppLayout title="Параметры" >
        <FormSection class="max-w-3xl load-opacity" :tabs="tabs">
            <template #buttons>
                <div class="flex items-center">
                    <Link :href="currentRoute('index', {edit: true})" class="mr-2 btn-gray btn-square">
                        <Icon icon="gear" />
                    </Link>
                    <Link :href="route('admin.optimize')" class="btn-danger">Кэш</Link>
                </div>
            </template>

            <template #content="sp">
                <template v-for="tab in tabs" :key="tab">
                    <props-list v-show="sp.activeTab == tab" :list="getList(tab)" />
                </template>
            </template>

        </FormSection>
    </AppLayout>
</template>

<script>

    import AppLayout from '@/Layouts/AppLayout'
    import FormSection from '@/Layouts/Sections/Form'

    import PropsList from '@/Elements/Props/List'

    export default {
        components: {
            AppLayout,
            FormSection,
            PropsList,
        },

        data() {
            return {
                tabs: Object.values(this.$page.props.tabs),
            }
        },

        methods: {
            getList(tab) {
                return this.$page.props?.list?.filter(el => el.tab == tab);
            },
        }


    }
</script>
