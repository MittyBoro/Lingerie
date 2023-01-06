<template>

    <FLabel as="div" :error="error" class="main-label">
        <template #title>
            <div class="flex justify-between mb-2">
                <div>
                    <span class="font-semibold" contenteditable @input="item.title = $event.currentTarget.textContent">{{ item.title }}</span>
                    <code class="text-xs text-gray-400">
                        [<span contenteditable @input="item.key = $event.currentTarget.textContent">{{ item.key }}</span>]
                    </code>
                </div>
                <div class="flex items-center text-sm text-gray-400 right-els transition">
                    <Icon icon="arrows-up-down-left-right" class="mr-2 drag-handle"/>
                    <Link :href="route('admin.props.edit', item.id)" class="cursor-pointer transition-colors hover:text-primary-600">
                        <Icon icon="gear" class="block"/>
                    </Link>
                </div>
            </div>
        </template>

        <template #default>
            <div class="props-item">
                <template v-if="item.type == 'text'">
                    <FTextarea v-model="value.text" />
                </template>
                <template v-if="item.type == 'text_array'">
                    <FTextArray v-model="value.text_array" />
                </template>
                <template v-else-if="item.type == 'format_text'">
                    <FTextareaEditor v-model="value.text" :name="item.key" />
                </template>
                <template v-else-if="item.type == 'files'">
                    <FFileInput v-model="value.files" multiple/>
                </template>
                <template v-else-if="item.type == 'file'">
                    <FFileInput v-model="value.files" />
                </template>
                <template v-else-if="item.type == 'images'">
                    <FFileInput v-model="value.images" multiple imagesOnly/>
                </template>
                <template v-else-if="item.type == 'image'">
                    <FFileInput v-model="value.images" imagesOnly/>
                </template>
                <template v-else-if="item.type == 'boolean'">
                    <FSwitcher v-model="value.string" />
                </template>
                <template v-else>
                    <FInput v-model="value.string" />
                </template>
            </div>
        </template>
    </FLabel>

</template>


<script>

    export default {

        props: ['item', 'modelValue', 'error'],
        emits: ['update:modelValue'],

        computed: {
            value: {
                get() {
                    return this.modelValue;
                },
                set(val) {
                    this.$emit("update:modelValue", val);
                },
            },
        },

    }

</script>


<style lang="sass">
    .main-label:not(:hover)
        .right-els
            opacity: .05
    [contenteditable]
        outline: 0
</style>
