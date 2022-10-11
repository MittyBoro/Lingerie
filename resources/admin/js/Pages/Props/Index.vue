<template>
    <AppLayout title="Настройки" >
        <FormSection class="max-w-3xl load-opacity" :tabs="tabs" v-model:activeTab="activeTab">
            <template #title>
                <div class="flex items-center">
                    <span>Настройки</span>
                    <Link :href="route('admin.props.index', {edit: true})" class="ml-2 btn-gray btn-square btn-mini">
                        <font-awesome-icon icon="gear" />
                    </Link>
                </div>
            </template>

            <template #buttons>
                <Link :href="route('admin.optimize')" class="btn-danger max-h-8">Кэш</Link>
            </template>

            <template #content>

                <props-list :list="props" />

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
                activeTab: null,
                props: [],
            }
        },

        watch: {
            activeTab() {
                this.props = this.getActiveProps();
            }
        },

        methods: {
            getActiveProps() {
                return this.$page.props?.list?.filter(el => el.tab == this.activeTab);
            },
        }


    }
</script>
