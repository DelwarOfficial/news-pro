<?php
/**
 * Spotlight Category Section
 *
 * Displays posts from the Spotlight category using the reusable category-section engine.
 * Configurable via Theme Customizer > Frontpage Sections > Spotlight Section.
 *
 * @package News Record
 */

// Check if the section is enabled via Customizer.
$spotlight_section_enable = get_theme_mod( 'news_record_spotlight_section_enable', false );

if ( ! $spotlight_section_enable ) {
	return;
}

$section_title = get_theme_mod( 'news_record_spotlight_title', esc_html__( 'Spotlight', 'news-record' ) );
$category      = get_theme_mod( 'news_record_spotlight_category', 'spotlight' );
$post_count    = get_theme_mod( 'news_record_spotlight_post_count', 5 );
$layout        = 'spotlight';
$columns       = 1;
$show_meta     = true;
$show_excerpt  = true;
$sidebar_mode  = 'none';

require get_template_directory() . '/inc/frontpage-sections/category-section.php';
