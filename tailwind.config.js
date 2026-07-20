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
                serif: ['Playfair Display', ...defaultTheme.fontFamily.serif],
                mono: ['JetBrains Mono', ...defaultTheme.fontFamily.mono],
            },
            colors: {
                brand: {
                    DEFAULT: '#E07B2A',
                    50: '#FFFFFF',
                    100: '#F9FAFB',
                    200: '#E5E7EB',
                    300: '#D1D5DB',
                    400: '#9CA3AF',
                    500: '#E07B2A',
                    600: '#C76A20',
                    700: '#171717',
                    800: '#0A0A0A',
                    900: '#000000',
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
            },
            typography: {
                DEFAULT: {
                    css: {
                        maxWidth: 'none',
                        color: '#404040',
                        h1: { color: '#000000', fontWeight: '800' },
                        h2: { color: '#000000', fontWeight: '700' },
                        h3: { color: '#0a0a0a', fontWeight: '700' },
                        h4: { color: '#171717', fontWeight: '600' },
                        strong: { color: '#000000', fontWeight: '600' },
                        a: { color: '#E07B2A', textDecoration: 'underline', textDecorationThickness: '1px' },
                        'a:hover': { color: '#C76A20' },
                    },
                },
            },
            spacing: {
                '18': '4.5rem',
                '88': '22rem',
                '128': '32rem',
            },
            animation: {
                'fade-in-up': 'fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) both',
                'fade-in-left': 'fadeInLeft 0.8s cubic-bezier(0.16, 1, 0.3, 1) both',
                'fade-in-right': 'fadeInRight 0.8s cubic-bezier(0.16, 1, 0.3, 1) both',
                'scale-in': 'scaleIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) both',
                'float': 'float 6s ease-in-out infinite',
                'float-slow': 'float 8s ease-in-out infinite',
                'line-grow': 'lineGrow 1s cubic-bezier(0.16, 1, 0.3, 1) both',
                'counter': 'counter 2s cubic-bezier(0.16, 1, 0.3, 1) both',
                'marquee': 'marquee 30s linear infinite',
                'text-reveal': 'textReveal 1s cubic-bezier(0.16, 1, 0.3, 1) both',
                'grid-pan': 'gridPan 40s linear infinite',
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
                    '0%': { opacity: '0', transform: 'scale(0.92)' },
                    '100%': { opacity: '1', transform: 'scale(1)' },
                },
                float: {
                    '0%, 100%': { transform: 'translateY(0px)' },
                    '50%': { transform: 'translateY(-20px)' },
                },
                lineGrow: {
                    '0%': { transform: 'scaleX(0)' },
                    '100%': { transform: 'scaleX(1)' },
                },
                counter: {
                    '0%': { opacity: '0', transform: 'translateY(10px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                marquee: {
                    '0%': { transform: 'translateX(0%)' },
                    '100%': { transform: 'translateX(-100%)' },
                },
                textReveal: {
                    '0%': { opacity: '0', transform: 'translateY(100%) skewY(5deg)' },
                    '100%': { opacity: '1', transform: 'translateY(0) skewY(0)' },
                },
                gridPan: {
                    '0%': { backgroundPosition: '0px 0px' },
                    '100%': { backgroundPosition: '60px 60px' },
                },
            },
        },
    },

    plugins: [forms],
};
