<template>
    <div class="hamburger ml-4 flex items-center xl:hidden"
        @click="$emit('update:modelValue', !modelValue)">
        <button class="inline-flex items-center bg-gray-100 justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path :class="{'hidden': modelValue, 'inline-flex': ! modelValue }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path :class="{'hidden': ! modelValue, 'inline-flex': modelValue }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</template>

<script>
    export default {
        props: ['modelValue'],
        emits: ['update:modelValue'],
    }
</script>
