<?php
/**
 * Lifestyle Category Section
 *
 * Displays posts from the Lifestyle category using the reusable category-section engine.
 * Configurable via Theme Customizer > Frontpage Sections > Lifestyle Section.
 *
 * @package News Record
 */

// Check if the section is enabled via Customizer.
$lifestyle_section_enable = get_theme_mod( 'news_record_lifestyle_section_enable', false );

if ( ! $lifestyle_section_enable ) {
	return;
}

$section_title = get_theme_mod( 'news_record_lifestyle_title', esc_html__( 'Lifestyle', 'news-record' ) );
$category      = get_theme_mod( 'news_record_lifestyle_category', 'lifestyle' );
$post_count    = get_theme_mod( 'news_record_lifestyle_post_count', 6 );
$layout        = 'two-col';
$columns       = 2;
$show_meta     = true;
$show_excerpt  = false;
$sidebar_mode  = 'none';

require get_template_directory() . '/inc/frontpage-sections/category-section.php';
