/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.php",
    "./inc/**/*.php",
    "./template-parts/**/*.php",
    "./assets/js/**/*.js"
  ],
  prefix: 'tw-',
  corePlugins: {
    preflight: false, // Disabling preflight preserves existing theme styles and browser defaults
  },
  theme: {
    extend: {},
  },
  plugins: [],
}
