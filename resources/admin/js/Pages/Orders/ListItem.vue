<template>

	<div class="col-span-6 rounded-xl shadow-lg bg-white overflow-hidden py-8">

		<div class="font-bold text-xl mb-1 px-3 md:px-8">
			<Link v-if="!single" class="hover-link" :href="route('admin.product_orders.show', element.id)">Заказ #{{ element.id }}</Link>
			<div v-else>Заказ #{{ element.id }}</div>
		</div>
		<div class="text-sm text-gray-500 mb-5 px-3 md:px-8">{{ formatDateTime(element.created_at) }}</div>

		<div class="customer-info gap-y-2 max-w-2xl px-3 md:px-8">
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
			<template v-if="element.payment_type && isAdmin">
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

			<template v-if="element.user && !user">
				<div class="ci-title">Покупатель:</div>
				<div>
					<Link class="link" :href="route('admin.users.show', element.user.id)"><font-awesome-icon class="scale-75" icon="user"/> {{ element.user.name }}</Link> <Link class="hover-link text-xs opacity-70" :href="route('admin.product_orders.index', { user_id: element.user.id })">[все заказы]</Link>
				</div>
			</template>

			<div class="ci-title">Имя:</div>
			<div>{{ element.name }}</div>

			<div class="ci-title">Телефон:</div>
			<div>{{ element.phone }}</div>

			<div class="ci-title">Email:</div>
			<div>{{ element.email }}</div>

			<template v-if="element.address">
				<div class="ci-title">Адрес:</div>
				<div>{{ element.address.region }}, {{ element.address.city }}, {{ element.address.street }}</div>

				<template v-if="element.address.postcode">
					<div class="ci-title">Индекс:</div>
					<div>{{ element.address.postcode }}</div>
				</template>

				<template v-if="element.address.transport">
					<div class="ci-title">Тр. компания:</div>
					<div>{{ element.address.transport }}</div>
				</template>
			</template>

			<template v-if="element.comment">
				<div class="ci-title">Примечание:</div>
				<div class="whitespace-pre-line">{{ element.comment }}</div>
			</template>

			<div class="col-span-full py-2"></div>

			<template v-if="element.promocode">
				<div class="ci-title">Промокод:</div>
				<div>
					<span class="text-gray-500 text-sm font-semibold">{{ element.promocode }}</span>
				</div>
			</template>

			<template v-if="element.bonus">
				<div class="ci-title">Баллов получено:</div>
				<div>{{ element.bonus.amount }}</div>
			</template>

			<div class="ci-title">Товары:</div>
			<div>{{ formatPrice(element.old_amount) }}₽</div>

			<template v-if="element.discounts">
				<div class="ci-title">Скидки:</div>
				<div class="opacity-70">{{ element.discounts }}</div>
			</template>

			<div class="ci-title">Доставка:</div>
			<div>{{ formatPrice(element.delivery) }}₽</div>

			<div class="ci-title self-center">Итого:</div>
			<div class="self-center">
				<span class="px-2 py-0.5 text-white font-bold bg-primary-400 rounded">{{ formatPrice(element.amount) }}₽</span>
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
					<img
						:src="item.product.preview"
						class="h-8 w-8 rounded shadow object-cover" alt="">
				</div>

				<div>
					<a class="hover-link" target="_blank" :href="'/product/' + item.product.slug">{{ item.name }}</a>
					<div :class="{'mt-0.5': !i}" class="text-xs" v-for="(attr, i) in item.variations" :key="i">
						<template v-if="attr.name" >
							<span>{{ attr.name }}</span>: <span>{{ attr.value }}</span>
						</template>
					</div>
				</div>

				<div class="text-xs text-gray-600">
					<div>
						<span>Цена: </span>
						<template v-if="item.discount_price != item.price">
							<span >{{ formatPrice(item.discount_price) }}₽</span>
							<span class="ml-1 line-through opacity-50">{{ formatPrice(item.price) }}₽</span>
						</template>
						<template v-else>
							<span >{{ formatPrice(item.price) }}₽</span>
						</template>
					</div>
					<div>Количество: <span>{{ item.quantity }}</span></div>
					<div>Стоимость: <span class="font-semibold">{{ formatPrice((item.discount_price || item.price) * item.quantity) }}₽</span></div>
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
				isAdmin: this.$page.props.auth.user.role == 'admin',

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
				if (this.element.payment_type == 'tinkoff')
					return 'Тинькофф Рассрочка'
				else if (this.element.payment_type == 'dolyame')
					return 'Долями'
				else if (this.element.payment_type == 'yookassa')
					return 'ЮКасса'
				else
					return this.element.payment_type
			},
		},

		methods: {
			updateStatus(status) {
				if (!confirm('Вы уверены, что хотите изменить статус заказа?'))
					return;

				let form = this.$inertia.form({
					status: status,
				});

				form.put( route('admin.product_orders.update', this.element.id), {
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
