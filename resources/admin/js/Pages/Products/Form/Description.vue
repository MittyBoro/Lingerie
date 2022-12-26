<template>
    <div class="form-grid">

        <FLabel title="Описание">
            <FTextarea v-model="translation.attributes.description" :mini="true"/>
        </FLabel>

        <FLabel title="Состав">
            <FTextarea v-model="translation.attributes.composition" :mini="true"/>
        </FLabel>

        <FLabel title="Уход">
            <FTextarea v-model="translation.attributes.care" :mini="true"/>
        </FLabel>

        <FLabel title="Таблица размеров" :error="form.errors.size_table">
            <FFileInput :isImage="true" v-model="form.size_table"/>
        </FLabel>

    </div>
</template>


<script>

    export default {
        props: ['form', 'translation'],
    }

</script>
