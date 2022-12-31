<template>
    <div class="form-grid">
        <MTitleSlug :form="translation" />

        <FLabel title="Цена" :error="translation.errors?.price">
            <FInput v-model="translation.price" type="number" step="0.01" />
        </FLabel>

        <FLabel title="Опубликовано?" :error="form.errors.is_published">
            <FSwitcher v-model="form.is_published" />
        </FLabel>

        <FLabel title="Фотографии" :error="form.errors.gallery">
            <FFileInput v-model="form.gallery" multiple imagesOnly/>
        </FLabel>

        <FLabel as="div" title="Категория" :error="form.errors.categories">
            <MCheckboxList v-model="form.categories" :list="categories" />
        </FLabel>
    </div>

</template>

<script>

    export default {

        props: ['form', 'translation'],

        data() {
            return {
                categories: this.$page.props.categories,
            }
        },

    }
</script>

