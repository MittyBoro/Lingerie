<template>
    <AppLayout title="Пользователь" >
        <IndexSection class="max-w-5xl">

            <template #title>Пользователь</template>

            <template #buttons>
                <Link :href="route(routePrefix + 'edit', item.id)" class="btn">Редактировать</Link>
            </template>

            <template #content>
                <div class="bg-gray-50">
                    <div class="px-6 md:px-10 py-10 customer-info gap-y-3  max-w-2xl">

                        <div class="ci-title">Имя:</div>
                        <div>{{ item.name }}</div>

                        <div class="ci-title">Почта:</div>
                        <div>{{ item.email }}</div>

                        <div class="ci-title">Логин:</div>
                        <div>{{ item.username }}</div>

                        <div class="ci-title">Телефон:</div>
                        <div>{{ item.phone }}</div>

                        <div class="ci-title">Роль:</div>
                        <div>{{ roles[item.role] }}</div>

                        <div class="ci-title">Заказов:</div>
                        <div class="flex flex-wrap items-center">
                            <span class="mr-2">{{ item.paid_orders.length }} на сумму {{ formatPrice(item.paid) }}₽</span>
                            <Link class="btn btn-mini" :href="route('admin.product_orders.index', {user_id: item.id})">просмотреть</Link>
                        </div>

                        <div class="ci-title">Бонусы:</div>
                        <div class="flex flex-wrap items-center">
                            <span class="mr-3">{{ formatPrice(item.bonuses) }}</span>
                            <Link class="btn btn-mini mr-2" :href="route('admin.bonuses.index', {user_id: item.id})">история</Link>
                            <Link class="btn btn-mini btn-secondary" :href="route('admin.bonuses.create', {user_id: item.id})">добавить</Link>
                        </div>

                    </div>
                </div>
            </template>
        </IndexSection>
    </AppLayout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import IndexSection from '@/Layouts/Sections/Index'

    export default {
        components: {
            AppLayout, IndexSection,
        },

        data() {
            return {
                routePrefix: 'admin.users.',

                item: this.$page.props.item,
                roles: this.$page.props.roles,
            }
        },

        computed: {
        },

        methods: {
        },
    }
</script>
