<template>
    <draggable class="loading form-grid" :class="{drag: drag}" v-model="myList" item-key="id" handle=".drag-handle" @start="drag=true" @end="drag=false" >
        <template #item="{ element }">
            <PropsItem :item="element" v-model="element.value" v-show="activeTab == element.tab" />
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
            list: [Array, Object],
            activeTab: String,
        },
        emits: ['update'],

        data() {
            return {
                drag: false,
            }
        },

        computed: {
            myList: {
                get() {
                    return this.list;
                },
                set(value) {
                    this.$emit("update", value);
                }
            },
        },

    }
</script>

<style lang="sass" scoped>
    .drag
        :deep(.props-item)
            pointer-events: none

</style>
