<?php
/**
 * In-Depth Category Section
 *
 * Displays posts from the In-Depth category using the reusable category-section engine.
 * Configurable via Theme Customizer > Frontpage Sections > In-Depth Section.
 *
 * @package News Record
 */

// Check if the section is enabled via Customizer.
$in_depth_section_enable = get_theme_mod( 'news_record_in_depth_section_enable', false );

if ( ! $in_depth_section_enable ) {
	return;
}

$section_title = get_theme_mod( 'news_record_in_depth_title', esc_html__( 'In-Depth', 'news-record' ) );
$category      = get_theme_mod( 'news_record_in_depth_category', 'in-depth' );
$tag           = get_theme_mod( 'news_record_in_depth_tag', '' );
$content_type  = get_theme_mod( 'news_record_in_depth_content_type', 'category' );
$post_count    = get_theme_mod( 'news_record_in_depth_post_count', 7 );
$layout        = 'mixed-grid';
$columns       = 3;
$show_meta     = true;
$show_excerpt  = true;
$sidebar_mode  = 'none';

require get_template_directory() . '/inc/frontpage-sections/category-section.php';
