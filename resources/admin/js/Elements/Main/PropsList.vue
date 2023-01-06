<template>
    <draggable  class="form-grid" :class="{drag: drag}" v-model="myList" item-key="id" handle=".drag-handle" @change="changePosition"  @start="drag=true" @end="drag=false" >
        <template #item="{ element, index }">
            <PropsItem :item="element" :error="errors?.[index]?.value" v-model="element.value" v-show="!activeTab || activeTab == element.tab" />
        </template>
    </draggable>
</template>

<script>

    import draggable  from "vuedraggable";
    import PropsItem from "./Props/Item";

    export default {
        components: {
            draggable,
            PropsItem,
        },

        props: {
            errors: [Object],
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

        methods: {
            changePosition() {
                this.myList = this.myList.map((element, index) => {
                    element.position = index
                    return element
                });
            },
        },

    }
</script>

<style lang="sass" scoped>
    .drag
        :deep(.props-item)
            pointer-events: none

</style>
