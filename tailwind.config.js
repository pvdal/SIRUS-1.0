import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './storage/app/public/**/*.html',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            screens: {
                'xs': '480px',  // novo breakpoint xs a partir de 480px
                'xxs': '330px', // breakpoint para 330px
            },
            colors: {
                'primary-blue': '#1E3A5F',
                'secondary-blue': '#3B5D82',
                'primary-orange': '#C75B12',
                'secondary-orange': '#E07B3C',
                'dark': '#1F2937',
                'light': '#B0B0B0',
            }
        },
    },

    plugins: [forms, typography],
};
