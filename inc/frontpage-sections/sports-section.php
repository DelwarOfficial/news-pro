<?php
/**
 * Sports Category Section
 *
 * Displays posts from the Sports category using the reusable category-section engine.
 * Configurable via Theme Customizer > Frontpage Sections > Sports Section.
 *
 * @package News Record
 */

// Check if the section is enabled via Customizer.
$sports_section_enable = get_theme_mod( 'news_record_sports_section_enable', false );

if ( ! $sports_section_enable ) {
	return;
}

$section_title = get_theme_mod( 'news_record_sports_title', esc_html__( 'Sports', 'news-record' ) );
$category      = get_theme_mod( 'news_record_sports_category', 'sports' );
$tag           = get_theme_mod( 'news_record_sports_tag', '' );
$content_type  = get_theme_mod( 'news_record_sports_content_type', 'category' );
$post_count    = get_theme_mod( 'news_record_sports_post_count', 5 );
$layout        = 'vertical';
$columns       = 1;
$show_meta     = true;
$show_excerpt  = true;
$sidebar_mode  = 'none';

require get_template_directory() . '/inc/frontpage-sections/category-section.php';
