<template>
    <div class="mb-1" v-if="canShow(link.role_except)">
        <div
            v-if="link.sublinks"
            @click="opened = !opened"
            class="flex rounded-full lg:rounded-r-none transition items-center px-5 py-4 font-bold cursor-pointer"
            :class="activeClass">

            <Icon :icon="link.icon || 'circle-dot'" class="w-6 text-center mr-2" />
            <slot></slot>
        </div>
        <Link
            v-else
            :href="route(link.route, link.query)"
            class="flex rounded-full lg:rounded-r-none transition items-center px-5 py-4 font-bold cursor-pointer"
            :class="activeClass">

            <Icon :icon="link.icon || 'circle-dot'" class="w-6 text-center mr-2" />
            <slot></slot>
        </Link>


        <div class="sub-list ml-9 mt-2 mb-3"  v-if="link.sublinks" v-show="opened">
            <Link
                v-for="slink in link.sublinks"
                :key="slink.route"
                :href="route(slink.route, slink.query)"
                class="block px-5 py-2 rounded-full lg:rounded-r-none mb-0.5"
                :class="activeSubClass(slink)"
                v-show="canShow(slink.role_except)"
                >
                {{ slink.name }}
            </Link>
        </div>
    </div>
</template>

<script>

    export default {
        props: ['link'],

        data() {
            let urlParams = new URLSearchParams(window.location.search);


            return {
                activeRoute: route().current().split('.')[1],
                activeSubRoute: false,
                opened: false,
                urlParams: urlParams,
            };
        },

        computed:
        {
            activeClass() {
                if ( this.isActive(this.link) || this.activeSubRoute ) {
                    return 'active';
                }
                return 'hover:bg-opacity-20 hover:bg-white text-white';
            },
        },

        mounted() {
            // this.opened = this.activeSubRoute;
            this.opened = true;
        },

        methods: {
            isActive(link) {

                let isActive = true;

                Object.entries(link.query || {}).forEach(([key, val]) => {
                    if (this.urlParams.get(key) !== val)
                        isActive = false;
                });

                return link.route.split('.')[1] == this.activeRoute && isActive;
            },

            activeSubClass(link) {
                if (this.isActive(link)) {
                    this.activeSubRoute = true;
                    return 'bg-opacity-30 bg-white';
                }
                return 'hover:bg-opacity-10 hover:bg-white transition';
            },

            canShow(role_except) {
                if (!role_except)
                    return true;

                let role = this.$page.props.auth.user.role;
                let exceptsList = (typeof role_except === 'string') ? role_except.split(',') : role_except;

                return !exceptsList.includes(role);
            },
        }

    }
</script>

<style lang="sass" scoped>
    .active
        @apply relative text-gray-600 bg-gradient-to-r from-white to-gray-200
        &::before,
        &::after
            content: ''
            @apply w-6 h-6 absolute right-0 pointer-events-none bg-gray-200 hidden lg:block
            clip-path: url(#nav-clip)

        &::before
            @apply top-0 -mt-6
            transform: rotate(90deg)
        &::after
            @apply bottom-0 -mb-6


</style>
