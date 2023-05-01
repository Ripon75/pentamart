const defaultTheme = require('tailwindcss/defaultTheme');
const themeColors = require('tailwindcss/colors');

module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/tw-elements/dist/js/**/*.js"
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Roboto', ...defaultTheme.fontFamily.sans],
            },
            fontSize: {
                'xxs': '.70rem',
            },
            colors: {
                ...themeColors,
                primary: {
                    lightest: '#dde5fa',
                    lighter: '#aabff2',
                    light: '#567fe5',
                    DEFAULT: '#00798c',
                    dark: '#0c1f4d',
                    darker: '#081433',
                    darkest: '#081433'
                },
                secondary: {
                    lightest: '#fff5e7',
                    lighter: '#ffe6c2',
                    light: '#ffcd85',
                    DEFAULT: '#ffc42d',
                    dark: '#c77700',
                    darker: '#854f00',
                    darkest: '#422700',
                },
                primaryWarning: {
                    lightest: themeColors.amber[100],
                    lighter: themeColors.amber[200],
                    light: themeColors.amber[300],
                    DEFAULT: themeColors.amber[400],
                    dark: themeColors.amber[500],
                    darker: themeColors.amber[600],
                    darkest: themeColors.amber[700],
                },
                primaryPositive: {
                    lightest: themeColors.emerald[100],
                    lighter: themeColors.emerald[200],
                    light: themeColors.emerald[300],
                    DEFAULT: themeColors.emerald[400],
                    dark: themeColors.emerald[500],
                    darker: themeColors.emerald[600],
                    darkest: themeColors.emerald[700],
                },
                primaryError: {
                    lightest: themeColors.red[100],
                    lighter: themeColors.red[200],
                    light: themeColors.red[300],
                    DEFAULT: themeColors.red[400],
                    dark: themeColors.red[500],
                    darker: themeColors.red[600],
                    darkest: themeColors.red[700],
                },
                socials: {
                    facebook: "#4267B2",
                    google: "#DB4437"
                }
            },
            container: {
                padding: {
                    DEFAULT: '1rem',
                    sm: '1rem',
                    lg: '3rem',
                    xl: '5rem',
                    '2xl': '6rem'
                }
            }
        },
    },
    plugins: [
        require('@tailwindcss/aspect-ratio'),
        require('@tailwindcss/forms'),
        require('@tailwindcss/line-clamp'),
        require('tw-elements/dist/plugin')
    ],
}
