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
                display: ['Inter', ...defaultTheme.fontFamily.sans], // Switched from Serif to bold Grotesque (Inter)
                mono: ['"JetBrains Mono"', ...defaultTheme.fontFamily.mono],
            },
            colors: {
                brand: {
                    DEFAULT: '#E0A92A',
                    50: '#FDF7E7',
                    100: '#FBEEC0',
                    200: '#F8DF8F',
                    300: '#F5CD57',
                    400: '#EFB020',
                    500: '#E0A92A',
                    600: '#c98606',
                    700: '#825003',
                    800: '#643C02',
                    900: '#4D2C02',
                },
                charcoal: {
                    DEFAULT: '#32373c',
                    50: '#F5F6F6',
                    100: '#EBECEC',
                    200: '#CED1D1',
                    300: '#B1B5B6',
                    400: '#777C7E',
                    500: '#32373c',
                    600: '#2D3236',
                    700: '#222629',
                    800: '#17191B',
                    900: '#0C0D0E',
                },
                gold: {
                    50: '#FFF9E6',
                    100: '#FFF0B3',
                    200: '#FFE680',
                    300: '#FFDB4D',
                    400: '#FFD11A',
                    500: '#FFC30B',
                    600: '#D9A700',
                    700: '#B38600',
                    800: '#8C6500',
                    900: '#654400',
                },
                richblack: {
                    DEFAULT: '#0A0A0A',
                    800: '#141414',
                    900: '#0E0E0E',
                    950: '#0A0A0A',
                },
                lightgray: {
                    DEFAULT: '#F4F4F4',
                    50: '#FCFCFC',
                    100: '#F4F4F4',
                    200: '#EBEBEB',
                    300: '#D6D6D6',
                },
            },
            typography: {
                DEFAULT: {
                    css: {
                        maxWidth: 'none',
                        color: '#4A4A4A',
                        h1: { color: '#0A0A0A', fontWeight: '800' },
                        h2: { color: '#0A0A0A', fontWeight: '700' },
                        h3: { color: '#1A1A1A', fontWeight: '600' },
                        h4: { color: '#1A1A1A', fontWeight: '600' },
                        strong: { color: '#0A0A0A', fontWeight: '700' },
                        a: { color: '#E0A92A', textDecoration: 'none', fontWeight: '600' },
                        'a:hover': { color: '#c98606' },
                    },
                },
            },
            spacing: {
                '18': '4.5rem',
                '22': '5.5rem',
                '26': '6.5rem',
                '30': '7.5rem',
            },
            borderRadius: {
                'xl': '0.75rem',
                '2xl': '1rem',
                '3xl': '1.5rem',
            },
            animation: {
                'fade-in-up': 'fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) both',
                'fade-in-left': 'fadeInLeft 0.8s cubic-bezier(0.16, 1, 0.3, 1) both',
                'fade-in-right': 'fadeInRight 0.8s cubic-bezier(0.16, 1, 0.3, 1) both',
                'scale-in': 'scaleIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) both',
                'slide-up': 'slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) both',
            },
            keyframes: {
                fadeInUp: {
                    '0%': { opacity: '0', transform: 'translateY(30px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                fadeInLeft: {
                    '0%': { opacity: '0', transform: 'translateX(-30px)' },
                    '100%': { opacity: '1', transform: 'translateX(0)' },
                },
                fadeInRight: {
                    '0%': { opacity: '0', transform: 'translateX(30px)' },
                    '100%': { opacity: '1', transform: 'translateX(0)' },
                },
                scaleIn: {
                    '0%': { opacity: '0', transform: 'scale(0.97)' },
                    '100%': { opacity: '1', transform: 'scale(1)' },
                },
                slideUp: {
                    '0%': { opacity: '0', transform: 'translateY(20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
            },
        },
    },

    plugins: [forms],
};
