<template>
    <div class="col-span-6 grid grid-cols-6 gap-5">

        <FLabel title="Описание" :error="form.errors.description" as="div">
            <FTextareaEditor v-model="form.description" :mini="true" :allowImages="false"/>
        </FLabel>

        <!-- characteristics -->
        <div class="col-span-6 xl:col-span-4 mt-3">
            <div class="text-lg font-semibold mb-4">Характеристики</div>
            <Draggable v-if="characteristics.length" class="mb-6 grid gap-y-6" v-model="characteristics" item-key="index" handle=".drag-handle">
                <template #item="{ element, index }">
                    <div class="grid gap-3 row-variations characteristics-grid">
                        <div class="col-icon mt-6 pt-0.5">
                            <Icon icon="arrows-up-down-left-right" class="drag-handle"/>
                        </div>
                        <div>
                            <FLabel title="Описание">
                                <FInput classes="text-xs max-h-9" :options="characteristics_list" v-model="element.name" required />
                            </FLabel>
                        </div>
                        <div>
                            <FLabel title="Значение">
                                <FTextarea rows="1" class="col-textarea text-xs" v-model="element.value" required />
                            </FLabel>
                        </div>
                        <div class="col-icon mt-6 pt-0.5">
                            <Icon @click="removeAt(index)" icon="trash-can" class="text-gray-500 hover:text-primary-500 transition cursor-pointer block"/>
                        </div>
                    </div>
                </template>
            </Draggable>
            <div @click="addDetail" class="btn-gray w-full">
                <span>Добавить</span>
                <Icon icon="plus" class="ml-1" />
            </div>
        </div>

    </div>
</template>


<script>

    import Draggable from "vuedraggable";

    export default {
        components: {
            Draggable,
        },

        props: ['form'],

        data() {
            return {
                characteristics_list: Object.values(this.$page.props.characteristics_list),
            }
        },

        created() {
            if (!this.form.characteristics)
                this.form.characteristics = [];
        },

        computed: {
            characteristics: {
                get() {
                    return this.form.characteristics;
                },
                set(val) {
                    this.form.characteristics = characteristics;
                },
            },
        },


        methods: {
            addDetail() {
                let defaultRow = {
                    name: '',
                    value: '',
                }
                this.characteristics.push(defaultRow);
            },
            removeAt(idx) {
                this.characteristics.splice(idx, 1);
            },
        },
    }

</script>


<style lang="sass" scoped>
    .col-textarea
        min-height: 36px

    .characteristics-grid
        @apply px-2 pt-2 pb-3 -mt-2 -mb-3 rounded
        grid-template-columns: max-content auto max-content
        align-items: center
        &:nth-child(2n)
            @apply bg-gray-50
        & > div:not(.col-icon)
            grid-column: 2 / 3
        & > .col-icon
            grid-row: 1 / 3
            &:last-child
                grid-column-start: 3
    @screen lg
        .characteristics-grid
            grid-template-columns: max-content auto auto max-content
            & > div
                grid-row: auto / auto !important
                grid-column: auto / auto !important
</style>
