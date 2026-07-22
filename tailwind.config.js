import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            colors: {
                brand: {
                    DEFAULT: '#5417D6',
                    light: '#EEF0FE',
                    dark: '#3B0FA0',
                },
                admin: {
                    DEFAULT: '#1E3A8A',
                    light: '#FEEDE6',
                    dark: '#1E306E',
                },
                accent: '#F5500A',
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [],
};
