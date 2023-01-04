<template>

    <!-- Title -->
    <FLabel title="Название" :error="form.errors?.title">
        <FInput @change="setSlugFromTitle" v-model="form.title" />
    </FLabel>

    <!-- Slug -->
    <FLabel :title="slugName" :error="form.errors?.[slugKey]">
        <FInput :classes="'text-xs max-h-8 ' + (slug ? 'opacity-60' : '')" v-model="slug" />
    </FLabel>

</template>

<script>

    import slugify from 'slugify'

    export default {
        props: {
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

        computed: {
            slug: {
                get() {
                    return this.form[this.slugKey];
                },
                set(val) {
                    this.form[this.slugKey] = slugify(val || '', {lower: true, strict: true});
                }
            }
        },

        methods: {
            setSlugFromTitle() {
                if (!this.slug)
                    this.slug = this.form.title
            },
        },
    }
</script>
