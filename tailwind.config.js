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

            primary: {
                50: '#FAF6F5',
                100: '#EFE1DF',
                200: '#E4CCC9',
                300: '#D8B8B3',
                400: '#CDA39D',
                500: '#C28E87',
                600: '#9C7772',
                700: '#765E5B',
                800: '#534442',
                900: '#302A29',
            },
            secondary: {
                50: '#F6F6F0',
                100: '#E1E2CD',
                200: '#CCCDAA',
                300: '#B7B987',
                400: '#A2A464',
                500: '#8D9041',
                600: '#6F7239',
                700: '#545530',
                800: '#393A24',
                900: '#212117',
            },
            // secondary: colors.stone,
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
