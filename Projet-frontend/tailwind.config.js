/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      // Breakpoints personnalisés
      screens: {
        'xs': '475px',   // Très petits téléphones
        'sm': '640px',   // Téléphones en paysage et petites tablettes
        'md': '768px',   // Tablettes
        'lg': '1024px',  // Ordinateurs portables
        'xl': '1280px',  // Écrans de bureau
        '2xl': '1536px', // Grands écrans
        // Breakpoints personnalisés utiles
        'mobile': {'max': '639px'},      // Jusqu'à mobile
        'tablet': {'min': '640px', 'max': '1023px'},  // Tablette uniquement
        'desktop': {'min': '1024px'},    // Desktop et plus
      },
      
      // Espacements adaptés pour mobile
      spacing: {
        '18': '4.5rem',
        '88': '22rem',
        '128': '32rem',
      },
      
      // Hauteurs personnalisées
      height: {
        'screen-1/2': '50vh',
        'screen-1/3': '33.333vh',
        'screen-2/3': '66.666vh',
        'screen-3/4': '75vh',
      },
      
      // Largeurs personnalisées
      maxWidth: {
        '8xl': '88rem',
        '9xl': '96rem',
      },
      
      // Transitions optimisées
      transitionDuration: {
        '400': '400ms',
        '600': '600ms',
      },
      
      // Animations personnalisées
      animation: {
        'fade-in': 'fadeIn 0.3s ease-in-out',
        'slide-up': 'slideUp 0.3s ease-out',
        'slide-down': 'slideDown 0.3s ease-out',
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
        slideDown: {
          '0%': { transform: 'translateY(-10px)', opacity: '0' },
          '100%': { transform: 'translateY(0)', opacity: '1' },
        },
        scaleIn: {
          '0%': { transform: 'scale(0.95)', opacity: '0' },
          '100%': { transform: 'scale(1)', opacity: '1' },
        },
      },
      
      // Couleurs personnalisées pour le projet
      colors: {
        indigo: {
          450: '#6875f5',
          550: '#5850ec',
        },
        primary: {
          50: '#eef2ff',
          100: '#e0e7ff',
          200: '#c7d2fe',
          300: '#a5b4fc',
          400: '#818cf8',
          500: '#6366f1',
          600: '#4f46e5',
          700: '#4338ca',
          800: '#3730a3',
          900: '#312e81',
        }
      },

      // 
      fontFamily: {
        sans: ['Inter', 'ui-sans-serif', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'sans-serif'],
      },
      
      // Bordures arrondies supplémentaires
      borderRadius: {
        '4xl': '2rem',
      },
      
      // Box shadows personnalisées
      boxShadow: {
        'soft': '0 2px 15px 0 rgba(0, 0, 0, 0.05)',
        'medium': '0 4px 25px 0 rgba(0, 0, 0, 0.1)',
        'strong': '0 10px 40px 0 rgba(0, 0, 0, 0.15)',
      },
    },
  },
  plugins: [
    // Plugin pour line-clamp si nécessaire
    require('@tailwindcss/line-clamp'),
    
    // Plugin pour créer des utilitaires personnalisés
    function({ addUtilities }) {
      const newUtilities = {
        '.safe-top': {
          paddingTop: 'env(safe-area-inset-top)',
        },
        '.safe-bottom': {
          paddingBottom: 'env(safe-area-inset-bottom)',
        },
        '.safe-left': {
          paddingLeft: 'env(safe-area-inset-left)',
        },
        '.safe-right': {
          paddingRight: 'env(safe-area-inset-right)',
        },
        '.touch-manipulation': {
          touchAction: 'manipulation',
        },
        '.scrollbar-hide': {
          '-ms-overflow-style': 'none',
          'scrollbar-width': 'none',
          '&::-webkit-scrollbar': {
            display: 'none',
          },
        },
      }
      addUtilities(newUtilities)
    },
  ],
}