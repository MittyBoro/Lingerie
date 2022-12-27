<template>
    <div class="form-grid">

        <FLabel title="Описание" :error="translation.errors?.attributes?.description">
            <FTextarea v-model="translation.attributes.description" :mini="true"/>
        </FLabel>

        <FLabel title="Состав" :error="translation.errors?.attributes?.composition">
            <FTextarea v-model="translation.attributes.composition" :mini="true"/>
        </FLabel>

        <FLabel title="Уход" :error="translation.errors?.attributes?.care">
            <FTextarea v-model="translation.attributes.care" :mini="true"/>
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
