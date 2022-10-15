<template>
    <AppLayout title="Настройки" >

        <FormSection :submit="submit" :form="form">
            <template #title>
                <div v-if="!isEdit">Добавить параметр</div>
                <div v-else>Редактировать параметр</div>
            </template>

            <template v-if="isEdit" #buttons>
                <Link :href="route(routePrefix + 'create')" class="btn">Добавить ещё</Link>
            </template>

            <template #content>

                <FLabel title="Название" :error="form.errors.title">
                    <FInput @change="stopKeyFromTitle" v-model="form.title" />
                </FLabel>

                <FLabel title="Ключ" :error="form.errors.key">
                    <FInput @change="stopKeyFromTitle" classes="opacity-60" v-model="form.key" mini />
                </FLabel>

                <FLabel title="Тип" :error="form.errors.type">
                    <FSelect :options="types" v-model="form.type" />
                </FLabel>

                <FLabel v-if="!page_id" title="Имя вкладки (только в панели)" :error="form.errors.tab">
                    <FInput v-model="form.tab" :options="tabs" />
                </FLabel>

                <!-- можно дополнять -->
                <FLabel title="Прикрепить к странице" :error="form.errors.model_id">
                    <FSelect :options="pages" :keys="['id','title']" v-model="page_id" />
                    <Link v-if="page_id" :href="route('admin.pages.edit', page_id)" class="link mt-2">
                        <Icon icon="pencil" class="mr-1" />
                        <span>Редактировать страницу</span>
                    </Link>
                </FLabel>

            </template>

            <template v-if="isEdit" #actions>
                <Link @click.prevent :href="route(routePrefix + 'destroy', form.id)" method="delete" as="button" class="ml-3">
                    <div @click="confirm" class="btn-danger btn-square block">
                        <Icon icon="trash-can"/>
                    </div>
                </Link>
            </template>

        </FormSection>
    </AppLayout>
</template>

<script>
    import slugify from 'slugify'

    import AppLayout from '@/Layouts/AppLayout'
    import FormSection from '@/Layouts/Sections/Form'


    export default {
        components: {
            AppLayout,
            FormSection,
        },


        data() {

            let hasItem = !!this.$page.props.item

            let page_id = route().params.page_id;

            return {
                routePrefix: 'admin.props.',

                form: this.$inertia.form(this.$page.props.item || {
                    title: null,
                    key: null,
                    type: 'string',
                    tab: null,
                    model_id: page_id,
                    model_type: page_id ? 'pages' : null,
                }),

                isEdit: hasItem,
                editSlug: !hasItem,

                types: this.$page.props.types,
                tabs: this.$page.props.tabs,
            }
        },

        watch: {
            'form.title'(val) {
                if (!this.isEdit && this.editSlug)
                this.form.key = val
            },
            'form.key'(val) {
                this.form.key = slugify(val, {lower: true, strict: true, replacement: '_'});
            },
        },

        computed: {
            pages() {
                let list = [...this.$page.props.pages].map(el => {
                    el.title = `[${el.slug}] ${el.title}`
                    return el
                });

                list.unshift({ id: null, title: '---' });
                return list;
            },

            page_id: {
                get() {
                    return this.form.model_id;
                },
                set(val) {
                    if (val) {
                        this.form.model_id = val
                        this.form.model_type = 'pages'
                    } else {
                        this.form.model_id = null
                        this.form.model_type = null
                    }
                }
            },
        },

        methods: {
            stopKeyFromTitle() {
                this.editSlug = this.form.key === '';
            },

            submit() {
                this.isEdit ?
                            this.update() :
                            this.store()
            },

            store() {
                this.form
                    .transform((data) => ({
                        ...data,
                    }))
                    .post(route(this.routePrefix + 'store'), {
                        preserveState: (page) => Object.keys(page.props.errors).length,
                    });
            },

            update() {

                this.form
                    .transform((data) => ({
                        ...data,
                        _method : 'PUT',
                    }))
                    .post(route(this.routePrefix + 'update', this.form.id), {
                        preserveState: (page) => Object.keys(page.props.errors).length,
                        preserveScroll: true,
                    });
            },
        },
    }
</script>

