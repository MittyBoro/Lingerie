<template>
    <div v-if="isDev" v-html="iconHTML"></div>
    <svg v-else>
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
                default: 'solid'
            },
        },
        //
        data() {
            return {
                iconUrl: '',
                iconHTML: '',

                isDev: import.meta.env.MODE === 'development'
            }
        },

        created() {
            if (this.isDev)
                this.setIconHTML()
            else
                this.iconUrl = this.getIconUrl()
        },

        methods: {
           getIconUrl() {
                let url = new URL(`../../images/sprites/${this.type}.svg`, import.meta.url).href
                let iconUrl = `${url}#${this.icon}`
                return iconUrl
            },

            setIconHTML() {
                fetch(this.getIconUrl())
                    .then(r => r.text())
                    .then(str => {

                        this.iconHTML = this.getBase64ByStr(str);
                    })
                    .catch(console.error.bind(console));
            },

            getBase64ByStr(str) {
                let el = document.createElement('div')
                    el.innerHTML = str

                let symbol = el.querySelector(`#${this.icon}`)

                let svg = document.createElement('svg')
                    svg.innerHTML = symbol.innerHTML
                    svg.setAttribute('viewBox', symbol.getAttribute('viewBox'))

                return svg.outerHTML;
            },
        }
    }
</script>


<style lang="sass">
    svg
        fill: currentColor
        height: 1em
        width: 1em
        vertical-align: -0.125em
        overflow: visible
</style>
