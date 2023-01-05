<template>
    <draggable class="loading" :class="{drag: drag}" v-model="myList" item-key="id" handle=".drag-handle" @change="saveSort" @start="drag=true" @end="drag=false" >
        <template #item="{ element }">
            <PropsItem :item="element" />
        </template>
    </draggable>
</template>

<script>

    import draggable  from "vuedraggable";
    import PropsItem from "./Item";

    export default {
        components: {
            draggable,
            PropsItem,
        },

        props: {
            list: Array,
        },

        data() {
            return {
                routePrefix: 'admin.props.',
                drag: false,
            }
        },

        computed: {
            myList: {
                get() {
                    return this.list;
                },
                set(value) {
                    // this.list = value;
                    this.saveSort()
                }
            },
        },

        methods: {
            saveSort() {
                let sortedList = this.list.map((element, index) => {
                    return {
                        id: element.id,
                        position: index
                    }
                });

                let form = this.$inertia.form({sorted: sortedList});
                form.post( route( this.routePrefix + 'sort' ), {
                    preserveScroll: true,
                    preserveState: true,
                });
            },
        }


    }
</script>

<style lang="sass" scoped>
    .drag
        :deep(.props-item)
            pointer-events: none

</style>
