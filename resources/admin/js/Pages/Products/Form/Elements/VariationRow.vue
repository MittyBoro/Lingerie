<template>
	<Draggable v-model="values" item-key="value" handle=".drag-handle" :group="group" class="mt-4 col-span-full grid gap-y-4 divide-y">
		<template #item="{ element, index }">
			<div class="grid gap-2 variations-row">
				<div class="pl-1 col-icon mt-6">
					<font-awesome-icon icon="arrows-up-down-left-right" class="drag-handle scale-75"/>
				</div>
				<div class="grid gap-2 sm:grid-cols-3">
					<FLabel title="Значение" classes="text-xs">
						<FInput v-model.lazy="element.value" :placeholder="isSingle ? '-' : ''" mini />
					</FLabel>
					<FLabel title="Цена" classes="text-xs">
						<FInput type="number" v-model.number="element.price" mini />
					</FLabel>
					<FLabel title="Бонусных баллов" classes="text-xs">
						<FInput type="number" v-model.number="element.bonuses" mini />
					</FLabel>

					<FLabel v-if="promo_codes.length" as="div" classes="col-span-full bg-gray-500 bg-opacity-5 px-3 pt-2 pb-3 rounded text-xs" title="Цены по промокодам">
						<div class="grid gap-2 md:grid-cols-3">
							<div v-for="code in promo_codes" :key="code.id">
								<promo-code-col v-model="element.promo_code_prices" :code="code" />
							</div>
						</div>
					</FLabel>
				</div>
				<div class="col-icon mt-7 pl-1">
					<span @click="removeAt(index)">
						<font-awesome-icon icon="trash-can" class="text-gray-500 hover:text-primary-500 transition cursor-pointer block scale-75"/>
					</span>
				</div>
			</div>
		</template>
	</Draggable>
</template>

<script>


	import Draggable from "vuedraggable";
	import PromoCodeCol from './PromoCodeCol'


	export default {
		components: {

			Draggable,
			PromoCodeCol,
		},

		props: ['list', 'name', 'isSingle'],

		emits: ['update:element'],

		data() {
			return {
				group: Math.random(),
				promo_codes: this.$page.props.promo_codes,
			}
		},

		computed: {
			values: {
				get() {
					return this.list;
				},
				set(val) {
					this.$emit('update:element', val)
				}
			}
		},

		methods: {
			removeAt(idx) {
				this.list.splice(idx, 1);
			},
		}

	}
</script>


<style lang="sass" scoped>

	.variations-row
		@apply px-1 pt-2 pb-2 -mx-1 -mt-1 -mb-2 rounded transition
		grid-template-columns: max-content auto max-content
		&:hover
			@apply bg-white ring-1 ring-primary-200 border-transparent

</style>
