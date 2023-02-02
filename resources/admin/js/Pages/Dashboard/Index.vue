<template>
    <AppLayout title="Главная">

        <div v-if="data.orders" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 max-w-3xl">

            <div class="md:col-span-2 flex flex-col justify-between bg-white shadow-lg rounded-lg px-8 py-6">
                <h1 class="font-bold text-lg uppercase">{{ data.products.title }}</h1>
                <div class="text-grid">
                    <div class="text-row">
                        <div class="text-title">Всего: </div>
                        <div class="text-value">{{ data.products.count }}</div>
                    </div>
                    <div class="text-row">
                        <div class="text-title">Новых за месяц: </div>
                        <div class="text-value">{{ data.products.count_month }}</div>
                    </div>
                    <div class="text-row">
                        <div class="text-title">За полгода: </div>
                        <div class="text-value"> {{ data.products.count_half_year }}</div>
                    </div>
                    <div class="text-row">
                        <div class="text-title">За год: </div>
                        <div class="text-value">{{ data.products.count_year }}</div>
                    </div>
                    <div class="text-row">
                        <div class="text-title">Категорий: </div>
                        <div class="text-value">{{ data.products.count_categories }}</div>
                    </div>
                </div>
                <Link class="btn w-full" :href="route(data.products.route)">Перейти</Link>
            </div>

            <div class="md:col-span-2 flex flex-col justify-between bg-white shadow-lg rounded-lg px-8 py-6">
                <h1 class="font-bold text-lg uppercase">{{ data.orders.title }}</h1>
                <div class="text-grid">
                    <div class="text-row">
                        <div class="text-title">За неделю: </div>
                        <div class="text-value">
                            {{ data.orders.week_info.count }}
                            <!-- на {{ formatPrice(data.orders.week_info.sum) }}₽ -->
                        </div>
                    </div>
                    <div class="text-row">
                        <div class="text-title">За месяц: </div>
                        <div class="text-value">
                            {{ data.orders.month_info.count }}
                            <!-- на {{ formatPrice(data.orders.month_info.sum) }}₽ -->
                        </div>
                    </div>
                    <div class="text-row">
                        <div class="text-title">За полгода: </div>
                        <div class="text-value">
                            {{ data.orders.half_year_info.count }}
                            <!-- на {{ formatPrice(data.orders.half_year_info.sum) }}₽ -->
                        </div>
                    </div>
                    <div class="text-row">
                        <div class="text-title">За год: </div>
                        <div class="text-value">
                            {{ data.orders.year_info.count }}
                            <!-- на {{ formatPrice(data.orders.year_info.sum) }}₽ -->
                        </div>
                    </div>
                    <div class="text-row">
                        <div class="text-title">Всего: </div>
                        <div class="text-value">
                            {{ data.orders.info.count }}
                            <!-- на {{ formatPrice(data.orders.info.sum) }}₽ -->
                        </div>
                    </div>
                </div>
                <Link class="btn w-full" :href="route(data.orders.route)">Перейти</Link>
            </div>


        </div>

    </AppLayout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'

    export default {
        components: {
            AppLayout,
        },

        data() {
            return {
                data: this.$page.props.data,
            }
        },
    }
</script>


<style lang="sass" scoped>
    .text-grid
        @apply grid pt-3 pb-5 gap-y-1
        grid-template-columns: 1fr
        .text-row
            display: grid
            grid-template-columns: auto max-content
        .text-title
            display: flex
            align-items: baseline
            @apply text-gray-400 whitespace-nowrap
            &::after
                content: ''
                min-width: 10px
                width: 100%
                margin: 0 3px
                border-bottom: 1px dotted #aaa
        .text-value
            @apply text-gray-500 font-semibold text-right
</style>
