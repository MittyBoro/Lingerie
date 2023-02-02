<template>
    <AppLayout title="Заказы товаров">
        <IndexSection middle>

            <template #subtitle>
                <template v-if="$page.props.auth.user.id == 1 && $page.props.list.data.length">
                    <div v-for="(sale, key) in sales" :key="key">
                        <span>{{ keyToName(key) }}:</span>
                        <span class="text-gray-500 ml-2" v-for="s in sale" :key="s.currency">
                            {{ s.count }} на {{ formatPrice(s.sum) }}{{ currencySymbol(s.currency) }}
                        </span>
                    </div>
                </template>
            </template>

            <template #content>

                <TPagination v-if="$page.props.list.total" :pages="$page.props.list" class="border-t border-b" />

                <div v-if="$page.props.list.data.length"
                    class="px-1 lg:px-6 py-10 bg-gray-50  border-t grid grid-cols-6 gap-4 xl:gap-6">
                    <ListItem v-for="element in $page.props.list.data" :key="element.id" :element="element" :user="user" />
                </div>
                <div v-else class="w-full px-5 py-5 text-lg text-center bg-gray-50 text-gray-700">Данных ещё нет</div>

                <TPagination v-if="$page.props.list.total" :pages="$page.props.list" class="border-t" />

            </template>
        </IndexSection>
    </AppLayout>
</template>

<script>

    import AppLayout from '@/Layouts/AppLayout'
    import IndexSection from '@/Layouts/Sections/Index'

    import ListItem from './ListItem'

    export default {
        components: {
            AppLayout,
            IndexSection,
            ListItem,
        },

        data() {
            return {
                sales: this.$page.props.sales,
                user: this.$page.props.user,
            }
        },

        methods: {
            keyToName(key) {
                if (key == "month") {
                    return 'Продаж за месяц'
                }
                if (key == "half_year") {
                    return 'Продаж за полгода'
                }
                if (key == "year") {
                    return 'Продаж за год'
                }
                if (key == "all") {
                    return 'Продаж за всё время'
                }
                return key
            }
        },
    }
</script>
