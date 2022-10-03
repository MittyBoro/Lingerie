<template>
	<auth-layout>

		<f-validation-errors class="mb-4" />

		<div v-if="status" class="mb-4 font-semibold text-sm text-green-600">
			{{ status }}
		</div>

		<form @submit.prevent="submit">

			<f-label title="Email или логин" classes="block" >
				<f-input type="text" class="mt-1" v-model="form.login" required autofocus />
			</f-label>

			<f-label title="Пароль" classes="mt-4 block" >
				<f-input type="password" class="mt-1" v-model="form.password" required />
			</f-label>


			<div class="flex items-center mt-4">

				<f-label classes="flex items-center cursor-pointer mr-auto" >
					<f-checkbox name="remember" v-model="form.remember" />
					<span class="ml-2 text-sm text-gray-600">Запомнить меня</span>
				</f-label>

			</div>

			<f-button class="w-full mt-4" :disabled="form.processing">
				Вход
			</f-button>

			<!-- <a :href="route('oauth.vk')" class="btn-vk w-full mt-4">Вход через ВК</a> -->

			<div class="flex items-center mt-4">
				<Link :href="route('admin.register')" class="hover-link mr-4 text-sm">
					Регистрация
				</Link>
				<Link :href="route('admin.password.request')" class="hover-link ml-auto text-sm">
					Забыли пароль?
				</Link>
			</div>
		</form>
	</auth-layout>
</template>

<script>
	import AuthLayout from '@/Layouts/AuthLayout'
	export default {
		components: {
			AuthLayout,
		},

		props: {
			canResetPassword: Boolean,
			status: String
		},

		data() {
			return {
				form: this.$inertia.form({
					login: '',
					password: '',
					remember: true
				})
			}
		},

		methods: {
			submit() {
				this.form
					.transform(data => ({
						... data,
						remember: this.form.remember ? 'on' : ''
					}))
					.post(this.route('admin.login'))
			}
		}
	}
</script>
