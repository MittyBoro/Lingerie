<template>
	<app-layout title="Редактирование пользователя" >

		<div class="grid grid-cols-6 gap-4 items-start">
			<form-section :submit="submit" :form="form" class="col-span-6 sm:col-span-3" hideFix  :showLink="route(routePrefix + 'show', form.id)" internalLink>
				<template #title>Пользовательские данные</template>

				<template #content>
					<div class="col-span-6 grid grid-cols-6 xl:grid-cols-4 gap-5">
						<template v-if="0">
							<f-label title="Аватар" :error="form.errors.admin_avatar">
								<f-file-input :isImage="true" v-model="form.admin_avatar" />
							</f-label>

							<!-- vk -->
							<div v-if="isCurrent" class="col-span-6">
								<a v-if="!form.vk_id"  :href="route('oauth.vk')" class="btn-vk w-full mt-4">Прикрепить ВК</a>
								<div class="inline-flex items-center bg-gray-50 rounded py-2 px-5" v-else>
									<a target="_blank" class="text-blue-600" :href="'https://vk.com/id' + form.vk_id">ВК аккаунт</a>
									<span class="flex items-center justify-center h-4 w-4 bg-red-500 text-white rounded cursor-pointer ml-3" @click="unpinVK">×</span>
								</div>
							</div>
						</template>

						<f-label title="Имя" :error="form.errors.name">
							<f-input type="text" v-model="form.name" />
						</f-label>

						<f-label title="Логин" :error="form.errors.username">
							<f-input type="text" v-model="form.username" />
						</f-label>

						<f-label title="Телефон" :error="form.errors.phone">
							<f-input type="text" v-model="phone" />
						</f-label>

						<f-label title="Email" :error="form.errors.email">
							<f-input type="email" v-model="form.email" />
						</f-label>

						<f-label title="Роль" :error="form.errors.role">
							<f-select :options="roles" v-model="form.role" />
						</f-label>
					</div>
				</template>
			</form-section>

			<form-section :submit="updatePass" :form="formP" class="col-span-6 sm:col-span-3" hideFix>
				<template #title>Пароль</template>

				<template #content>
					<div class="col-span-6 grid grid-cols-6 xl:grid-cols-4 gap-5">
						<f-label v-if="isCurrent" title="Текущий пароль" :error="formP.errors.current_password">
							<f-input type="password" v-model="formP.current_password" />
						</f-label>

						<f-label title="Новый пароль" :error="formP.errors.password">
							<f-input type="password" v-model="formP.password" />
						</f-label>

						<f-label title="Подтверждение пароля" :error="formP.errors.password_confirmation">
							<f-input type="password" v-model="formP.password_confirmation" />
						</f-label>
					</div>
				</template>
			</form-section>
		</div>

	</app-layout>
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
				routePrefix: 'admin.users.',

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
					.post(route(this.routePrefix + 'update', this.$page.props.item.id), {
						preserveScroll: true,
					});
			},

			unpinVK() {
				this.form.vk_id = null;
			},

			updatePass() {
				this.formP
					.put(route(this.routePrefix + 'update', this.$page.props.item.id), {
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

