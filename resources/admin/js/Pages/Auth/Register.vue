<template>
	<AuthLayout>

		<FValidationErrors class="mb-4" />

		<form @submit.prevent="submit">

			<FLabel title="Ваше имя" classes="block">
				<FInput type="text" v-model="form.name" required autofocus autocomplete="name" />
			</FLabel>

			<FLabel title="Логин" classes="block mt-4">
				<FInput type="text" v-model="form.login" required autocomplete="login" />
			</FLabel>

			<FLabel title="Email" classes="block mt-4">
				<FInput type="email" class="mt-1 block w-full" v-model="form.email" required />
			</FLabel>

			<FLabel title="Пароль" classes="block mt-4">
				<FInput type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />
			</FLabel>

			<FLabel title="Подтвердите пароль" classes="block mt-4">
				<FInput type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
			</FLabel>

			<div class="flex items-center justify-between mt-4">
				<Link :href="route('admin.login')" class="hover-link text-sm">
					Уже зарегистрированы?
				</Link>

				<FButton class="ml-4" :disabled="form.processing">
					Регистрация
				</FButton>
			</div>

			<!-- <a :href="route('oauth.vk')" class="btn-vk w-full mt-4">Регистрация через ВК</a> -->
		</form>
	</AuthLayout>
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
