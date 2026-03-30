<?php
/**
 * Travel Category Section
 *
 * Displays posts from the Travel category using the reusable category-section engine.
 * Configurable via Theme Customizer > Frontpage Sections > Travel Section.
 *
 * @package News Record
 */

// Check if the section is enabled via Customizer.
$travel_section_enable = get_theme_mod( 'news_record_travel_section_enable', false );

if ( ! $travel_section_enable ) {
	return;
}

$section_title = get_theme_mod( 'news_record_travel_title', esc_html__( 'Travel', 'news-record' ) );
$category      = get_theme_mod( 'news_record_travel_category', 'travel' );
$tag           = get_theme_mod( 'news_record_travel_tag', '' );
$content_type  = get_theme_mod( 'news_record_travel_content_type', 'category' );
$post_count    = get_theme_mod( 'news_record_travel_post_count', 6 );
$layout        = 'mixed-grid';
$columns       = 3;
$show_meta     = true;
$show_excerpt  = false;
$sidebar_mode  = 'none';

require get_template_directory() . '/inc/frontpage-sections/category-section.php';
