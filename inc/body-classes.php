<?php

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function news_record_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	$classes[] = 'artify-news-record';

	$classes[] = news_record_sidebar_layout();

	// Check theme mode (light/dark) from cookie and set body class accordinlgy.
	$news_record_theme_mode = filter_input( INPUT_COOKIE, 'news_record_theme_mode' );
	if ( $news_record_theme_mode ) {
		$classes[] = $news_record_theme_mode;
	}

	return $classes;
}
add_filter( 'body_class', 'news_record_body_classes' );