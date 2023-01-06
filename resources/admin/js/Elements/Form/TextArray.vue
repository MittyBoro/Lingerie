<template>
    <!-- characteristics -->
    <div class="flex flex-col">
        <Draggable class="grid gap-2" v-model="values" item-key="index" handle=".drag-handle">
            <template #item="{ element, index }">
                <div class="flex items-center">
                    <Icon icon="arrows-up-down-left-right" class="drag-handle"/>
                    <div class="mx-3 w-full">
                        <FTextarea rows="1" class="text-xs" v-model="element.value" required />
                    </div>
                    <Icon @click="removeAt(index)" icon="trash-can" class="text-gray-500 hover:text-primary-500 transition cursor-pointer block"/>
                </div>
            </template>
        </Draggable>
        <div @click="add" class="btn-secondary mt-3 ml-auto" :class="values.length ? 'btn-mini' : 'w-full'">
            <span>Добавить</span>
            <Icon icon="plus" class="ml-1" />
        </div>
    </div>
</template>

<script>

    import Draggable from "vuedraggable";

    export default {
        components: {
            Draggable,
        },

        props: {
            modelValue: [Array],
        },

        emits: ['update:modelValue', 'change'],

        data() {
            return {
                group: Math.random(),
                values: (this.modelValue || []).map(el => ({value: el}))
            }
        },

        watch: {
            values: {
                deep: true,
                handler(val) {
                    this.$emit('update:modelValue', val.map(el => el.value));
                }
            }
        },

        methods: {
            add() {
                this.values.push({
                    value: '',
                });
            },
            removeAt(idx) {
                this.values.splice(idx, 1);
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
