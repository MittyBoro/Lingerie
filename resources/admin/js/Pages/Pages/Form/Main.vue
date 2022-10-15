<template>

    <div class="col-span-6 xl:col-span-4 grid gap-4">

        <FNotice>
            Укажите <code class="monfont-mono font-semibold">%replace%</code>, для замены на значение из дочернего элемента
        </FNotice>

        <FLabel title="Название" :error="form.errors.title">
            <FInput @change="stopSlugFromTitle" type="text" v-model="form.title" required/>
        </FLabel>

        <FLabel title="Язык" :error="form.errors.lang">
            <FSelect :options="$page.props.langs" v-model="form.lang" required/>
        </FLabel>

        <FLabel title="Ярлык" :error="form.errors.slug">
            <FInput @change="stopSlugFromTitle" type="text" classes="opacity-60 text-xs max-h-9" v-model="form.slug" required/>
        </FLabel>

        <FLabel title="Описание" :error="form.errors.description" as="div">
            <FTextareaEditor v-model="form.description" />
        </FLabel>

        <FLabel title="Роутер" :error="form.errors.route">
            <FInput type="text" v-model="form.route" />
        </FLabel>

    </div>


</template>

<script>

    import slugify from 'slugify'

    export default {

        props: ['form', 'isEdit'],

        data() {
            return {
                editSlug: !this.isEdit,
            }
        },

        watch: {
            'form.title'(val) {
                if (!this.isEdit && this.editSlug)
                    this.form.slug = val
            },
            'form.slug'(val) {
                this.form.slug = slugify(val, {lower: true, strict: true});
            },
        },

        methods: {
            stopSlugFromTitle() {
                this.editSlug = this.form.slug === '';
            },
        },
    }
</script>

