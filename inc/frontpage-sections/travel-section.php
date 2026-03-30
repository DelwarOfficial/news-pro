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
$travel_section_enable = get_theme_mod( 'news_record_travel_section_enable', true );

if ( false === $travel_section_enable ) {
	return;
}

$section_title = get_theme_mod( 'news_record_travel_title', __( 'Travel', 'news-record' ) );
$category      = get_theme_mod( 'news_record_travel_category', 'travel' );
$layout        = 'mixed-grid';
$post_count    = 6;
$columns       = 3;
$show_meta     = true;
$show_excerpt  = false;
$sidebar_mode  = 'none';

require get_template_directory() . '/inc/frontpage-sections/category-section.php';
