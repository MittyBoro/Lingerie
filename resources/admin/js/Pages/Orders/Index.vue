<template>
    <AppLayout title="Заказы товаров">
        <IndexSection mini>

            <template #title>Все заказы</template>
            <template #subtitle>
                <div v-if="user" class="mb-2">
                    <span>Заказы пользователя <Link class="link" :href="route('admin.users.show', user.id)">{{ user.name }}</Link></span>
                </div>

                <template v-if="$page.props.auth.user.id == 1">
                    <div>Продаж за месяц: {{ sales.month.count }} на {{ formatPrice(sales.month.sum) }}₽</div>
                    <div>Продаж за год: {{ sales.year.count }} на {{ formatPrice(sales.year.sum) }}₽</div>
                    <div>Продаж за всё время: {{ sales.all.count }} на {{ formatPrice(sales.all.sum) }}₽</div>
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
    }
</script>
