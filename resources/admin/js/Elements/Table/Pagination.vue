<template>
    <div class="px-6 md:px-10 py-5 flex-col xl:flex-row flex-1 flex items-center justify-between">
        <div v-if="pages">
            <p class="text-sm text-center xl:text-left text-gray-700 mb-3 xl:mb-0">
                Показано с
                <span class="font-semibold">{{ pages.from }}</span>
                по
                <span class="font-semibold">{{ pages.to }}</span>
                из
                <span class="font-semibold mr-8">{{ pages.total }}</span>

                <span class="perpage">
                    <span>На странице:</span>
                    <FInput type="number" @update:modelValue="setPerPage" v-model.lazy="pages.per_page" min="1" />
                </span>
            </p>
        </div>
        <slot></slot>
        <nav v-if="pages && pages.per_page < pages.total" class="relative flex justify-center flex-wrap -space-x-px ml-5">
            <Link
                :href="link.url || '#'"
                v-for="(link, key) in pages.links"
                :key="key"
                class="pagination-item"
                :class="{active: link.label == pages.current_page}">

                <span class="font-semibold" v-if="key == 0">«</span>
                <span class="font-semibold" v-else-if="key == pages.links.length - 1">»</span>
                <span v-else>{{ link.label }}</span>
            </Link>
        </nav>
    </div>
</template>

<script>

    export default {

        props: ['pages'],

        methods: {
            setPerPage(val) {
                this.pages.per_page = val;

                let url = new URL(location.href),
                    currPerPage = url.searchParams.get('perPage');

                if (currPerPage != this.pages.per_page) {
                    currPerPage ?
                        url.searchParams.set('perPage', this.pages.per_page) :
                        url.searchParams.append('perPage', this.pages.per_page)

                    this.$inertia.visit(url.href, {
                        preserveState: true,
                        preserveScroll: true,
                    });
                }
            },
            showAll() {
                if (this.pages.last_page < 2)
                    return;

                let url = new URL(location.href)

                url.searchParams.set('perPage', this.pages.total);
                url.searchParams.delete('page');

                this.$inertia.visit(url.href, {
                    preserveState: true,
                    preserveScroll: true,
                });
            },
            showDefault() {

                let url = new URL(location.href)

                url.searchParams.delete('perPage');
                url.searchParams.delete('page');

                this.$inertia.visit(url.href, {
                    preserveState: true,
                    preserveScroll: true,
                });
            }
        }
    }
</script>

<style lang="sass" scoped>
    .perpage
        @apply inline-flex items-center
    :deep(.perpage)
        input
            @apply leading-4 text-center ml-2 px-1 w-12 h-7 text-xs rounded appearance-none
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button
            -webkit-appearance: none
            margin: 0
        input[type=number]
            -moz-appearance: textfield

    nav
        @apply rounded-lg
        a:first-child
            @apply rounded-l-lg
        a:last-child
            @apply rounded-r-lg
        a.active,
        a.active:hover
            @apply bg-primary-500 text-white

    .pagination-item
        @apply flex items-center relative px-3 py-1 border border-gray-200 bg-white text-sm font-semibold text-gray-700 transition cursor-pointer
        &:hover
            @apply bg-gray-100

</style>
