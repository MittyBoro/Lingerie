<template>

	<div class="flex flex-wrap px-6 md:px-10 py-3">
		<label class="mr-8 my-2">
			<f-select :options="whoList" v-model.lazy="filter.who" @update:modelValue="setFilter" mini/>
		</label>

		<div class="mr-8 my-2">
			<f-input placeholder="Город" @update:modelValue="setFilter" autocomplete='random-address' :options="cities" showAll v-model.lazy="filter.city" mini/>
		</div>
		<div class="my-2">
			<f-input placeholder="Имя" @update:modelValue="setFilter" v-model.lazy="filter.person_name" mini/>
		</div>

	</div>

</template>

<script>

	export default {

		data() {
			let urlParams = new URLSearchParams(location.search);
			let filter = {
				city: urlParams.get('city'),
				person_name: urlParams.get('person_name'),
				who: urlParams.get('who'),
			};

			return {
				whoList: [
					[null, 'Все'],
					['is_franchisee', 'Франчайзи'],
					['is_distributor', 'Дистрибьюторы'],
				],

				cities: this.$page.props.cities,
				filter: Object.assign({
					city: '',
					person_name: '',
					perPage: this.$page.props.list.per_page,
					who: '',
				}, filter)
			}
		},

		methods: {
			setFilter() {
				setTimeout(() => {
					let urlParams = new URLSearchParams(location.search);
					let params = Object.fromEntries(urlParams);

					let filter = Object.assign(params, this.filter);

					this.$inertia.visit( route(route().current(), filter ), {
						preserveState: true,
						preserveScroll: true,
					});
				}, 40);
			},
		},

	}
</script>
