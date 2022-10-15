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
                        v-if="header.key == orderBy[0]"
                        class="ml-1 scale-90"
                        :icon="orderBy[1] == 'desc' ? 'angle-down' : 'angle-up'"
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
                ordSeparator: ',',
                orderBy: []
            };
        },

        created()
        {
            this.getOrderFromUrl();
        },

        methods: {

            getOrderFromUrl() {
                let url = new URL(location.href);

                let currentOrder = url.searchParams.get('orderby');

                this.orderBy = currentOrder ? currentOrder.split(this.ordSeparator) : '';
            },

            urlWithSorting(key) {
                let url = new URL(location.href);

                let currentOrder = url.searchParams.get('orderby');

                if ( currentOrder )
                {
                    let asc = currentOrder.split(this.ordSeparator).pop();
                    url.searchParams.set('orderby', key + this.ordSeparator + (asc == 'asc' ? 'desc' : 'asc') );
                }
                else
                    url.searchParams.append('orderby', key + this.ordSeparator + 'desc');
                return url.href;
            }
        },
    }
</script>
