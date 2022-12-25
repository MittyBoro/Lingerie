<template>
    <div class="form-grid">

        <FLabel title="Описание" :error="form.errors.attributes?.description">
            <FTextarea v-model="form.attributes.description" :mini="true"/>
        </FLabel>

        <FLabel title="Состав" :error="form.errors.attributes?.composition">
            <FTextarea v-model="form.attributes.composition" :mini="true"/>
        </FLabel>

        <FLabel title="Уход" :error="form.errors.attributes?.care">
            <FTextarea v-model="form.attributes.care" :mini="true"/>
        </FLabel>

        <FLabel title="Таблица размеров" :error="form.errors.size_table">
            <FFileInput :isImage="true" v-model="form.size_table"/>
        </FLabel>

    </div>
</template>


<script>

    export default {
        props: ['form'],
    }

</script>
