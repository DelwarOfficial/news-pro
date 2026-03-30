<?php
/**
 * Entertainment Category Section
 *
 * Displays posts from the Entertainment category using the reusable category-section engine.
 * Configurable via Theme Customizer > Frontpage Sections > Entertainment Section.
 *
 * @package News Record
 */

// Check if the section is enabled via Customizer.
$entertainment_section_enable = get_theme_mod( 'news_record_entertainment_section_enable', false );

if ( ! $entertainment_section_enable ) {
	return;
}

$section_title = get_theme_mod( 'news_record_entertainment_title', esc_html__( 'Entertainment', 'news-record' ) );
$category      = get_theme_mod( 'news_record_entertainment_category', 'entertainment' );
$post_count    = get_theme_mod( 'news_record_entertainment_post_count', 6 );
$layout        = 'two-col';
$columns       = 2;
$show_meta     = true;
$show_excerpt  = true;
$sidebar_mode  = 'none';

require get_template_directory() . '/inc/frontpage-sections/category-section.php';
