<template>
	<f-label as="div" title="Контакты, доп. данные" class="mt-3">
		<draggable v-if="information && information.length" class="mb-6 grid gap-y-4" v-model="information" item-key="index" handle=".drag-handle">
			<template #item="{ element, index }">
				<div class="grid gap-4 row-variations information-grid">
					<div class="col-icon mt-6 pt-0.5">
						<font-awesome-icon icon="arrows-up-down-left-right" class="drag-handle"/>
					</div>
					<information-item :modelValue="element" @update:modelValue="element = $event" />
					<div class="col-icon mt-7 pt-0.5">
						<font-awesome-icon @click="removeAt(index)" icon="trash-can" class="text-gray-500 hover:text-primary-500 transition cursor-pointer block"/>
					</div>
				</div>
			</template>
		</draggable>
		<div @click="addAttr" class="btn-gray w-full">
			<span>Добавить</span>
			<font-awesome-icon icon="plus" class="ml-1" />
		</div>
	</f-label>
</template>

<script>

	import Draggable from "vuedraggable";
	import InformationItem from "./InformationItem";

	export default {
		components: {
			InformationItem,
			Draggable,
		},

		props: ['modelValue'],
		emits: ['update:modelValue'],
		data() {
			return {
				cities: this.$page.props.cities,
			}
		},

		computed: {
			information: {
				get() {
					return this.modelValue;
				},
				set(val) {
					this.$emit('update:modelValue', val)
				},
			},
		},

		methods: {

			addAttr() {
				let defaultRow = {
					type: '',
					value: '',
				}
				if (!this.information)
					this.information = [defaultRow];
				else
					this.information.push(defaultRow);
			},
			removeAt(idx) {
				this.information.splice(idx, 1);
			},
		},

	}
</script>

<style lang="sass" scoped>
	.information-grid
		grid-template-columns: max-content auto max-content

</style>
