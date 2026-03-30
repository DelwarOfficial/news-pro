<?php
/**
 * Opinions Category Section
 *
 * Displays posts from the Opinions category using the reusable category-section engine.
 * Configurable via Theme Customizer > Frontpage Sections > Opinions Section.
 *
 * @package News Record
 */

// Check if the section is enabled via Customizer.
$opinions_section_enable = get_theme_mod( 'news_record_opinions_section_enable', false );

if ( ! $opinions_section_enable ) {
	return;
}

$section_title = get_theme_mod( 'news_record_opinions_title', esc_html__( 'Opinions', 'news-record' ) );
$category      = get_theme_mod( 'news_record_opinions_category', 'opinions' );
$post_count    = get_theme_mod( 'news_record_opinions_post_count', 4 );
$layout        = 'one-plus-3';
$columns       = 1;
$show_meta     = true;
$show_excerpt  = true;
$sidebar_mode  = 'none';

require get_template_directory() . '/inc/frontpage-sections/category-section.php';
