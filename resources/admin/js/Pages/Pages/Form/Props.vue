<template>
    <div class="col-span-6 grid grid-cols-6 gap-4">
        <FNotice class="col-span-6 xl:col-span-4">
            <Link class="link" :href="route('admin.props.create', {page_id: page_id} )">Добавить</Link> дополнительный параметр
        </FNotice>

        <props-list class="xl:col-span-4" :list="props" />
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

