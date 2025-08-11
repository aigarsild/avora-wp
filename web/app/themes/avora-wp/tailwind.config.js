/** @type {import('tailwindcss').Config} */
export default {
  content: ["./**/*.php", "../../app/**/*.php"],
  theme: {
    extend: {
      // Brand Colors - Exact match from static site
      colors: {
        // Primary Brand Colors
        'brand-black': '#000',
        'brand-primary': '#14213D',
        'brand-accent': '#FCA311',
        'brand-gray': '#E5E5E5',
        'brand-white': '#fff',
        
        // Color Shades
        'primary-light': '#1A2A4A',
        'primary-dark': '#0F1829',
        'accent-light': '#FFB933',
        'accent-dark': '#E8920A',
        'gray-light': '#F5F5F5',
        'gray-dark': '#CCCCCC',
      },
      
      // Typography - Poppins font system
      fontFamily: {
        'brand': ['Poppins', 'sans-serif'],
      },
      
      fontWeight: {
        'light': 200,
        'normal': 400,
        'medium': 500,
        'bold': 700,
        'extra-bold': 900,
      },
      
      // Font Sizes - Exact pixel values
      fontSize: {
        'h1': '40px',
        'h2': '36px',
        'h3': '28px',
        'h4': '18px',
        'large': '18px',
        'small': '14px',
      },
      
      // Line Heights
      lineHeight: {
        'tight': '1.2',
        'normal': '1.4',
        'relaxed': '1.6',
      },
      
      // Spacing System - Custom spacing scale
      spacing: {
        'xs': '8px',
        'sm': '10px',
        'md': '15px',
        'lg': '20px',
        'xl': '30px',
        'xxl': '40px',
        'xxxl': '60px',
        'huge': '80px',
        'section': '100px',
        'btn-sm': '12px',
        'btn-md': '40px',
        'btn-lg': '30px',
        '96': '24rem',
        '125': '31.25rem',
      },
      
      // Container
      maxWidth: {
        'container': '1400px',
        '3/5': '60%',
        '4/5': '80%',
      },
      
      // Heights
      height: {
        '90vh': '90vh',
      },
      
      // Border Radius
      borderRadius: {
        'btn': '25px',
        'circle': '50%',
        'hero': '0 0 800px 0',
      },
    },
  },
  plugins: [],
}
