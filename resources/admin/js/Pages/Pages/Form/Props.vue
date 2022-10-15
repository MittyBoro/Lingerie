<template>
    <div class="col-span-6 xl:col-span-4 grid gap-4">
        <FNotice>
            <Link class="link" :href="route('admin.props.create', {page_id: page_id} )">Добавить</Link> дополнительный параметр
        </FNotice>

        <PropsList :list="props" />
    </div>
</template>


<script>

    import PropsList from '@/Elements/Props/List'

    export default {

        components: {
            PropsList,
        },

        props: ['page_id'],

        data() {
            return {
            }
        },

        computed: {
            props() {
                return this.$page.props.props;
            }
        }

    }

</script>

