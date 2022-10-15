<template>
    <div
        class="menu-item"
        :class="{ 'is-active': isActive ? isActive(): null, disabled: disabled }"
        @click="action"
        :title="title"
        >
        <Icon :icon="icon" />
    </div>
</template>

<script>

    export default {
        props: {
            icon: {
                type: String,
                required: true,
            },

            title: {
                type: String,
                required: true,
            },

            action: {
                type: Function,
                required: true,
            },

            disabled: {
                type: Boolean,
                default: false,
            },

            isActive: {
                type: Function,
                default: null,
            },
        },

        data() {
            return {
            }
        },
    }
</script>

<style lang="sass">
    .menu-item
        @apply flex items-center justify-center text-gray-500 py-1.5 w-7 h-7 rounded mx-0.5 transition
        cursor: pointer
        svg
            width: 100%
            height: 100%
            fill: currentColor

        &.disabled
            @apply pointer-events-none opacity-30

        &.is-active
            @apply bg-gray-500 text-white
        &:hover
            @apply bg-gray-600 text-white
</style>
