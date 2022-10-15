<template>
    <svg class="icon">
        <use :xlink:href="iconUrl" />
    </svg>
</template>

<script>
    export default {
        props: {
            icon: {
                type: String,
                required: true,
            },
            type: {
                type: String,
            },
        },

        data() {
            return {
                iconUrl: `/assets/admin/images/sprites/${this.type || 'solid'}.svg#${this.icon}`,
            }
        },
    }
</script>


<style lang="sass">
    svg
        fill: currentColor
        display: inline-block
        height: 1em
        width: 1em
        vertical-align: -0.125em
        overflow: visible
</style>
