<template>
    <div class="form-grid">

        <FLabel title="Описание" :error="translation.errors?.texts?.description">
            <FTextarea v-model="translation.texts.description" :mini="true"/>
        </FLabel>

        <FLabel title="Состав" :error="translation.errors?.texts?.composition">
            <FTextarea v-model="translation.texts.composition" :mini="true"/>
        </FLabel>

        <FLabel title="Уход" :error="translation.errors?.texts?.care">
            <FTextarea v-model="translation.texts.care" :mini="true"/>
        </FLabel>

        <FLabel title="Таблица размеров" :error="form.errors.size_table">
            <FFileInput :imagesOnly="true" v-model="form.size_table"/>
        </FLabel>

    </div>
</template>


<script>

    export default {
        props: ['form', 'translation'],
    }

</script>
