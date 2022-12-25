<template>

    <!-- Title -->
    <FLabel title="Название" :error="form.errors.title">
        <FInput @change="stopSlugFromTitle" type="text" v-model="form.title" />
    </FLabel>

    <!-- Slug -->
    <FLabel title="Ярлык" :error="form.errors.slug">
        <FInput @change="stopSlugFromTitle" type="text" classes="text-xs max-h-9" v-model="form.slug" />
    </FLabel>

</template>

<script>

    import slugify from 'slugify'

    export default {
        props: ['form'],

        data() {
            return {
                allowEditSlug: !this.form.id,

                categories: this.$page.props.categories,
            }
        },

        watch: {
            'form.title'(val) {
                if (!this.isEdit && this.allowEditSlug)
                    this.form.slug = val
            },
            'form.slug'(val) {
                this.form.slug = slugify(val, {lower: true, strict: true});
            },
        },

        methods: {
            stopSlugFromTitle() {
                this.allowEditSlug = this.form.slug === '';
            },
        },
    }
</script>
