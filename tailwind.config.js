import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                serif: ['Playfair Display', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                primary: {
                    DEFAULT: 'rgb(219, 28, 181)',
                    dark: 'rgb(180, 20, 145)',
                    light: 'rgb(252, 231, 243)',
                },
            },
        },
    },

    plugins: [forms],
};