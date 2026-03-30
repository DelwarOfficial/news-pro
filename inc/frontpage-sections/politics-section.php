<?php
/**
 * Politics Category Section
 *
 * Displays posts from the Politics category using the reusable category-section engine.
 * Configurable via Theme Customizer > Frontpage Sections > Politics Section.
 *
 * @package News Record
 */

// Check if the section is enabled via Customizer.
$politics_section_enable = get_theme_mod( 'news_record_politics_section_enable', false );

if ( ! $politics_section_enable ) {
	return;
}

$section_title = get_theme_mod( 'news_record_politics_title', esc_html__( 'Politics', 'news-record' ) );
$category      = get_theme_mod( 'news_record_politics_category', 'politics' );
$post_count    = get_theme_mod( 'news_record_politics_post_count', 6 );
$layout        = 'two-col';
$columns       = 2;
$show_meta     = true;
$show_excerpt  = true;
$sidebar_mode  = 'none';

require get_template_directory() . '/inc/frontpage-sections/category-section.php';
