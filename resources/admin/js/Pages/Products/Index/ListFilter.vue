<template>

    <div class="flex flex-wrap px-6 md:px-10 py-3">

        <label class="mr-8 my-2">
            <FSelect :options="categories" :keys="['id','title']" v-model.lazy="filter.category" @update:modelValue="setFilter" />
        </label>

        <label class="my-2">
            <FInput placeholder="Поиск…" @update:modelValue="setFilter" v-model.lazy="filter.q" />
        </label>
    </div>

</template>

<script>

    export default {

        data() {
            let urlParams = new URLSearchParams(location.search);
            let filter = {
                q: urlParams.get('q'),
                category: urlParams.get('category') || '',
            };

            // let categories = [ {id: '', title: 'Все категории'}, ...this.$page.props.categories]
            let categories = []

            return {
                categories: categories,
                filter: Object.assign({
                    q: '',
                    category: '',
                }, filter)
            }
        },

        methods: {
            setFilter() {
                setTimeout(() => {
                    let urlParams = new URLSearchParams(location.search);
                    let params = Object.fromEntries(urlParams);

                    let filter = Object.assign(params, this.filter);

                    this.$inertia.visit( route(route().current(), filter ), {
                        preserveState: true,
                        preserveScroll: true,
                    });
                }, 40);
            },
        },

    }
</script>

<style lang="sass" scoped>

    :deep(label)
        .text-sm
            @apply text-xs
        .form-input
            @apply max-h-7 pl-3 text-xs

</style>
