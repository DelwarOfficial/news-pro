<?php
/**
 * Interviews Category Section
 *
 * Displays posts from the Interviews category using the reusable category-section engine.
 * Configurable via Theme Customizer > Frontpage Sections > Interviews Section.
 *
 * @package News Record
 */

// Check if the section is enabled via Customizer.
$interviews_section_enable = get_theme_mod( 'news_record_interviews_section_enable', false );

if ( ! $interviews_section_enable ) {
	return;
}

$section_title = get_theme_mod( 'news_record_interviews_title', esc_html__( 'Interviews', 'news-record' ) );
$category      = get_theme_mod( 'news_record_interviews_category', 'interviews' );
$post_count    = get_theme_mod( 'news_record_interviews_post_count', 4 );
$layout        = 'one-plus-3';
$columns       = 1;
$show_meta     = true;
$show_excerpt  = true;
$sidebar_mode  = 'none';

require get_template_directory() . '/inc/frontpage-sections/category-section.php';
