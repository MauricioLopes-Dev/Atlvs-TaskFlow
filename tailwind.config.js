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
                'atlvs-primary': '#1a1a1a', // Preto elegante
                'atlvs-secondary': '#333333', // Cinza escuro
                'atlvs-accent': '#007bff', // Azul da logo (ajustável conforme a logo real)
                'atlvs-gold': '#d4af37', // Ouro (se houver na logo)
            },
        },
    },

    plugins: [forms],
};
