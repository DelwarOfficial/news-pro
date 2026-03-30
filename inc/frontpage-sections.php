<?php

// Add unified frontpage sections to enqueue
require_once get_template_directory() . '/inc/frontpage-sections/unified-sections.php';

// Add unified styles and scripts
wp_enqueue_style(
	'news-record-frontpage-sections',
	get_template_directory_uri() . '/css/frontpage-sections.css',
	array(),
	'1.0.0'
);

wp_enqueue_script(
	'news-record-frontpage-sections',
	get_template_directory_uri() . '/js/frontpage-sections.js',
	array( 'jquery' ),
	'1.0.0',
	true
);

// Remove old sections.php and use unified implementation
remove_all_actions( 'after_setup_theme' );
require_once get_template_directory() . '/inc/frontpage-sections/unified-implementation.php';