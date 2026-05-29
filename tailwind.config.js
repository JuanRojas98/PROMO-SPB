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
                sans: ['Gotham Condensed', 'sans-serif'],
            },
            colors: {
                'primary': '#006E47',
                'secondary': '#003B23',
                'yellow': '#FFC107',
                'green-dark': '#124734'
            }
        },
    },

    plugins: [forms],
};
