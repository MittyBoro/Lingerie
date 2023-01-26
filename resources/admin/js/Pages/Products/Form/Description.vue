<template>
    <div class="form-grid">

        <FLabel title="Описание" :error="translation.errors?.details?.description">
            <FTextarea v-model="translation.details.description" :mini="true"/>
        </FLabel>

        <FLabel title="Состав" :error="translation.errors?.details?.composition">
            <FTextarea v-model="translation.details.composition" :mini="true"/>
        </FLabel>

        <FLabel title="Уход" :error="translation.errors?.details?.care">
            <FTextarea v-model="translation.details.care" :mini="true"/>
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
