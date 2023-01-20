<template>
    <thead>
        <tr>
            <th
                :data-name="header.key"
                :title="header.title || header.text"
                :class="header.class"
                v-for="header in headers" :key="header.key">
                <Link
                    class="inline-flex items-center py-2"
                    v-if="header.sortable"
                    :href="urlWithSorting(header.key)">

                    <Icon v-if="header.fa" :icon="header.fa" class="opacity-60"/>
                    <span v-else v-text="header.text"></span>

                    <Icon
                        v-if="header.key == sort[0]"
                        class="ml-1 scale-90"
                        :icon="sort[1] == 'desc' ? 'angle-down' : 'angle-up'"
                        />
                </Link>
                <div v-else class="inline-block py-2">
                    <Icon v-if="header.fa" :icon="header.fa"/>
                    <span v-else-if="header.text" v-text="header.text"></span>
                </div>
            </th>
        </tr>
    </thead>
</template>

<script>
    export default {

        props: ['headers'],

        data() {
            return {
                orderSeparator: '-',
                sort: []
            };
        },

        created()
        {
            this.getOrderFromUrl();
        },

        methods: {

            getOrderFromUrl() {
                let url = new URL(location.href);

                let currentOrder = url.searchParams.get('sort');

                this.sort = currentOrder ? currentOrder.split(this.orderSeparator) : '';
            },

            urlWithSorting(key) {
                let url = new URL(location.href);

                let currentOrder = url.searchParams.get('sort');

                if ( currentOrder )
                {
                    let asc = currentOrder.split(this.orderSeparator).pop();
                    url.searchParams.set('sort', key + this.orderSeparator + (asc == 'asc' ? 'desc' : 'asc') );
                }
                else
                    url.searchParams.append('sort', key + this.orderSeparator + 'desc');
                return url.href;
            }
        },
    }
</script>
