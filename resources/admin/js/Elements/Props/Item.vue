<template>

    <div class="py-4 even:bg-gray-50 bg-opacity-50 -mx-3 px-3 rounded-lg" >

        <div class="flex justify-between mb-2">
            <div>
                <span class="font-semibold">{{ item.title }}</span> <code class="text-xs text-gray-400">[{{ item.key }}]</code>
            </div>
            <div class="flex items-center text-sm text-gray-400">
                <Icon icon="arrows-up-down-left-right" class="mr-2 drag-handle"/>
                <Link :href="route('admin.props.edit', item.id)" class="cursor-pointer transition-colors hover:text-primary-600">
                    <Icon icon="gear" class="block"/>
                </Link>
            </div>
        </div>
        <div class="props-item">
            <template v-if="item.type == 'text'">
                <FTextarea v-model.lazy="form.admin_value" @update:modelValue="update" />
            </template>
            <template v-if="item.type == 'text_array'">
                <FTextarea v-model.lazy="form.admin_value" @update:modelValue="update" />
            </template>
            <template v-else-if="item.type == 'format_text'">
                <FTextareaEditor v-model.lazy="form.admin_value" @update:modelValue="update" :name="item.key" type="prop" :id="item.id" :allMedia="form.admin_media"  />
            </template>
            <template v-else-if="item.type == 'files'">
                <FFileInput multiple v-model="form.admin_value" @update:modelValue="update" />
            </template>
            <template v-else-if="item.type == 'file'">
                <FFileInput v-model="form.admin_value" @update:modelValue="update" />
            </template>
            <template v-else-if="item.type == 'boolean'">
                <FSwitcher v-model="form.admin_value" @update:modelValue="update" />
            </template>
            <template v-else>
                <FInput v-model.lazy="form.admin_value" @update:modelValue="update" />
            </template>
        </div>
    </div>

</template>


<script>

    export default {

        props: ['item'],

        data() {
            return {
                routePrefix: 'admin.props.',

                form: this.$inertia.form(this.item)
            }
        },

        methods: {
            update()
            {
                this.form
                    .transform((data) => ({
                        ...data,
                        value_edit : true,
                        _method : 'PUT',
                    }))
                    .post( this.currentRoute('update', this.item.id) , {
                        preserveScroll: true,
                    });
            },
        },
    }

</script>
