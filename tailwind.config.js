const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors')

const { inProduction } = require('laravel-mix');

module.exports = {
	content: [
		'./storage/framework/views/*.php',
		'./resources/admin/views/**/*.blade.php',
		'./resources/admin/js/**/*.{vue,js}',
	],

	theme: {
		colors: {
			cyan: colors.cyan,
			sky: colors.sky,

			transparent: 'transparent',
			current: 'currentColor',

			black: colors.black,
			white: colors.white,
			gray: colors.zinc,
			red: colors.red,
			orange: colors.orange,
			yellow: colors.yellow,
			green: colors.emerald,
			blue: colors.blue,
			indigo: colors.indigo,
			violet: colors.violet,
			purple: colors.purple,
			fuchsia: colors.fuchsia,
			pink: colors.pink,

            primary: colors.purple,
            secondary: colors.gray,
		},
		extend: {
			fontFamily: {
				sans: ['Nunito', ...defaultTheme.fontFamily.sans],
			},
		},
	},

	variants: {
		opacity: ['responsive', 'hover', 'focus', 'disabled'],
		extend: {
			backgroundColor: ['even'],
		}
	},

	plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
