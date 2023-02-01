<template>
    <AppLayout title="Редактировать">

        <div class="grid grid-cols-6 gap-4 items-start">
            <FormSection :submit="submit" :form="form" class="col-span-6 sm:col-span-3" hideFix hideAdder>
                <template #title>Пользовательские данные</template>

                <template #content>
                    <div class="col-span-full grid gap-4">
                        <template v-if="0">
                            <FLabel title="Аватар" :error="form.errors.admin_avatar">
                                <FFileInput :imagesOnly="true" v-model="form.admin_avatar" />
                            </FLabel>
                        </template>

                        <FLabel title="Имя" :error="form.errors.name">
                            <FInput type="text" v-model="form.name" />
                        </FLabel>

                        <FLabel title="Логин" :error="form.errors.username">
                            <FInput type="text" v-model="form.username" />
                        </FLabel>

                        <FLabel title="Телефон" :error="form.errors.phone">
                            <FInput type="text" v-model="phone" />
                        </FLabel>

                        <FLabel title="Email" :error="form.errors.email">
                            <FInput type="email" v-model="form.email" />
                        </FLabel>

                        <FLabel title="Роль" :error="form.errors.role">
                            <FSelect :options="roles" v-model="form.role" />
                        </FLabel>
                    </div>
                </template>
            </FormSection>

            <FormSection :submit="updatePass" :form="formP" class="col-span-6 sm:col-span-3" hideFix>
                <template #title>Пароль</template>

                <template #content>
                    <div class="col-span-full grid gap-4">
                        <FLabel v-if="isCurrent" title="Текущий пароль" :error="formP.errors.current_password">
                            <FInput type="password" v-model="formP.current_password" />
                        </FLabel>

                        <FLabel title="Новый пароль" :error="formP.errors.password">
                            <FInput type="password" v-model="formP.password" />
                        </FLabel>

                        <FLabel title="Подтверждение пароля" :error="formP.errors.password_confirmation">
                            <FInput type="password" v-model="formP.password_confirmation" />
                        </FLabel>
                    </div>
                </template>
            </FormSection>
        </div>

    </AppLayout>
</template>

<script>

    import AppLayout from '@/Layouts/AppLayout'
    import FormSection from '@/Layouts/Sections/Form'

    import {parsePhoneNumberFromString} from 'libphonenumber-js';

    export default {
        components: {
            AppLayout,
            FormSection,
        },


        data() {
            return {
                form: this.$inertia.form(this.$page.props.item),
                formP: this.$inertia.form({
                    current_password: '',
                    password: '',
                    password_confirmation: '',
                }),

                roles: this.$page.props.roles,

                isEdit: !!this.$page.props.item,
                isCurrent: this.$page.props.item.id == this.$page.props.auth.user.id,
            }
        },

        computed: {
            phone: {
                get() {
                    return this.form.phone;
                },
                set(val) {
                    let phone = parsePhoneNumberFromString(val, 'RU');
                    if (phone)
                        this.form.phone = phone.formatInternational();
                }
            }
        },

        methods: {
            submit() {
                this.update()
            },

            update() {
                this.form
                    .transform((data) => ({
                        ...data,
                        _method : 'PUT',
                    }))
                    .post(this.currentRoute('update', this.$page.props.item.id), {
                        preserveScroll: true,
                    });
            },

            unpinVK() {
                this.form.vk_id = null;
            },

            updatePass() {
                this.formP
                    .put(this.currentRoute('update', this.$page.props.item.id), {
                        preserveScroll: true,
                        onSuccess: () => {
                            this.formP.reset('current_password');
                            this.formP.reset('password');
                            this.formP.reset('password_confirmation');
                        },
                    });
            },
        },
    }
</script>

