<template>
    <div class="form-grid">
        <MTitleSlug
            :form="translation"
            :errors="{}"
            />

        <FLabel title="Опубликовано?" :error="form.errors.is_published">
            <FSwitcher v-model="form.is_published" />
        </FLabel>

        <FLabel title="Фотографии" :error="form.errors.gallery">
            <FFileInput :isImage="true" v-model="form.gallery" multiple/>
        </FLabel>

        <FLabel as="div" title="Категория" :error="form.errors.categories">
            <!-- <MCheckboxList v-model="form.categories" :list="categories" /> -->
        </FLabel>
    </div>

</template>

<script>

    export default {

        props: ['form', 'translation'],

        data() {
            return {
                // categories: this.$page.props.categories,
            }
        },

    }
</script>

