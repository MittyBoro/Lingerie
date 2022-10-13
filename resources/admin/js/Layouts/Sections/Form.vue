<template>
    <form @submit.prevent="submit" class="bg-white shadow-lg rounded-xl sm:rounded-2xl border-gray-200">

        <div v-if="hasHeaderSlots" class="px-4 py-6 sm:px-8 md:flex md:items-center border-b border-gray-100">
            <div>
                <div class="font-bold text-xl">
                    <div class="flex items-center">
                        <slot v-if="$slots.title" name="title"></slot>
                        <template v-else>{{ $admin.title }}</template>
                        <component
                            v-if="showLink && form.id"
                            :is="internalLink ? 'Link' : 'a'"
                            :href="showLink"
                            target="_blank"
                            class="text-gray-500 hover-link ml-2 mt-0.5 text-sm"
                            >
                            <font-awesome-icon icon="eye"/>
                        </component>
                    </div>
                </div>
                <div v-if="$slots.subtitle" class="mt-4 grid gap-1">
                    <slot name="subtitle"></slot>
                </div>
            </div>
            <div v-if="$slots.buttons" class="ml-auto md:pl-4 self-start flex flex-col">
                <slot name="buttons"></slot>
            </div>
        </div>

        <div v-if="tabs" class="px-4 py-4 sm:px-8 border-b border-gray-100 flex flex-wrap">
            <div
                class="px-5 py-2 text-sm mr-3 my-2 bg-gray-100 rounded-md shadow-lg shrink-0 transition"
                :class="{
                    'bg-primary-500 text-white': tab == activeTab,
                    'hover:bg-gray-200 cursor-pointer': tab != activeTab,
                }"
                @click="setTab(tab)"
                v-for="tab in tabs"
                :key="tab">
                {{ tab }}
            </div>
        </div>

        <div v-if="hasContentSlots" class="px-4 py-6 sm:px-8">
            <div v-if="$slots.content" class="grid grid-cols-6 gap-4">
                <slot name="content"></slot>
            </div>
            <slot v-if="$slots.simplecontent" name="simplecontent"></slot>
        </div>

        <template v-if="!hideButtons">
            <div v-if="form" class="flex items-center rounded-b-md sm:rounded-b-xl justify-end bg-gray-50 text-right px-4 py-4 sm:px-8"
                :class="{'rounded-md sm:rounded-xl': !hasContentSlots }">
                <FButton class="w-full text-xs" :disabled="form.processing">
                    Сохранить
                </FButton>
                <slot v-if="$slots.actions" name="actions"></slot>
            </div>

            <FButtonFixed v-if="form && !hideFix" :disabled="form.processing" />
        </template>
    </form>

</template>

<script>

    export default {

        props: {
            submit: Function,
            form: Object,
            tabs: Array,
            activeTab: String,
            hideFix: Boolean,
            hideButtons: Boolean,
            showLink: null,
            internalLink: Boolean,
            showTitle: {
                type: Boolean,
                default: true,
            },
        },

        emits: ['update:activeTab'],

        data() {
            return {
                localName: route().current(),
            }
        },

        computed: {
            hasContentSlots() {
                return this.$slots.content || this.$slots.simplecontent;
            },
            hasHeaderSlots() {
                return this.$slots.title || this.$slots.subtitle ||
                            this.$slots.buttons || this.showTitle;
            }
        },

        created() {
            this.setActiveTab();
        },

        methods: {
            setActiveTab() {
                if (!this.tabs || !this.tabs.length)
                    return;

                let tab;
                let localActiveTab = localStorage.getItem(this.localName);

                if ( this.tabs.includes(localActiveTab) )
                    tab = localActiveTab
                else
                    tab = this.tabs[0]

                this.$emit('update:activeTab', tab);
            },
            setTab(tab) {
                localStorage.setItem(this.localName, tab);

                this.$emit('update:activeTab', tab);
            }
        }
    }
</script>
