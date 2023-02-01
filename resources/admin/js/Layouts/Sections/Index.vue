<template>
    <div class="bg-white shadow-lg rounded-xl sm:rounded-2xl pb-10 border-gray-200" :class="{'max-w-2xl': mini}">

        <div v-if="($slots.title || $admin.title || $slots.buttons) && !hiddenTitle" class="px-6 md:px-10 pt-8 mb-8 md:flex">
            <div class="grid gap-4 mb-4 md:mb-0 self-center">
                <div class="font-semibold text-2xl">
                    <slot v-if="$slots.title" name="title"></slot>
                    <template v-else>{{ $admin.title }}</template>
                </div>
                <div v-if="$slots.subtitle" class="grid gap-1">
                    <slot name="subtitle"></slot>
                </div>
            </div>
            <div v-if="$slots.buttons" class="ml-auto md:pl-4 self-start flex flex-col">
                <slot name="buttons"></slot>
            </div>
        </div>

        <slot name="content"></slot>

    </div>
</template>

<script>

    export default {

        props: {
            hiddenTitle: Boolean,
            mini: Boolean,
        },
    }

</script>
