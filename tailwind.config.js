import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            spacing: {
                'margin-mobile': '1rem',
                'margin-desktop': '5rem',
                'section-padding': '7.5rem',
            },
            colors: {
                primary: '#006491',
                'primary-container': '#009fe3',
                background: '#f6faff',
                'on-background': '#171c20',
                surface: '#f6faff',
                'surface-variant': '#dfe3e9',
                'surface-container-low': '#edf4fb',
                'surface-container-high': '#d7e6f2',
                'surface-container-lowest': '#ffffff',
                'on-surface': '#171c20',
                'on-surface-variant': '#3e4850',
                success: '#059669',
                error: '#ba1a1a',
                'outline-variant': '#c8d1dc',
                'glass-fill': 'rgba(255, 255, 255, 0.72)',
                'glass-border': 'rgba(255, 255, 255, 0.22)',
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                headline: ['Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
                display: ['Montserrat', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
