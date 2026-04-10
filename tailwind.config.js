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
                // Colores personalizados para gamificación
                'reward': {
                    50: '#fdf4ff',
                    100: '#fae8ff',
                    500: '#a855f7',
                    600: '#9333ea',
                    700: '#7c3aed',
                },
                'achievement': {
                    50: '#fefce8',
                    100: '#fef9c3',
                    500: '#eab308',
                    600: '#ca8a04',
                    700: '#a16207',
                },
                'level': {
                    50: '#f0f9ff',
                    100: '#e0f2fe',
                    500: '#0ea5e9',
                    600: '#0284c7',
                    700: '#0369a1',
                }
            },
            animation: {
                'bounce-slow': 'bounce 2s infinite',
                'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                'fade-in': 'fadeIn 0.5s ease-in-out',
                'slide-up': 'slideUp 0.3s ease-out',
                'scale-in': 'scaleIn 0.2s ease-out',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                slideUp: {
                    '0%': { transform: 'translateY(10px)', opacity: '0' },
                    '100%': { transform: 'translateY(0)', opacity: '1' },
                },
                scaleIn: {
                    '0%': { transform: 'scale(0.95)', opacity: '0' },
                    '100%': { transform: 'scale(1)', opacity: '1' },
                }
            },
            boxShadow: {
                'card': '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)',
                'card-hover': '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
                'glow': '0 0 15px rgba(59, 130, 246, 0.5)',
            },
            backgroundImage: {
                'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
                'gradient-conic': 'conic-gradient(from 180deg at 50% 50%, var(--tw-gradient-stops))',
            }
        },
    },

    plugins: [
        forms,
        // Plugin personalizado para componentes de gamificación
        function({ addComponents, theme }) {
            addComponents({
                '.btn-gamified': {
                    '@apply inline-flex items-center px-4 py-2 rounded-lg font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2': {},
                    '&:hover': {
                        '@apply transform scale-105 shadow-lg': {},
                    }
                },
                '.card-gamified': {
                    '@apply bg-white rounded-xl shadow-card hover:shadow-card-hover transition-all duration-300 transform hover:-translate-y-1': {},
                },
                '.progress-bar': {
                    '@apply w-full bg-gray-200 rounded-full overflow-hidden': {},
                    '& .progress-fill': {
                        '@apply h-full bg-gradient-to-r from-blue-500 to-purple-500 transition-all duration-500 ease-out': {},
                    }
                },
                '.badge-points': {
                    '@apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium': {},
                    '&.positive': {
                        '@apply bg-green-100 text-green-800': {},
                    },
                    '&.negative': {
                        '@apply bg-red-100 text-red-800': {},
                    },
                    '&.neutral': {
                        '@apply bg-gray-100 text-gray-800': {},
                    }
                },
                '.avatar-student': {
                    '@apply w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-sm bg-gradient-to-br from-blue-400 to-purple-500': {},
                },
                '.level-badge': {
                    '@apply inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gradient-to-r from-yellow-400 to-yellow-600 text-white shadow-md': {},
                }
            });
        }
    ],
};