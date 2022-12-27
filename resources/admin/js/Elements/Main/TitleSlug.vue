<template>

    <!-- Title -->
    <FLabel title="Название" :error="form.errors?.title">
        <FInput @change="setSlugFromTitle" v-model="form.title" />
    </FLabel>

    <!-- Slug -->
    <FLabel title="Ярлык" :error="form.errors?.slug">
        <FInput :classes="'text-xs max-h-8 ' + (form.slug ? 'opacity-60' : '')" v-model="form.slug" />
    </FLabel>

</template>

<script>

    import slugify from 'slugify'

    export default {
        props: ['form'],

        watch: {
            'form.slug'(val) {
                this.form.slug = slugify(val || '', {lower: true, strict: true});
            },
        },

        methods: {
            setSlugFromTitle() {
                if (!this.form.slug)
                    this.form.slug = this.form.title
            },
        },
    }
</script>
