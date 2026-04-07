module.exports = {
  content: [
    './**/*.php',
    './assets/js/**/*.js',
    './src/css/**/*.css',
  ],
  corePlugins: {
    preflight: false, // Enable later in final purge phase.
  },
  theme: {
    extend: {},
  },
  plugins: [],
};
