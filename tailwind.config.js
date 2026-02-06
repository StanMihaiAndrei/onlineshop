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
                sans: ['Comic Relief', 'Comic Sans MS', 'cursive', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Noua paletă de culori
                background: '#f6f1eb',
                text: '#3a3a3a',
                secondary: '#8fae9e',
                primary: {
                    DEFAULT: '#db1cb5',
                    dark: '#b01691',
                    light: '#f0d5ea',
                },
            },
        },
    },

    plugins: [forms],
};