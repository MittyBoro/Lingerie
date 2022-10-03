<template>

	<div class="col-span-6 grid grid-cols-6 gap-4">
		<!-- <div class="col-span-6 text-xs text-gray-400 d-none">
			may be later
			<span class="text-sm text-gray-700">Практически во всех случаях информация ниже не потребуется</span><br>
			Если цена вариации выше нуля - будет выбираться максимально выбранная из всех<br>
			Если цена ниже нуля - будет вычитаться из общей стоимости самая минимальная
		</div> -->

		<!-- prod_list -->
		<div class="col-span-6 xl:col-span-4">
			<div class="mb-4">
				<div class="text-lg font-semibold">Вариации</div>
				<div v-if="list.length > 1" class="text-xs text-gray-400">{{ options.join(', ') }}</div>
			</div>

			<draggable v-if="list.length" class="mb-6 grid gap-y-4" v-model="list" item-key="name" handle=".drag-handle" group="name" >
				<template #item="{ element, index }">
					<div class="variations-big flex flex-col">
						<div class="grid gap-3 variations-row">
							<div class="col-icon mt-6 pt-0.5">
								<font-awesome-icon icon="arrows-up-down-left-right" class="drag-handle"/>
							</div>
							<f-label title="Имя вариации" classes="">
								<f-input v-model.lazy="element.name" :placeholder="isSingle ? '-' : ''" :required="element.list.length > 1" mini/>
							</f-label>
							<div class="col-icon mt-7 pt-0.5">
								<span @click="removeAt(index)">
									<font-awesome-icon icon="trash-can" class="text-gray-500 hover:text-primary-500 transition cursor-pointer block"/>
								</span>
							</div>
						</div>
						<variation-row :list="element.list" :name="element.name" @update:element="element.list = $event" :isSingle="isSingle" />
						<div @click="addVariation(element.name)" class="btn-gray btn-mini ml-auto mt-3">
							<span>Добавить</span>
							<font-awesome-icon icon="plus" class="ml-1" />
						</div>
					</div>
				</template>
			</draggable>

			<div class="flex">
				<div @click="addVariation()" class="btn-gray w-full">
					<span>Добавить</span>
					<font-awesome-icon icon="plus" class="ml-1" />
				</div>
				<div class="w-3 flex-shrink-0"></div>
				<div @click="showText = !showText" class="btn-gray flex-shrink-0">Из текста</div>
			</div>
			<div v-show="showText" class="fromtext mt-4">
				<f-label title="Например: «Цвет: Синий | Красный | Желтый = 200»">
					<f-textarea v-model="variText" />
				</f-label>
				<div @click="textToList" class="mt-2 btn-gray w-full">Текст в вариации</div>
			</div>
		</div>

	</div>

</template>

<script>

	import Draggable from "vuedraggable";
	import VariationRow from "./Elements/VariationRow";

	export default {
		components: {
			Draggable,
			VariationRow,
		},

		props: ['form'],

		data() {
			return {
				showText: false,
				variText: '',
				list: [],
			};
		},

		computed: {
			options() {
				let options = [];

				this.form.variations.forEach(el => {
					if (el.name)
						options.push(el.name);
				});

				return options.filter( (e,i,a) => a.indexOf(e) == i );
			},
			isSingle() {
				return this.form.variations && this.form.variations.length == 1;
			},
		},

		watch: {
			list: {
				deep: true,
				handler: function(val) {

					let formList = []

					val.forEach(el => {

						let current = Object.assign(el);

						if (!current.list.length)
							return;

						let arr = Array.from(current.list).map(l => {
							l.name = current.name
							return l;
						})

						formList = [...formList, ...arr]
					});

					this.form.variations = formList
				}
			}
		},

		created() {

			if (!this.form.variations)
				this.form.variations = []

			this.setListFromForm();

			if (!this.list.length)
				this.addVariation();
		},

		methods: {
			addVariation(name = '', value = '', price = 0) {
				let row = {
					name: name,
					value: value,
					price: price,
					bonuses: 0,
					promocodes: [],
				}
				this.form.variations.push(row);

				this.setListFromForm()
			},

			setElementPromo(element, code, price) {
				element.promocodes[code.id] = {
					id: code.id,
					price: price,
				}
				return element
			},

			removeAt(idx) {
				this.list.splice(idx, 1);
			},

			boolInt(int) {
				return !!parseInt(int, 10);
			},

			setListFromForm() {
				let list = {};

				if (!this.form.variations)
					return this.list = []

				this.form.variations.forEach(el => {
					if (list[el.name]) {
						list[el.name].list.push(el)
					}  else {
						list[el.name] = {
							name: el.name,
							list: [el],
						}
					}
				})

				this.list = Object.values(list);
			},

			textToList() {
				this.variText.trim().split("\n").forEach(row => {
					let rowArr = row.split(':');
					let name = rowArr[0].trim();
					(rowArr[1] || '').split('|').forEach(el => {
						let elArr = el.split('=');
						let value = elArr[0].trim();
						let price = ( elArr[1] || '0' ).trim();
						this.addVariation(name, value, price);
					});
				});

				this.variText = ''
				this.showText = false
			},
		},

	}
</script>

<style lang="sass" scoped>

	:deep(.fromtext)
		textarea
			min-height: 3em

	.variations-big
		@apply px-2 py-3 border rounded bg-gray-50

	.variations-row
		grid-template-columns: max-content auto max-content

</style>
