<?php
/**
 * Business Category Section
 *
 * Displays posts from the Business category using the reusable category-section engine.
 * Configurable via Theme Customizer > Frontpage Sections > Business Section.
 *
 * @package News Record
 */

// Check if the section is enabled via Customizer.
$business_section_enable = get_theme_mod( 'news_record_business_section_enable', false );

if ( ! $business_section_enable ) {
	return;
}

$section_title = get_theme_mod( 'news_record_business_title', esc_html__( 'Business', 'news-record' ) );
$category      = get_theme_mod( 'news_record_business_category', 'business' );
$post_count    = get_theme_mod( 'news_record_business_post_count', 4 );
$layout        = 'vertical';
$columns       = 1;
$show_meta     = true;
$show_excerpt  = true;
$sidebar_mode  = 'none';

require get_template_directory() . '/inc/frontpage-sections/category-section.php';
