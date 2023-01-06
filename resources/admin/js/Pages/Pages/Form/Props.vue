<template>
    <div class="form-grid">
        
        <MPropsList :errors="form.errorsObj?.props" :list="form.props" @update="form.props = $event" />
        
        <div class="flex">
            <a target="_blank" class="btn-secondary btn-mini ml-auto" :href="route('admin.props.create', {page_id: form.id} )">Добавить параметр</a>
        </div>
        
    </div>
</template>


<script>

    export default {

        props: ['form'],

        data() {
            return {
            }
        },


    }

</script>

