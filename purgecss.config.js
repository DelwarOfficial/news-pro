module.exports = {
  content: ['./*.php', './inc/**/*.php', './template-parts/**/*.php', './assets/js/**/*.js'],
  css: ['./style.css'],
  output: './assets/css/style-optimized.css',
  safelist: {
    standard: [
      /^(.*?)-template-(.*?)$/,
      /^(.*?)wp-block-(.*?)$/,
    ],
    deep: [
      /^align/, /^has-/, /^is-/, /^current-menu-/, /^page-/, /^post-/, /^type-/, /^status-/,
      /^format-/, /^tag-/, /^category-/, /^widget/, /^menu-/, /^nav-/, /^comment-/,
      /^logged-in/, /^admin-bar/, /^customize-support/
    ],
    greedy: [
      /slick/, /jConveyorTicker/, /fontawesome/, /fa-/
    ]
  }
}
