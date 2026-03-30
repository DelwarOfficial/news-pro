<?php
/**
 * Frontpage Sections Customizer Integration
 * Integrates the unified section engine with the Customizer
 *
 * @package News Record
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add unified section settings to Customizer
 */
function news_record_add_unified_section_settings( $wp_customize ) {
	// Register all sections with unified settings
	$sections = array(
		'categories' => array(
			'title'           => 'Categories',
			'default_title'   => 'Categories',
			'default_enable'  => true,
			'default_count'   => 6,
			'min_count'       => 3,
			'max_count'       => 6,
			'content_types'   => array( 'recent', 'category', 'post' ),
			'category_label'  => 'Categories',
			'post_label'      => 'Posts',
			'section_title'   => 'Categories Section',
		),
		'headlines' => array(
			'title'           => 'Headlines',
			'default_title'   => 'Headlines',
			'default_enable'  => true,
			'default_count'   => 6,
			'min_count'       => 3,
			'max_count'       => 6,
			'content_types'   => array( 'recent', 'category', 'post' ),
			'category_label'  => 'Category',
			'post_label'      => 'Posts',
			'section_title'   => 'Headlines Section',
		),
		'editor_choice' => array(
			'title'           => 'Editor Choice',
			'default_title'   => 'Editor Choice',
			'default_enable'  => true,
			'default_count'   => 6,
			'min_count'       => 3,
			'max_count'       => 6,
			'content_types'   => array( 'recent', 'category', 'post' ),
			'category_label'  => 'Category',
			'post_label'      => 'Posts',
			'section_title'   => 'Editor Choice Section',
		),
		'featured_posts' => array(
			'title'           => 'Featured Posts',
			'default_title'   => 'Featured Posts',
			'default_enable'  => true,
			'default_count'   => 4,
			'min_count'       => 3,
			'max_count'       => 4,
			'content_types'   => array( 'recent', 'category', 'post' ),
			'category_label'  => 'Category',
			'post_label'      => 'Posts',
			'section_title'   => 'Featured Posts Section',
		),
		'posts_carousel' => array(
			'title'           => 'Posts Carousel',
			'default_title'   => 'Posts Carousel',
			'default_enable'  => true,
			'default_count'   => 9,
			'min_count'       => 3,
			'max_count'       => 9,
			'content_types'   => array( 'recent', 'category', 'post' ),
			'category_label'  => 'Category',
			'post_label'      => 'Posts',
			'section_title'   => 'Posts Carousel Section',
		),
		'videos' => array(
			'title'           => 'Videos',
			'default_title'   => 'Videos',
			'default_enable'  => true,
			'default_count'   => 6,
			'min_count'       => 3,
			'max_count'       => 6,
			'content_types'   => array( 'recent', 'category', 'post' ),
			'category_label'  => 'Category',
			'post_label'      => 'Posts',
			'section_title'   => 'Videos Section',
		),
	);

	// Register each section
	foreach ( $sections as $section_id => $args ) {
		news_record_register_standard_section( $wp_customize, $section_id, $args );
	}

	// Register category-based sections
	$category_sections = array(
		'travel' => array(
			'title'           => 'Travel',
			'default_title'   => 'Travel',
			'default_enable'  => false,
			'default_count'   => 6,
			'min_count'       => 3,
			'max_count'       => 12,
			'content_types'   => array( 'category' ),
			'category_label'  => 'Category Slug',
			'post_label'      => 'Posts',
			'section_title'   => 'Travel Section',
		),
		'world_news' => array(
			'title'           => 'World News',
			'default_title'   => 'World News',
			'default_enable'  => false,
			'default_count'   => 5,
			'min_count'       => 3,
			'max_count'       => 12,
			'content_types'   => array( 'category' ),
			'category_label'  => 'Category Slug',
			'post_label'      => 'Posts',
			'section_title'   => 'World News Section',
		),
		'politics' => array(
			'title'           => 'Politics',
			'default_title'   => 'Politics',
			'default_enable'  => false,
			'default_count'   => 6,
			'min_count'       => 3,
			'max_count'       => 12,
			'content_types'   => array( 'category' ),
			'category_label'  => 'Category Slug',
			'post_label'      => 'Posts',
			'section_title'   => 'Politics Section',
		),
		'lifestyle' => array(
			'title'           => 'Lifestyle',
			'default_title'   => 'Lifestyle',
			'default_enable'  => false,
			'default_count'   => 6,
			'min_count'       => 3,
			'max_count'       => 12,
			'content_types'   => array( 'category' ),
			'category_label'  => 'Category Slug',
			'post_label'      => 'Posts',
			'section_title'   => 'Lifestyle Section',
		),
		'opinions' => array(
			'title'           => 'Opinions',
			'default_title'   => 'Opinions',
			'default_enable'  => false,
			'default_count'   => 4,
			'min_count'       => 3,
			'max_count'       => 12,
			'content_types'   => array( 'category' ),
			'category_label'  => 'Category Slug',
			'post_label'      => 'Posts',
			'section_title'   => 'Opinions Section',
		),
		'interviews' => array(
			'title'           => 'Interviews',
			'default_title'   => 'Interviews',
			'default_enable'  => false,
			'default_count'   => 4,
			'min_count'       => 3,
			'max_count'       => 12,
			'content_types'   => array( 'category' ),
			'category_label'  => 'Category Slug',
			'post_label'      => 'Posts',
			'section_title'   => 'Interviews Section',
		),
		'spotlight' => array(
			'title'           => 'Spotlight',
			'default_title'   => 'Spotlight',
			'default_enable'  => false,
			'default_count'   => 5,
			'min_count'       => 3,
			'max_count'       => 12,
			'content_types'   => array( 'category' ),
			'category_label'  => 'Category Slug',
			'post_label'      => 'Posts',
			'section_title'   => 'Spotlight Section',
		),
		'sports' => array(
			'title'           => 'Sports',
			'default_title'   => 'Sports',
			'default_enable'  => false,
			'default_count'   => 5,
			'min_count'       => 3,
			'max_count'       => 12,
			'content_types'   => array( 'category' ),
			'category_label'  => 'Category Slug',
			'post_label'      => 'Posts',
			'section_title'   => 'Sports Section',
		),
		'in_depth' => array(
			'title'           => 'In-Depth',
			'default_title'   => 'In-Depth',
			'default_enable'  => false,
			'default_count'   => 7,
			'min_count'       => 3,
			'max_count'       => 12,
			'content_types'   => array( 'category' ),
			'category_label'  => 'Category Slug',
			'post_label'      => 'Posts',
			'section_title'   => 'In-Depth Section',
		),
		'technology' => array(
			'title'           => 'Technology',
			'default_title'   => 'Technology',
			'default_enable'  => false,
			'default_count'   => 5,
			'min_count'       => 3,
			'max_count'       => 12,
			'content_types'   => array( 'category' ),
			'category_label'  => 'Category Slug',
			'post_label'      => 'Posts',
			'section_title'   => 'Technology Section',
		),
		'featured_category' => array(
			'title'           => 'Featured',
			'default_title'   => 'Featured',
			'default_enable'  => false,
			'default_count'   => 5,
			'min_count'       => 3,
			'max_count'       => 12,
			'content_types'   => array( 'category' ),
			'category_label'  => 'Category Slug',
			'post_label'      => 'Posts',
			'section_title'   => 'Featured Category Section',
		),
		'entertainment' => array(
			'title'           => 'Entertainment',
			'default_title'   => 'Entertainment',
			'default_enable'  => false,
			'default_count'   => 6,
			'min_count'       => 3,
			'max_count'       => 12,
			'content_types'   => array( 'category' ),
			'category_label'  => 'Category Slug',
			'post_label'      => 'Posts',
			'section_title'   => 'Entertainment Section',
		),
		'business' => array(
			'title'           => 'Business',
			'default_title'   => 'Business',
			'default_enable'  => false,
			'default_count'   => 4,
			'min_count'       => 3,
			'max_count'       => 12,
			'content_types'   => array( 'category' ),
			'category_label'  => 'Category Slug',
			'post_label'      => 'Posts',
			'section_title'   => 'Business Section',
		),
	);

	// Register each category section
	foreach ( $category_sections as $section_id => $args ) {
		news_record_register_standard_section( $wp_customize, $section_id, $args );
	}
}

/**
 * Add unified section styles to WordPress
 */
function news_record_enqueue_unified_section_styles() {
	wp_enqueue_style(
		'news-record-frontpage-sections',
		get_template_directory_uri() . '/css/frontpage-sections.css',
		array(),
		'1.0.0'
	);
}

/**
 * Add unified section scripts to WordPress
 */
function news_record_enqueue_unified_section_scripts() {
	wp_enqueue_script(
		'news-record-frontpage-sections',
		get_template_directory_uri() . '/js/frontpage-sections.js',
		array( 'jquery' ),
		'1.0.0',
		true
	);
}

/**
 * Initialize unified section engine
 */
function news_record_init_unified_section_engine() {
	// Load the unified section engine
	require_once get_template_directory() . '/inc/frontpage-sections/unified-section-engine.php';
}

// Hooks
add_action( 'customize_register', 'news_record_add_unified_section_settings' );
add_action( 'wp_enqueue_scripts', 'news_record_enqueue_unified_section_styles' );
add_action( 'wp_enqueue_scripts', 'news_record_enqueue_unified_section_scripts' );
add_action( 'after_setup_theme', 'news_record_init_unified_section_engine' );
?>