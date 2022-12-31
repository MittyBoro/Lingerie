<template>
    <div class="form-grid lg:grid-cols-2">
        <FNotice class="col-span-full mb-4" v-text="'Выберите варианты, которые есть в наличии'" />

        <div v-for="attr in attributes" :key="attr.type">
            <FLabel as="div" :title="toRu(attr.type)" :error="form.errors.attributes">
                <MCheckboxList v-model="form.attributes" :list="attr.values" />
            </FLabel>

            <div class="btn-secondary btn-mini w-full mt-3" @click="setAll(attr.values, type)">Выбрать все</div>
        </div>
    </div>

</template>

<script>

    export default {

        props: ['form', 'translation'],

        data() {
            return {
                removeAll: {}
            }
        },

        computed: {
            attributes() {
                let attrs = []

                this.$page.props.attributes.forEach(el => {
                    let value = {
                        id: el.id,
                        title: el.value,
                    }
                    let typeIndex = attrs.findIndex(attr => attr.type == el.type);

                    if (typeIndex === -1) {
                        attrs.push({
                            type: el.type,
                            values: [value]
                        })
                    }
                    else {
                        attrs[typeIndex].values.push(value);
                    }
                })

                return attrs;
            }
        },

        methods: {
            toRu(text) {
                let words = {
                    color: 'Цвет',
                    size: 'Размер',
                }

                return words[text] || text;
            },

            setAll(values, type) {
                let ids = values.map(v => v.id);

                if (this.removeAll[type]) {
                    this.form.attributes = this.form.attributes.filter(item => !ids.includes(item));
                } else {
                    this.form.attributes.push(...ids)
                    this.form.attributes = [...new Set(this.form.attributes)]
                }

                this.removeAll[type] = !this.removeAll[type];
            }
        }

    }
</script>

