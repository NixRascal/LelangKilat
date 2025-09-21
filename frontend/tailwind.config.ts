import type { Config } from 'tailwindcss';

const config: Config = {
  darkMode: ['class'],
  content: ['./index.html', './src/**/*.{ts,tsx}'],
  theme: {
    extend: {
      fontFamily: {
        sans: ['"Inter"', 'system-ui', 'sans-serif']
      },
      colors: {
        primary: {
          50: '#eef2ff',
          100: '#e0e7ff',
          500: '#4f46e5',
          600: '#4338ca',
          700: '#3730a3'
        },
        secondary: {
          50: '#ecfdf5',
          100: '#d1fae5',
          500: '#10b981',
          600: '#059669',
          700: '#047857'
        },
        surface: {
          light: '#ffffff',
          dark: '#111827'
        }
      },
      spacing: {
        18: '4.5rem'
      },
      borderRadius: {
        lg: '0.75rem'
      },
      boxShadow: {
        soft: '0 10px 30px rgba(15, 23, 42, 0.12)'
      }
    }
  },
  plugins: []
};

export default config;
