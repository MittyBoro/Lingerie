<template>
	<auth-layout>

		<f-validation-errors class="mb-4" />

		<form @submit.prevent="submit">

			<f-label title="Email" classes="block">
				<f-input type="email" class="mt-1 block w-full" v-model="form.email" required autofocus />
			</f-label>

			<f-label title="Новый пароль" classes="block  mt-4">
				<f-input type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />
			</f-label>

			<f-label title="Подтверждение пароля" classes="block  mt-4">
				<f-input type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
			</f-label>

			<div class="flex items-center justify-between mt-4">
				<Link :href="route('admin.login')" class="underline text-sm text-gray-600 hover:text-gray-900">
					Вход
				</Link>

				<f-button :class="{ 'opacity-25': form.processing }" class="ml-4" :disabled="form.processing">
					Сброс пароля
				</f-button>
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
			email: String,
			token: String,
		},

		data() {
			return {
				form: this.$inertia.form({
					token: this.token,
					email: this.email,
					password: '',
					password_confirmation: '',
				})
			}
		},

		methods: {
			submit() {
				this.form.post(this.route('admin.password.update'), {
					onFinish: () => this.form.reset('password', 'password_confirmation'),
				})
			}
		}
	}
</script>
