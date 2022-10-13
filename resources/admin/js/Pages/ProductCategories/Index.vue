<template>
    <AppLayout title="Категории" >
        <IndexSection class="max-w-3xl">

            <template #title>Категории</template>
            <template #buttons>
                <Link :href="route(routePrefix + 'create', {type: type})" class="btn">Добавить</Link>
            </template>

            <template #content>
                <div v-if="tree.length" class="table-wrapper loading text-sm">
                    <table-draggable class="border-t border-gray-500 border-opacity-20" :type="type" :list="tree" @showSaveBtn="showSaveBtn = true" />
                    <div v-if="showSaveBtn" class="table-save-row border-b">
                        <div @click="saveSort" class="btn w-full">Сохранить сортировку</div>
                    </div>
                </div>
                <TNotify class="border-t border-b" v-else>Данных ещё нет</TNotify>

            </template>

        </IndexSection>
    </AppLayout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import IndexSection from '@/Layouts/Sections/Index'
    import TableDraggable from './Index/TableDraggable'

    export default {
        components: {
            AppLayout, IndexSection, TableDraggable,
        },

        data() {
            let urlParams = new URLSearchParams(window.location.search);

            return {
                routePrefix: 'admin.categories.',

                type: urlParams.get('type'),

                showSaveBtn: false,
            }
        },

        computed: {
            tree() {
                return this.$page.props.tree;
            }
        },

        methods: {

            getFlatArray(array, parent_id = null) {
                let result = [];
                array.forEach((a, i) => {
                    result.push({
                        id: a.id,
                        parent_id: parent_id,
                        title: a.title,
                        position: i,
                    });
                    if (a.children && a.children.length) {
                        result = result.concat(this.getFlatArray(a.children, a.id));
                    }
                });
                return result;
            },

            saveSort() {

                let flatten = this.getFlatArray(this.tree);

                let form = this.$inertia.form({sorted: flatten});

                form.post( route(this.routePrefix + 'sort', {type: this.type}), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.showSaveBtn = false;
                    }
                });
            },
        },
    }
</script>
