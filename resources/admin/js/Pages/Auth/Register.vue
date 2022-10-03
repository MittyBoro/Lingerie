<template>
	<auth-layout>

		<f-validation-errors class="mb-4" />

		<form @submit.prevent="submit">

			<f-label title="Ваше имя" classes="block">
				<f-input type="text" v-model="form.name" required autofocus autocomplete="name" />
			</f-label>

			<f-label title="Логин" classes="block mt-4">
				<f-input type="text" v-model="form.login" required autocomplete="login" />
			</f-label>

			<f-label title="Email" classes="block mt-4">
				<f-input type="email" class="mt-1 block w-full" v-model="form.email" required />
			</f-label>

			<f-label title="Пароль" classes="block mt-4">
				<f-input type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />
			</f-label>

			<f-label title="Подтвердите пароль" classes="block mt-4">
				<f-input type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
			</f-label>

			<div class="flex items-center justify-between mt-4">
				<Link :href="route('admin.login')" class="hover-link text-sm">
					Уже зарегистрированы?
				</Link>

				<f-button class="ml-4" :disabled="form.processing">
					Регистрация
				</f-button>
			</div>

			<!-- <a :href="route('oauth.vk')" class="btn-vk w-full mt-4">Регистрация через ВК</a> -->
		</form>
	</auth-layout>
</template>

<script>
	import AuthLayout from '@/Layouts/AuthLayout'

	export default {
		components: {
			AuthLayout,
		},

		data() {
			return {
				form: this.$inertia.form({
					name: '',
					email: '',
					login: '',
					password: '',
					password_confirmation: '',
					terms: false,
				})
			}
		},

		methods: {
			submit() {
				this.form.post(this.route('admin.register'), {
					onFinish: () => this.form.reset('password', 'password_confirmation'),
				})
			}
		}
	}
</script>

<style lang="sass" scoped>
	label
		display: block
</style>
