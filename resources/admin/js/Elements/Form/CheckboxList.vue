<template>
    <div class="shadow-sm h-full rounded-md py-3 border max-h-96 overflow-auto">
        <div class="px-5 h-full overflow-auto">
            <label
                class="flex items-center my-1 cursor-pointer select-none"
                :style="{ marginLeft: (0.9 * item.depth) + 'em' }"
                v-for="item in list"
                :key="item.id"
                >
                <input type="checkbox"
                    class="form-checkbox"
                    v-model="values"
                    :value="item.id">
                <span class="pl-2 text" v-html="item.title"></span>
            </label>
        </div>
    </div>
</template>

<script>
    export default {
        emits: ['update:modelValue'],
        props: {
            modelValue: [Array, Number, String],
            list: Array,
            single: Boolean,
            type: {
                type: String,
                default: 'submit',
            },
        },
        data() {
            return {
            }
        },
        computed: {
            values: {
                get() {
                    let value = []

                    if (this.modelValue) {
                        if (Array.isArray(this.modelValue))
                            value = this.modelValue;
                        else
                            value = [this.modelValue]
                    }

                    return value.map(el => {
                        if (typeof el == 'object') {
                            el = el.id
                        }
                        return el;
                    });
                },
                set(value) {
                    this.$emit('update:modelValue', this.single ? value.slice(-1) : value);
                }
            },
        },

        created() {
            this.values = this.values
        },
    }
</script>
