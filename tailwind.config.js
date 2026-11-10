import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    // Kita biarkan 'class' agar jika nanti mau bikin fitur ganti tema, masih bisa
    darkMode: 'class', 

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['"Plus Jakarta Sans"', 'Inter', ...defaultTheme.fontFamily.sans],
                inter: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // ─────────────────────────────────────────────
                // LIGHT MODE PALETTE
                // ─────────────────────────────────────────────
                bg: {
                    DEFAULT: '#F8FAFC', // Background utama (Abu-abu sangat terang)
                    card: '#FFFFFF',    // Card / Surface (Putih bersih)
                    hover: '#F1F5F9',   // Hover state
                },
                border: {
                    DEFAULT: '#E2E8F0', // Garis border abu-abu tipis
                    light: '#CBD5E1',
                },
                text: {
                    DEFAULT: '#0F172A',
                    primary: '#0F172A',   // Teks utama (Hitam pekat)
                    secondary: '#475569', // Teks sekunder (Abu-abu gelap)
                    muted: '#94A3B8',     // Teks pudar
                },
                // Warna Primary, Accent, Success, Warning, Danger TETAP SAMA
                primary: {
                    DEFAULT: '#3B82F6',
                    50: '#eff6ff',
                    100: '#dbeafe',
                    200: '#bfdbfe',
                    300: '#93c5fd',
                    400: '#60a5fa',
                    500: '#3B82F6',
                    600: '#2563eb',
                    700: '#1d4ed8',
                    800: '#1e40af',
                    900: '#1e3a8a',
                },
                accent: {
                    DEFAULT: '#0D9488', // Sedikit digelapkan agar kontras di background putih
                    50: '#f0fdfa',
                    100: '#ccfbf1',
                    200: '#99f6e4',
                    300: '#5eead4',
                    400: '#2DD4BF',
                    500: '#14b8a6',
                    600: '#0d9488',
                },
                success: '#10B981',
                warning: '#F59E0B',
                danger: '#EF4444',
            },
        },
    },

    plugins: [forms],
};