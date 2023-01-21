<template>

    <!-- Title -->
    <FLabel title="Название" :error="currentFormTitle.errors?.title">
        <FInput @change="setSlugFromTitle" v-model="currentFormTitle.title" />
    </FLabel>

    <!-- Slug -->
    <FLabel :title="slugName" :error="currentFormSlug.errors?.[slugKey]">
        <FInput :classes="'text-xs max-h-8 ' + (slug ? 'opacity-60' : '')" v-model="slug" />
    </FLabel>

</template>

<script>

    import slugify from 'slugify'

    export default {
        props: {
            formTitle: Object,
            formSlug: Object,
            form: Object,
            slugKey: {
                type: String,
                default: 'slug'
            },
            slugName: {
                type: String,
                default: 'Ярлык'
            },
        },

        emits: ['update:slug'],

        computed: {
            currentFormTitle() {
                return this.formTitle || this.form
            },
            currentFormSlug() {
                return this.formSlug || this.form
            },
            slug: {
                get() {
                    return this.currentFormSlug[this.slugKey];
                },
                set(val) {
                    let slugVal = slugify(val || '', {lower: true, strict: true})
                    this.currentFormSlug[this.slugKey] = slugVal;
				    this.$emit('update:slug', slugVal);
                }
            }
        },

        methods: {
            setSlugFromTitle() {
                if (!this.slug)
                    this.slug = this.currentFormTitle.title
            },
        },
    }
</script>
