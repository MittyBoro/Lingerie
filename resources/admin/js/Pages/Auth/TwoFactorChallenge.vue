<template>
	<auth-layout>

		<div class="mb-4 text-sm text-gray-600">
			<template v-if="! recovery">
				Please confirm access to your account by entering the authentication code provided by your authenticator application.
			</template>

			<template v-else>
				Please confirm access to your account by entering one of your emergency recovery codes.
			</template>
		</div>

		<f-validation-errors class="mb-4" />

		<form @submit.prevent="submit">


			<f-label v-if="!recovery" title="Code" classes="block">
				<f-input ref="code" type="text" inputmode="numeric" class="mt-1 block w-full" v-model="form.code" autofocus autocomplete="one-time-code" />
			</f-label>


			<f-label v-else title="Recovery Code" classes="block mt-4">
				<f-input ref="recovery_code" type="text" class="mt-1 block w-full" v-model="form.recovery_code" autocomplete="one-time-code" />
			</f-label>

			<div class="flex items-center justify-end mt-4">
				<button type="button" class="text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer" @click.prevent="toggleRecovery">
					<template v-if="! recovery">
						Use a recovery code
					</template>

					<template v-else>
						Use an authentication code
					</template>
				</button>

				<f-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
					Log in
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
				recovery: false,
				form: this.$inertia.form({
					code: '',
					recovery_code: '',
				})
			}
		},

		methods: {
			toggleRecovery() {
				this.recovery ^= true

				this.$nextTick(() => {
					if (this.recovery) {
						this.$refs.recovery_code.focus()
						this.form.code = '';
					} else {
						this.$refs.code.focus()
						this.form.recovery_code = ''
					}
				})
			},

			submit() {
				this.form.post(this.route('admin.two-factor.login'))
			}
		}
	}
</script>
