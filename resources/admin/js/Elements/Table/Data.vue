<template>
    <td :class="{'w-min': mini}">
        <div v-if="modelValue !== undefined">
            <div class="max-h-0 overflow-hidden invisible" v-html="modelValue"></div>
            <div class="-mx-2">
                <FTextarea
                    rows="1"
                    class="max-h-16 focus:max-h-max"
                    @update:modelValue="$emit('update:modelValue', $event)"
                    v-model.lazy="value"
                    :disabled="disabled"
                />
            </div>
        </div>
        <template v-else>
            <slot></slot>
        </template>
    </td>
</template>

<script>

    export default {

        props: {
            modelValue: [String, Number],
            mini: Boolean,
            disabled: Boolean,
        },

        emits: ['update:modelValue'],

        computed: {
            value: {
                get() {
                    return this.modelValue
                },
                set(value) {
                    this.$emit('update:modelValue', value)
                },
            }
        }

    }
</script>

<style lang="sass" scoped>

    textarea
        @apply bg-transparent block border-0 w-full rounded-sm shadow-none px-2 py-1 align-middle
        font-size: inherit
        &:not(:focus):hover
            @apply ring-primary-500 ring-opacity-20 ring bg-white bg-opacity-40
        &:disabled
            @apply bg-transparent pointer-events-none opacity-50

</style>
