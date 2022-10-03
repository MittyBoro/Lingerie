<template>
	<div class="save-row fixed z-40 bg-primary-300 bg-opacity-60 p-2 shadow-lg" :style="style">
		<f-button class="btn" :disabled="disabled">
			<font-awesome-icon icon="floppy-disk" class="text-lg" />
		</f-button>
	</div>
</template>

<script>

	export default {

		props: ['disabled'],

		data()
		{
			return {
				style: {}
			}
		},

		mounted()
		{
			this.setStyle()

			document.addEventListener('scroll', this.setStyle);

			new ResizeObserver(entries => {
				this.setStyle()
			}).observe(document.body);
		},

		methods:
		{
			setStyle()
			{
				let contentLay = document.querySelector('.content-lay');

				if (!contentLay)
					return this.style = {};

				let layStyle = contentLay.getBoundingClientRect();

				let offset = window.pageYOffset || document.documentElement.scrollTop,
					windowHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;

				this.style = {
					left: ( layStyle.left + layStyle.width ) + 'px',
					// left:  + 'px',
				}

				if (windowHeight - offset > 140)
					this.style.marginBottom = 0;

			}
		}
	}
</script>

<style lang="sass" scoped>
	.save-row
		@apply rounded-full
		transition: .25s
		bottom: 10px
		margin-bottom: -80px
		transform: translateX(-100%)
	.btn
		@apply w-10 h-10 p-0 rounded-full
</style>
