<template>
    <form @submit.prevent="submit" class="loading bg-white shadow-lg rounded-xl sm:rounded-2xl border-gray-200" :class="{'max-w-2xl': mini}">

        <div v-if="hasHeaderSlots" class="px-4 py-6 sm:px-8 md:flex md:items-center border-b border-gray-100">
            <div>
                <div class="font-bold text-xl">
                    <div class="flex items-center">
                        <slot v-if="$slots.title" name="title"></slot>
                        <template v-else>{{ $admin.title }}</template>
                        <component
                            v-if="showLink"
                            :is="internalLink ? 'Link' : 'a'"
                            :href="showLink"
                            target="_blank"
                            class="text-gray-500 hover-link ml-2 mt-0.5 text-sm"
                            >
                            <Icon icon="eye"/>
                        </component>
                    </div>
                </div>
                <div v-if="$slots.subtitle" class="mt-4 grid gap-1">
                    <slot name="subtitle"></slot>
                </div>
            </div>
            <div v-if="$slots.buttons || !hideAdder" class="ml-auto md:pl-4 self-start flex flex-col">
                <slot name="buttons"></slot>
                <Link v-if="form.id && !hideAdder" :href="currentRoute('create')" class="btn btn-gray ml-auto">Добавить ещё</Link>
            </div>
        </div>

        <div v-if="tabs" class="px-4 py-4 sm:px-8 border-b border-gray-100 flex flex-wrap">
            <div
                class="px-5 py-2 text-sm mr-3 my-2 rounded-md shadow-md shrink-0 transition tab"
                :class="{
                    'bg-primary-500 text-white': tab == activeTab,
                    'bg-gray-100 hover:bg-gray-200 cursor-pointer': tab != activeTab,
                }"
                @click="setTab(tab)"
                v-for="tab in tabs"
                :key="tab">
                {{ tab }}
            </div>
        </div>

        <div v-if="hasContentSlots" class="px-4 py-6 sm:px-8">
            <div v-if="$slots.content" class="form-grid">
                <slot name="content" :activeTab="activeTab"></slot>
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
            form: {
                type: Object,
                default: {},
            },
            tabs: Array,
            hideFix: Boolean,
            hideButtons: Boolean,
            hideAdder: Boolean,
            internalLink: Boolean,
            mini:  Boolean,
            hiddenTitle:  Boolean,
        },

        emits: ['update:activeTab'],

        data() {
            return {
                localName: route().current(),
                activeTab: null,
            }
        },

        computed: {
            hasContentSlots() {
                return this.$slots.content || this.$slots.simplecontent;
            },
            hasHeaderSlots() {
                return (this.$slots.title || this.$slots.subtitle ||
                            this.$slots.buttons || this.$admin.title) && !this.hiddenTitle;
            },

            showLink() {
                let showRoute = this.currentRouteStr('show');

                if (route().has(showRoute) && this.form.id)
                    return route(showRoute, this.form.id)
                return null;
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

                this.activeTab = tab;
            },
            setTab(tab) {
                localStorage.setItem(this.localName, tab);

                this.activeTab = tab;
            }
        }
    }
</script>


<style lang="sass">
    .tab
        max-width: 200px
        text-overflow: ellipsis
        overflow: hidden
        white-space: nowrap
</style>
