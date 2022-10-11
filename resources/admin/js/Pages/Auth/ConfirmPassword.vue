<template>
	<AuthLayout>

		<div class="mb-4 text-sm text-gray-600">
			Пожалуйста, подтвердите свой пароль, прежде чем продолжить.
		</div>

		<FValidationErrors class="mb-4" />

		<form @submit.prevent="submit">

			<FLabel title="Пароль" classes="block">
				<FInput type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="current-password" autofocus />
			</FLabel>

			<div class="flex justify-end mt-4">
				<FButton class="ml-4" :disabled="form.processing">
					Подтвердить
				</FButton>
			</div>
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
