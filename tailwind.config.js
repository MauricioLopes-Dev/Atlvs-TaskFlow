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
                sans: ['Instrument Sans', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'atlvs-black': '#000000',
                'atlvs-dark': '#0a0a0a',
                'atlvs-cyan': '#06b6d4', // cyan-500
                'atlvs-cyan-light': '#22d3ee', // cyan-400
                'atlvs-border': 'rgba(255, 255, 255, 0.1)',
            },
        },
    },

    plugins: [forms],
};
