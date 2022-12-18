const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors')

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
            gray: colors.gray,
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

            primary: {
                900: '#1D100F',
                800: '#462723',
                700: '#703E38',
                600: '#99554C',
                500: '#c26c61',
                400: '#CD877D',
                300: '#D8A19A',
                200: '#E3BBB6',
                100: '#EED6D3',
                50: '#F9F0EF',
            },

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
