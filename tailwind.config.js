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
                'secondary-blue': '#4169E1',
                'strong-blue': '#1a252f',
                'soft-blue': 'rgba(59, 93, 130, 0.1)', /* 8% de opacidade */
                'primary-orange': '#C75B12',
                'secondary-orange': '#E07B3C',
                'danger-orange': '#B3470E',
                'text-gray': '#D1D5DB',
            }
        },
    },

    plugins: [forms, typography],
};
