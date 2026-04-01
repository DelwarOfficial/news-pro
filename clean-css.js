const { PurgeCSS } = require('purgecss');
const fs = require('fs');

(async () => {
    // 1. Back up the original file temporarily so PurgeCSS can scan it
    const originalStyle = fs.readFileSync('style.css', 'utf8');
    const headerMatch = originalStyle.match(/^\/\*![\s\S]*?\*\//);
    const header = headerMatch ? headerMatch[0] + '\n\n' : '';

    // 2. Run PurgeCSS
    const purgeCSSResult = await new PurgeCSS().purge({
        content: ['./*.php', './inc/**/*.php', './template-parts/**/*.php', './assets/js/**/*.js'],
        css: ['./style.css'],
        safelist: {
            standard: [
                /^(.*?)-template-(.*?)$/,
                /^(.*?)wp-block-(.*?)$/,
            ],
            deep: [
                /^align/, /^has-/, /^is-/, /^current-menu-/, /^page-/, /^post-/, /^type-/, /^status-/,
                /^format-/, /^tag-/, /^category-/, /^widget/, /^menu-/, /^nav-/, /^comment-/,
                /^logged-in/, /^admin-bar/, /^customize-support/, /^menu-item/, /^news-record/
            ],
            greedy: [
                /slick/, /jConveyorTicker/, /fontawesome/, /fa-/
            ]
        }
    });

    // 3. Extract output and fuse it back with the native WP header
    for (let result of purgeCSSResult) {
        fs.writeFileSync('style.css', header + result.css);
    }
    console.log("PurgeCSS has permanently cleared unused code from style.css while preserving the WP header block!");
})();
