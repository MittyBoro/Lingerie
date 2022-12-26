<template>
    <div class="form-grid">
        <FLabel title="Meta title" :error="form?.errors?.meta_title">
            <FInput type="text" v-model="form.meta_title" />
        </FLabel>

        <FLabel title="Meta keywords" :error="form?.errors?.meta_keywords">
            <FInput type="text" v-model="form.meta_keywords" />
        </FLabel>

        <FLabel title="Meta description" :error="form?.errors?.meta_description">
            <FTextarea rows="3" v-model="form.meta_description" />
        </FLabel>
    </div>
</template>


<script>

    export default {

        props: ['form'],

    }

</script>

