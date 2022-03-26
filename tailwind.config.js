module.exports = {
  mode: 'jit', 
  purge: [
    './*.html',
    './*.js', 
    './*.php'
  ],
  darkMode: false,            // or 'media' or 'class'
  theme: {
    extend: {
      fontFamily: {
        Roboto: "'Roboto', serif",
      }
    },
  },
  variants: {
    extend: {},
  },
  plugins: [
    require('@tailwindcss/forms')
  ],
}
