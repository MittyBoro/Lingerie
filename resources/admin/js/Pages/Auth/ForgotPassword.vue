<template>
	<auth-layout>

		<div class="mb-4 text-sm text-gray-600">
			Забыли пароль? Нет проблем. Просто сообщите Ваш email-адрес и мы пришлём Вам ссылку для сброса пароля.
		</div>

		<div v-if="status" class="mb-4 font-semibold text-sm text-green-600">
			{{ status }}
		</div>

		<f-validation-errors class="mb-4" />

		<form @submit.prevent="submit">
			<f-label title="Email" classes="block">
				<f-input type="email" class="mt-1 block w-full" v-model="form.email" required autofocus />
			</f-label>

			<div class="flex items-center justify-end mt-4">
				<f-button :disabled="form.processing">
					Cброс пароля
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
			status: String
		},

		data() {
			return {
				form: this.$inertia.form({
					email: ''
				})
			}
		},

		methods: {
			submit() {
				this.form.post(this.route('admin.password.email'))
			}
		}
	}
</script>
