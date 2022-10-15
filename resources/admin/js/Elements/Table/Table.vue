<template>
    <div class="table-wrapper loading text-sm">
        <TPagination v-if="(pagination && pagination.total) || sortRoute" :pages="pagination" class="border-t" ref="pagination">
            <div
                v-if="sortRoute"
                @click="sortToggle"
                class="ml-auto">
                <div v-if="!sortEnable" class="btn btn-mini">Сортировать</div>
                <div v-else class="btn-gray btn-mini">Назад</div>
            </div>

        </TPagination>

        <div class="table-overflow">
            <table v-if="items && items.length > 0" class="border-t table">

                <THead v-if="headers" :headers="headers" />
                <thead v-else-if="$slots.thead">
                    <slot name="thead"></slot>
                </thead>

                <template v-if="$slots.row" >
                    <tbody v-if="!sortRoute">
                        <tr v-for="element in items" :key="element.id">
                            <slot name="row" :element="element"></slot>
                            <TData v-if="editRoute" class="w-min">
                                <Link :href="route(editRoute, element.id)">
                                    <Icon icon="pencil" class="text-gray-500 hover-link"/>
                				</Link>
							</TData>
							<TData v-if="destroyRoute" class="w-min">
								<Link :href="route(destroyRoute, element.id)" method="delete" as="button">
									<Icon @click="confirm" icon="trash-can" class="text-gray-500 hover-link block"/>
								</Link>
							</TData>
						</tr>
					</tbody>
					<Draggable v-else tag="tbody" v-model="items" item-key="element.id" handle=".drag-handle" :scroll="true" :scroll-sensitivity="500">
						<template #item="{ element }">
							<tr class="drag-tr">
								<TData v-if="sortEnable" class="sort-td w-min">
									<Icon icon="arrows-up-down-left-right" class="drag-handle"/>
								</TData>
								<slot name="row" :element="element"></slot>
								<TData v-if="editRoute" class="w-min">
									<Link :href="route(editRoute, element.id)">
										<Icon icon="pencil" class="text-gray-500 hover:text-primary-500 transition cursor-pointer"/>
									</Link>
								</TData>
								<TData v-if="destroyRoute" class="w-min">
									<Link :href="route(destroyRoute, element.id)" method="delete" as="button">
										<Icon @click="confirm" icon="trash-can" class="text-gray-500 hover:text-primary-500 transition cursor-pointer block"/>
									</Link>
								</TData>
							</tr>
						</template>
					</Draggable>
				</template>
				<TBody v-else :items="items" :headers="headers" />

			</table>

			<TNotify class="border-t border-b" v-else>Данных ещё нет</TNotify>
		</div>
		<div v-if="sortEnable" class="table-save-row border-b">
			<div @click="saveSort" class="btn w-full">Сохранить сортировку</div>
		</div>

		<TPagination ref="pagination" v-if="pagination && pagination.total" :pages="pagination" />
	</div>
</template>


<script>
	import Draggable from "vuedraggable";

	export default {
		components: {
			Draggable
		},

		props: ['table'],

		data() {
			return {
				headers: null,
				items: null,
				pagination: null,
				sortRoute: null,
				editRoute: null,
				destroyRoute: null,

				sortEnable: false,
			}
		},

		watch: {
			table(e) {
				this.setVariables();
			},
			sortEnable(e) {
				this.setVariables();
			},
		},

		created() {
			this.setVariables();
		},

		methods: {

			setVariables() {
				this.headers = [...this.table.headers]
				this.items = this.table.items
				this.pagination = this.table.pagination
				this.sortRoute = this.table.sortRoute
				this.editRoute = this.table.editRoute
				this.destroyRoute = this.table.destroyRoute
				if (this.headers) {
					if (this.sortRoute && this.sortEnable)
						this.headers = [{class: 'sort-td'}, ...this.headers]
					if (this.editRoute)
						this.headers.push({})
					if (this.destroyRoute)
						this.headers.push({})
				}
			},

			saveSort() {
				let sortedList = this.items.map((element, index) => {
					return {
						id: element.id,
						position: index
					}
				});

				let form = this.$inertia.form({sorted: sortedList});
				form.post( route( this.sortRoute ), {
					preserveScroll: true,
					preserveState: true,
					onSuccess: () => {
						this.sortToggle();
					},
				});
			},

			sortToggle() {

				if ( this.pagination ) {
					if ( !this.sortEnable ) {
						if (this.pagination.per_page < this.pagination.total) {
							this.$refs.pagination.showAll()
						}
					}
					else {
						this.$refs.pagination.showDefault()
					}
				}

				this.sortEnable = !this.sortEnable
				this.setVariables();
			},
		},

	}
</script>
