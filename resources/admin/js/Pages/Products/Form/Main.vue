<template>
    <div class="form-grid">
        <FTitleSlug :form="translation" />

        <div class="flex">
            <FLabel title="Цена" :error="translation.errors?.price" class="w-full">
                <FInput v-model="translation.price" type="number" step="0.01" />
            </FLabel>
            <FLabel title="Валюта" :error="translation.errors?.price_currency" class="ml-4 w-24">
                <FSelect v-model="translation.price_currency" :options="currencies" />
            </FLabel>
        </div>

        <FLabel title="Опубликовано?" :error="form.errors.is_published">
            <FSwitcher v-model="form.is_published" />
        </FLabel>

        <FLabel title="Фотографии" :error="form.errors.gallery">
            <FFileInput v-model="form.gallery" multiple imagesOnly/>
        </FLabel>

        <FLabel as="div" title="Категория" :error="form.errors.categories">
            <FCheckboxList v-model="form.categories" :list="categories" />
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

