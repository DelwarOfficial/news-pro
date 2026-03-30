<?php
/**
 * Featured Category Section
 *
 * Displays posts from a featured category using the reusable category-section engine.
 * Configurable via Theme Customizer > Frontpage Sections > Featured Category Section.
 *
 * @package News Record
 */

// Check if the section is enabled via Customizer.
$featured_category_section_enable = get_theme_mod( 'news_record_featured_category_section_enable', false );

if ( ! $featured_category_section_enable ) {
	return;
}

$section_title = get_theme_mod( 'news_record_featured_category_title', esc_html__( 'Featured', 'news-record' ) );
$category      = get_theme_mod( 'news_record_featured_category_category', 'featured' );
$post_count    = get_theme_mod( 'news_record_featured_category_post_count', 5 );
$layout        = 'tile-list';
$columns       = 1;
$show_meta     = true;
$show_excerpt  = false;
$sidebar_mode  = 'none';

require get_template_directory() . '/inc/frontpage-sections/category-section.php';
