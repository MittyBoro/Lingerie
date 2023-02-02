<template>
    <div class="table-wrapper loading text-sm">
        <TPagination v-if="(pagination && pagination.total) || (!pagination && routes.sort)" :pages="pagination" class="border-t" ref="pagination">
            <div
                v-if="routes.sort"
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
                    <Draggable tag="tbody" v-model="items" item-key="element.id" handle=".drag-handle" :scroll="true" :scroll-sensitivity="500">
                        <template #item="{ element }">
                            <tr class="drag-tr">
                                <TData v-if="sortEnable" class="sort-td" mini>
                                    <Icon icon="arrows-up-down-left-right" class="drag-handle"/>
                                </TData>
                                <slot name="row" :element="element"></slot>
                                <TData v-if="routes.show" mini>
                                    <Link :href="route(routes.show, element.id)">
                                        <Icon icon="eye" class="text-gray-500 hover:text-primary-500 transition cursor-pointer"/>
                                    </Link>
                                </TData>
                                <TData v-if="routes.edit" mini>
                                    <Link :href="route(routes.edit, element.id)">
                                        <Icon icon="pencil" class="text-gray-500 hover:text-primary-500 transition cursor-pointer"/>
                                    </Link>
                                </TData>
                                <TData v-if="routes.destroy" mini>
                                    <Link :href="route(routes.destroy, element.id)" method="delete" as="button">
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
                destroyRoute: null,

                sortEnable: false,
                routes: {
                    sort: null,
                    show: null,
                    edit: null,
                    destroy: null,
                },
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

                Object.keys(this.routes).forEach( key => {

                    let routeValue = this.currentRouteStr(key)

                    if ( !route().has(routeValue) || this.table.hideRoutes?.includes(key) ) {
                        delete this.routes[key]
                    }
                    else {
                        this.routes[key] = routeValue
                        if (key == 'sort') {
                            if (this.sortEnable) {
                                this.headers = [{class: 'sort-td'}, ...this.headers]
                            }
                        }
                        else {
                            this.headers.push({})
                        }
                    }
                })
            },

            saveSort() {
                let sortedList = this.items.map((element, index) => {
                    return {
                        id: element.id,
                        position: index
                    }
                });

                let form = this.$inertia.form({sorted: sortedList});
                form.post( route( this.routes.sort ), {
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
