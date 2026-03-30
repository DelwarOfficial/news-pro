<?php
/**
 * Technology Category Section
 *
 * Displays posts from the Technology category using the reusable category-section engine.
 * Configurable via Theme Customizer > Frontpage Sections > Technology Section.
 *
 * @package News Record
 */

// Check if the section is enabled via Customizer.
$technology_section_enable = get_theme_mod( 'news_record_technology_section_enable', false );

if ( ! $technology_section_enable ) {
	return;
}

$section_title = get_theme_mod( 'news_record_technology_title', esc_html__( 'Technology', 'news-record' ) );
$category      = get_theme_mod( 'news_record_technology_category', 'technology' );
$post_count    = get_theme_mod( 'news_record_technology_post_count', 5 );
$layout        = 'tile-list';
$columns       = 1;
$show_meta     = true;
$show_excerpt  = true;
$sidebar_mode  = 'right';

require get_template_directory() . '/inc/frontpage-sections/category-section.php';
