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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                navy: {
                    50: '#f0f4f9',
                    100: '#dce6f1',
                    200: '#b9cce3',
                    300: '#8fabcf',
                    400: '#5c84b4',
                    500: '#3a6398',
                    600: '#2a4d7d',
                    700: '#1e3a5f',
                    800: '#162a47',
                    900: '#0f1f36',
                    950: '#0a1426',
                },
            },
        },
    },

    plugins: [forms],
};
