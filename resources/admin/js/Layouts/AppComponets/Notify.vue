<script>

	import { useToast } from "vue-toastification";
import route from "../../../../../vendor/tightenco/ziggy/src/js";

	export default {

		data() {
			return {
				toast: useToast(),
				showNotify: false,
			}
		},
		methods: {
			addNotiEvents() {
				if (window.isNotiInit)
					return;
				window.isNotiInit = true;

				this.$inertia.on('start', (event) => {
					this.showNotify = event.detail.visit.method != 'get';
				})

				this.$inertia.on('success', (event) => {

					if (!this.showNotify)
						return;

					this.notify('Сохранено', 'success')
				});

				this.$inertia.on('error', (err) => {

					if (!this.showNotify)
						return;

					let errors = Object.values(err.detail.errors);

					this.notifyErrorByResponse(errors);
				});
			},
			notify(text, type = 'info') {
				this.toast[type](text, {
					position: "top-right",
					timeout: 4500,
					closeOnClick: true,
					pauseOnFocusLoss: true,
					pauseOnHover: true,
					draggable: true,
					draggablePercent: 0.3,
					showCloseButtonOnHover: true,
					hideProgressBar: false,
					closeButton: "button",
					icon: true,
					maxToasts: 20,
					newestOnTop: true
				});
			},

			notifyErrorByResponse(errors) {
				if (typeof errors === 'object') {
					Object.values(errors).forEach(el => {
						this.notify(el, 'error');
					});
				} else if (typeof errors === 'string') {
					this.notify(errors, 'error');
				}
			}
		}
	}
</script>

<style lang="sass">

	#nprogress
		.bar
			height: 5px !important
			@apply ring-primary-500
			box-shadow: 0 0 10px var(--tw-ring-color)

	.loading
		&::before,
		&::after
			@apply transition
			pointer-events: none
			opacity: 0
		&::before
			@apply absolute -inset-x-3 -inset-y-1 bg-gray-100 bg-opacity-90 z-30 rounded
		&::after
			@apply absolute w-10 h-10 -mt-5 -ml-5 border-primary-500 border-4 rounded-full z-40
			top: 50%
			left: 50%
			border-left-color: transparent
			border-right-color: transparent
	.nprogress-busy
		.loading
			@apply relative pointer-events-none
			&::before
				content: ''
				opacity: 1
				@apply animate-pulse rounded
			&::after
				content: ''
				@apply animate-spin
				opacity: 1

	.Vue-Toastification__toast-body
		align-self: center
		font-size: 14px
		line-height: 1.35
	.Vue-Toastification__toast
		padding: 15px 20px
		max-width: 360px
		min-height: auto
	.Vue-Toastification__icon
		margin-right: 15px
	.Vue-Toastification__progress-bar
		bottom: -3px

</style>
