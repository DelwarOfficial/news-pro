<?php
/**
 * Unified Frontpage Sections
 * Replaces all existing sections with unified implementation
 *
 * @package News Record
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Unified Section Engine
 * Provides consistent customization options and layouts for all sections
 */
require_once get_template_directory() . '/inc/frontpage-sections/unified-section-engine.php';

/**
 * Customizer Integration
 * Registers all sections with standardized settings
 */
require_once get_template_directory() . '/inc/frontpage-sections/customizer-integration.php';

/**
 * Unified Implementation
 * Updates existing sections to use the unified engine
 */
require_once get_template_directory() . '/inc/frontpage-sections/unified-implementation.php';

/**
 * Enqueue Styles and Scripts
 */
function news_record_enqueue_frontpage_section_assets() {
	// Enqueue unified styles
	wp_enqueue_style(
		'news-record-frontpage-sections',
		get_template_directory_uri() . '/css/frontpage-sections.css',
		array(),
		'1.0.0'
	);

	// Enqueue unified scripts
	wp_enqueue_script(
		'news-record-frontpage-sections',
		get_template_directory_uri() . '/js/frontpage-sections.js',
		array( 'jquery' ),
		'1.0.0',
		true
	);
}
add_action( 'wp_enqueue_scripts', 'news_record_enqueue_frontpage_section_assets' );

/**
 * Unified Sections Initialization
 */
function news_record_init_unified_sections() {
	// Remove old sections
	remove_all_actions( 'after_setup_theme' );
	
	// Initialize unified sections
	news_record_init_unified_section_engine();
}
add_action( 'after_setup_theme', 'news_record_init_unified_sections' );
?>