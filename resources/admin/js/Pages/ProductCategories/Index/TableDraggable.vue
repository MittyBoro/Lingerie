
<template>
    <table class="table">
        <Draggable @change="$emit('showSaveBtn')" tag="tbody" group="pc" :list="list" item-key="id" handle=".drag-handle">
            <template #item="{ element }">
            <tr>
            <td class="no-style p-0">
                <table class="table big-row">
                    <tbody>
                        <tr class="drag-tr">
                            <TData class="sort-td w-min" :class="{'border-l': deep}">
                                <Icon icon="arrows-up-down-left-right" class="drag-handle"/>
                            </TData>
                            <TData title="Название" v-text="element.title" />

                            <TData mini>
                                <Link :href="route('admin.products.index', {category: element.id})" class="link font-bold text-xs flex items-center">
                                    <Icon icon="box-open" class="mr-1" />
                                    <span>{{ element.models_count }}</span>
                                </Link>
                            </TData>
                            <TData mini>
                                <Link :href="currentRoute('show', element.id)">
                                    <Icon icon="eye" class="text-gray-500 hover:text-primary-500 transition cursor-pointer"/>
                                </Link>
                            </TData>
                            <TData mini>
                                <Link :href="currentRoute('edit', element.id)">
                                    <Icon icon="pencil" class="text-gray-500 hover:text-primary-500 transition cursor-pointer"/>
                                </Link>
                            </TData>
                            <TData mini>
                                <Link :href="currentRoute('destroy', element.id)" method="delete" as="button">
                                    <Icon @click="confirm" icon="trash-can" class="text-gray-500 hover:text-primary-500 transition cursor-pointer block"/>
                                </Link>
                            </TData>
                        </tr>
                        <tr>
                            <td colspan="6" class="no-style pl-4 p-0 bg-gray-500 bg-opacity-10 ">
                                <table-draggable :deep="deep + 1" :list="element.children" @showSaveBtn="$emit('showSaveBtn')" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
            </tr>
            </template>
        </Draggable>
    </table>

</template>

<script>

    import Draggable from "vuedraggable";

    export default {
        name: "table-draggable",
        components: {
            Draggable,
        },

        props: {
            list: {
                type: Array,
                default: []
            },
            deep: {
                type: Number,
                default: 0
            },
        },

        emits: ['showSaveBtn'],

        data() {
            return {
            }
        },

        computed: {
            table() {
                return {
                    items: this.list,
                }
            },
        },

        methods: {

            update(element) {
                let form = this.$inertia.form(element);

                form.put( this.currentRoute('update', {category: element.id, index_edit: 1}) , {
                    preserveScroll: true,
                });
            },
        },
    }
</script>

<style lang="sass" scoped>
    .sort-td
        @apply mr-2
    .big-row
        @apply border-gray-500 border-opacity-20
    .sortable-ghost
        z-index: 30
        .table
            @apply bg-opacity-80 bg-primary-300


</style>
