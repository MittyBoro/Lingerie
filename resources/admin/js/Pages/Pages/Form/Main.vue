<template>

    <div class="form-grid">

        <!-- <FNotice>
            Укажите <code class="monfont-mono font-semibold">%replace%</code>, для замены на значение из дочернего элемента
        </FNotice> -->
        <FTitleSlug :form="form" />

        <FLabel as="div" title="Язык" :error="form.errors.lang">
            <FSelect :options="$page.props.langs" v-model="form.lang" required/>
            <div v-if="form.alt_langs" class="text-xs mt-2">
                <span>Другие языки:</span>
                <span v-for="alt in form.alt_langs" :key="alt.id" class="uppercase ml-1 link font-bold" >
                    <Link :href="route('admin.pages.edit', alt.id)">{{ alt.lang }}</Link>
                </span>
            </div>
        </FLabel>

        <FLabel title="Описание" :error="form.errors.description" as="div">
            <FTextareaEditor v-model="form.description" mini/>
        </FLabel>

        <FLabel title="Роутер" :error="form.errors.route">
            <FInput type="text" v-model="form.route" />
        </FLabel>

    </div>


</template>

<script>

    export default {

        props: ['form'],

    }
</script>

