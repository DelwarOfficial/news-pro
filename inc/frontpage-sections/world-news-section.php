<?php
/**
 * World News Category Section
 *
 * Displays posts from the World News category using the reusable category-section engine.
 * Configurable via Theme Customizer > Frontpage Sections > World News Section.
 *
 * @package News Record
 */

// Check if the section is enabled via Customizer.
$world_news_section_enable = get_theme_mod( 'news_record_world_news_section_enable', false );

if ( ! $world_news_section_enable ) {
	return;
}

$section_title = get_theme_mod( 'news_record_world_news_title', esc_html__( 'World News', 'news-record' ) );
$category      = get_theme_mod( 'news_record_world_news_category', 'world-news' );
$tag           = get_theme_mod( 'news_record_world_news_tag', '' );
$content_type  = get_theme_mod( 'news_record_world_news_content_type', 'category' );
$post_count    = get_theme_mod( 'news_record_world_news_post_count', 5 );
$layout        = 'tile-list';
$columns       = 1;
$show_meta     = true;
$show_excerpt  = true;
$sidebar_mode  = 'none';

require get_template_directory() . '/inc/frontpage-sections/category-section.php';
