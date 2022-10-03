<template>
	<auth-layout>

		<div class="mb-4 text-sm text-gray-600">
			Пожалуйста, подтвердите свой пароль, прежде чем продолжить.
		</div>

		<f-validation-errors class="mb-4" />

		<form @submit.prevent="submit">

			<f-label title="Пароль" classes="block">
				<f-input type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="current-password" autofocus />
			</f-label>

			<div class="flex justify-end mt-4">
				<f-button class="ml-4" :disabled="form.processing">
					Подтвердить
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

		data() {
			return {
				form: this.$inertia.form({
					password: '',
				})
			}
		},

		methods: {
			submit() {
				this.form.post(this.route('admin.password.confirm'), {
					onFinish: () => this.form.reset(),
				})
			}
		}
	}
</script>
