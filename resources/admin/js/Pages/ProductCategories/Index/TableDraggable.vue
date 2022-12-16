
<template>
    <table class="table">
        <Draggable @change="$emit('showSaveBtn')" tag="tbody" :group="{ name: type }" :list="list" item-key="id" handle=".drag-handle">
            <template #item="{ element }">
            <tr>
            <td class="no-style p-0">
                <table class="table big-row">
                    <tbody>
                        <tr class="drag-tr">
                            <TData class="sort-td w-min" :class="{'border-l': deep}">
                                <Icon icon="arrows-up-down-left-right" class="drag-handle"/>
                            </TData>
                            <TData title="Название" v-model="element.title" @update:modelValue="update(element)" />

                            <TData class="w-min">
                                <Link :href="route('admin.' + type + '.index', {category: element.id})" class="link font-bold text-xs flex items-center">
                                    <Icon icon="box-open" class="mr-1" />
                                    <span>{{ element.models_count }}</span>
                                </Link>
                            </TData>
                            <TData class="w-min">
                                <Link :href="currentRoute('edit', {category: element.id, type: type})">
                                    <Icon icon="pencil" class="text-gray-500 hover:text-primary-500 transition cursor-pointer"/>
                                </Link>
                            </TData>
                            <TData class="w-min">
                                <Link :href="currentRoute('destroy', {category: element.id, type: type})" method="delete" as="button">
                                    <Icon @click="confirm" icon="trash-can" class="text-gray-500 hover:text-primary-500 transition cursor-pointer block"/>
                                </Link>
                            </TData>
                        </tr>
                        <tr>
                            <td colspan="5" class="no-style pl-6 p-0 bg-gray-500 bg-opacity-10 ">
                                <table-draggable :deep="deep + 1" :type="type" :list="element.children" @showSaveBtn="$emit('showSaveBtn')" />
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
            type: String,
            deep: {
                type: Number,
                default: 0
            },
        },

        emits: ['showSaveBtn'],

        data() {
            return {
                routePrefix: 'admin.categories.',
            }
        },

        computed: {
            table() {
                return {
                    items: this.list,

                    sortRoute: this.routePrefix + 'sort',
                    // editRoute: this.routePrefix + 'edit',
                    // destroyRoute: this.routePrefix + 'destroy',
                }
            },
        },

        methods: {

            update(element) {
                let form = this.$inertia.form(element);

                form.put( this.currentRoute('update', {category: element.id, type: this.type, index_edit: 1}) , {
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
