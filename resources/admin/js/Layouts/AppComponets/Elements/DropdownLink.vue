<template>
    <div class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out cursor-pointer" @click="$emit('click')">
        <Link v-if="href" :href="href" :method="method || 'get'"  >
            <slot></slot>
        </Link>
        <div v-else>
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['href', 'method']
    }
</script>
