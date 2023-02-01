<template>

    <div class="col-span-6 rounded-xl shadow-lg bg-white overflow-hidden py-8">

        <div class="font-bold text-xl mb-1 px-3 md:px-8">
            <div>Заказ #{{ element.id }}</div>
        </div>
        <div class="text-sm text-gray-500 mb-5 px-3 md:px-8">{{ formatDateTime(element.created_at) }}</div>

        <div class="customer-info gap-y-2 max-w-2xl px-3 md:px-8">
            <template v-if="element.payment_type != 'receipt' && isAdmin">
            <div class="ci-title">Статус:</div>
                <div>
                    <div class="flex items-center">
                        <div
                            class="status"
                            :class="statusColor"
                            v-text="statusName"
                        ></div>

                        <div class="link ml-2 text-xs" v-if="isAdmin" @click="element.showEdit = !element.showEdit">[изменить статус]</div>
                    </div>
                    <FSelect v-if="element.showEdit" :options="statuses" v-model="status" @update:modelValue="updateStatus" class="mt-2 max-w-xs" mini/>

                </div>
            </template>
            <template v-if="element.payment_type">
                <div class="ci-title">Метод оплаты:</div>
                <div>
                    <div>{{ paymentName }}</div>
                    <div v-if="element.payment_id" class="font-mono text-xs">[{{ element.payment_id }}]</div>
                </div>
            </template>
            <template v-if="element.url">
                <div class="ci-title">URL оплаты:</div>
                <div class="max-w-max overflow-hidden"><a class="link" :href="element.url" target="_blank">{{ element.url }}</a></div>
            </template>

            <div class="ci-title">Имя:</div>
            <div>{{ element.name }}</div>

            <div class="ci-title">Телефон:</div>
            <div>{{ element.phone }}</div>

            <div class="ci-title">Email:</div>
            <div>{{ element.email }}</div>

            <template v-if="element.address">
                <div class="ci-title">Адрес:</div>
                <div>{{ element.address.country }}, {{ element.address.region }}, {{ element.address.city }}, {{ element.address.street }}</div>

                <template v-if="element.address.postcode">
                    <div class="ci-title">Индекс:</div>
                    <div>{{ element.address.postcode }}</div>
                </template>

            </template>

            <template v-if="element.comment">
                <div class="ci-title">Примечание:</div>
                <div class="whitespace-pre-line">{{ element.comment }}</div>
            </template>

            <div class="col-span-full py-2"></div>

            <div class="ci-title self-center">Итого:</div>
            <div class="self-center">
                <span class="px-2 py-0.5 text-white font-bold bg-primary-400 rounded">{{ formatPrice(element.amount) }} {{ currency }}</span>
                <span @click="showProducts = !showProducts" class="ml-2 text-xs uppercase border-b border-dashed cursor-pointer text-primary-500 font-semibold">
                    <span v-if="!showProducts">Показать</span>
                    <span v-else>Скрыть</span>
                    <span> ({{ element.items.length }})</span>
                </span>
            </div>
        </div>

        <div v-show="showProducts" class="mt-6 product text-sm grid gap-y-3 gap-x-5 items-center px-3 md:px-8 bg-gray-50 bg-opacity-80 py-3">
            <template v-for="item in element.items" :key="item.id">
                <div>
                    <img v-if="item.product"
                        :src="item.product.preview"
                        class="h-8 w-8 rounded shadow object-cover" alt="">
                </div>

                <div>
                    <a v-if="item.product" class="hover-link" target="_blank" :href="'/product/' + item.product.slug">{{ item.name }}</a>
                    <span v-else>{{ itemName(item.name) }}</span>
                    <div class="text-xs mt-0 5">{{ optionsToString(item.options) }}</div>
                </div>

                <div class="text-xs text-gray-600">
                    <div>
                        <span>Цена: </span>
                        <span>{{ formatPrice(item.price) }} {{ currency }}</span>
                    </div>
                    <div>Количество: <span>{{ item.quantity }}</span></div>
                    <div>Стоимость: <span class="font-semibold">{{ formatPrice(item.price * item.quantity) }} {{ currency }}</span></div>
                </div>
            </template>
        </div>

    </div>

</template>

<script>

    export default {

        props: ['element', 'single', 'user'],

        data() {
            return {
                showProducts: this.element.items.length < 5,

                status: this.element.status,

                statuses: {
                    'success': 'Оплачено',
                    'pending': 'Ожидается',
                    'canceled': 'Отменено',
                    'refunded': 'Возвращено',
                }
            }
        },

        computed: {
            statusName() {
                if (this.element.status == 'success')
                    return 'Оплачено'
                else if (this.element.status == 'pending')
                    return 'Ожидается'
                else if (this.element.status == 'canceled')
                    return 'Отменено'
                else if (this.element.status == 'refunded')
                    return 'Возвращено'
                else
                    return this.element.status
            },
            statusColor() {
                if (this.element.status == 'success')
                    return 'bg-green-500'
                else if (this.element.status == 'pending')
                    return 'bg-yellow-500'
                else
                    return 'bg-gray-500'
            },
            paymentName() {
                if (this.element.payment_type == 'yookassa')
                    return 'ЮКасса'
                else if (this.element.payment_type == 'receipt')
                    return 'При получении'
                else
                    return this.element.payment_type
            },
            currency() {
                return this.currencySymbol(this.element.currency)
            },
        },

        methods: {
            itemName(name) {
                if (name == 'shipping')
                    return 'Доставка'
                else
                    return name
            },
            optionsToString(options) {
                if (!options) return

                let str = Array.from(options).map(el => el.string).join(', ')
                return str;
            },
            updateStatus(status) {
                if (!confirm('Вы уверены, что хотите изменить статус заказа?'))
                    return;

                let form = this.$inertia.form({
                    status: status,
                });

                form.put( route('admin.orders.update', this.element.id), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.element.status = this.status;
                    },
                    onError: () => {
                        this.status = this.element.status;
                    },
                });
            }
        },
    }

</script>

<style lang="sass" scoped>
    .product
        grid-template-columns: max-content auto max-content
    .status
        @apply inline-flex items-center px-2 py-0.5 text-white rounded text-xs

</style>
