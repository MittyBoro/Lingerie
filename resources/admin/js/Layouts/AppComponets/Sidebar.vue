<template>
	<div
		class="sidebar flex flex-col w-full lg:w-64 text-white shrink-0 px-3 -mt-3 mb-6
			lg:bg-none lg:m-0 lg:p-0 lg:pb-6"
		:class="sidebarMobile">
		<!-- Logo -->
		<div
			class="flex shrink-0 items-center h-16 lg:h-20 lg:pl-5 lg:mr-5 border-b border-white border-opacity-10">
			<Link
				class="flex items-center shrink-0 mr-auto"
				:href="route('admin.dashboard')">


				<font-awesome-icon icon="solar-panel" class="w-6 text-2xl -mb-1 mr-2 opacity-80" />

				<div class="hidden sm:block text-2xl pt-1 font-bold leading-none tracking-tight hover:text-gray-100 transition">
					The Admin<span class="text-white text-opacity-80 ml-0.5">ка</span>
				</div>
			</Link>

			<hamburger v-if="isMobile" v-model="showNav" />
		</div>

		<!-- Navigation Menu -->
		<nav class="my-4" v-show="sidebarMobile">
			<nav-link
				v-for="link in menu"
				:link="link"
				:key="link.route"
				>
				{{ link.name }}
			</nav-link>
		</nav>
		<svg class='h-0 w-0'>
			<clipPath id="nav-clip" clipPathUnits="objectBoundingBox"><path d="M1,1 c-0.001,-0.01,0,-0.02,-0.001,-0.032 c0,-0.004,0,-0.008,0,-0.012 c0,-0.005,0,-0.01,-0.001,-0.016 c-0.001,-0.007,-0.001,-0.014,-0.001,-0.021 c-0.001,-0.011,-0.002,-0.023,-0.003,-0.033 c-0.002,-0.014,-0.003,-0.028,-0.005,-0.041 c-0.004,-0.021,-0.008,-0.044,-0.012,-0.064 c-0.003,-0.015,-0.007,-0.029,-0.011,-0.043 c-0.004,-0.016,-0.009,-0.031,-0.014,-0.048 c-0.004,-0.014,-0.009,-0.027,-0.014,-0.04 c-0.005,-0.014,-0.011,-0.028,-0.017,-0.041 c-0.007,-0.017,-0.014,-0.031,-0.021,-0.046 c-0.004,-0.01,-0.01,-0.019,-0.014,-0.028 c-0.005,-0.01,-0.011,-0.02,-0.016,-0.029 c-0.007,-0.012,-0.014,-0.023,-0.02,-0.034 c-0.007,-0.011,-0.014,-0.022,-0.021,-0.032 c-0.009,-0.014,-0.018,-0.025,-0.027,-0.038 c-0.008,-0.011,-0.015,-0.02,-0.023,-0.03 a0.916,0.916,0,0,0,-0.028,-0.033 c-0.012,-0.013,-0.023,-0.026,-0.035,-0.038 c-0.009,-0.009,-0.018,-0.019,-0.027,-0.027 c-0.012,-0.011,-0.022,-0.021,-0.033,-0.03 c-0.013,-0.011,-0.026,-0.022,-0.038,-0.031 c-0.011,-0.009,-0.022,-0.018,-0.034,-0.025 c-0.012,-0.008,-0.024,-0.017,-0.036,-0.024 c-0.015,-0.009,-0.029,-0.019,-0.043,-0.027 c-0.016,-0.009,-0.033,-0.019,-0.048,-0.026 c-0.018,-0.009,-0.036,-0.018,-0.052,-0.025 c-0.016,-0.007,-0.031,-0.014,-0.046,-0.019 c-0.017,-0.006,-0.033,-0.012,-0.048,-0.017 c-0.023,-0.007,-0.047,-0.014,-0.067,-0.019 c-0.036,-0.009,-0.068,-0.014,-0.096,-0.019 c-0.027,-0.004,-0.052,-0.006,-0.07,-0.008 l-0.009,-0.001 c-0.006,-0.001,-0.014,-0.001,-0.018,-0.001 A0.443,0.443,0,0,0,0,0 h1"></path></clipPath>
		</svg>
	</div>

</template>

<script>
	import NavLink from './Elements/NavLink'
	import Hamburger from './Elements/Hamburger'

	export default {
		components: {
			NavLink,
			Hamburger,
		},

		data() {
			return {
				showNav: false,
				isMobile: false,
				menu: this.$page.props.config.menu,
			}
		},

		computed: {
			sidebarMobile()
			{
				if (!this.isMobile)
					return true;

				return this.showNav;
			},
		},

		created()
		{
			this.setIsMobile();
			window.addEventListener("resize", () => {
				this.setIsMobile();
			});
		},

		methods:
		{
			setIsMobile() {
				this.isMobile = window.screen.width < 1024;
			},
		}
	}
</script>
