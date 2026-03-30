<?php
/**
 * Unified Frontpage Section Engine.
 * Provides consistent customization options and layouts for all sections.
 *
 * @package News Record
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Standardized section settings structure.
 * All sections should use this consistent approach.
 */
function news_record_get_standard_section_settings( $section_id, $defaults = array() ) {
	$settings = array(
		'enable'          => get_theme_mod( $section_id . '_enable', false ),
		'title'           => get_theme_mod( $section_id . '_title', '' ),
		'category'        => get_theme_mod( $section_id . '_category', '' ),
		'post_count'      => get_theme_mod( $section_id . '_post_count', 6 ),
		'content_type'    => get_theme_mod( $section_id . '_content_type', 'recent' ),
		'custom_title'    => get_theme_mod( $section_id . '_custom_title', '' ),
		'category_select' => get_theme_mod( $section_id . '_category_select', array() ),
	);

	return wp_parse_args( $settings, $defaults );
}

/**
 * Register standardized section settings in Customizer.
 */
function news_record_register_standard_section( $wp_customize, $section_id, $args = array() ) {
	$defaults = array(
		'title'           => '',
		'default_title'   => '',
		'default_enable'  => true,
		'default_count'   => 6,
		'min_count'       => 3,
		'max_count'       => 12,
		'content_types'   => array( 'recent', 'category', 'post' ),
		'category_label'  => __( 'Category', 'news-record' ),
		'post_label'      => __( 'Posts', 'news-record' ),
		'section_title'   => '',
	);

	$args = wp_parse_args( $args, $defaults );

	// Section
	$wp_customize->add_section(
		$section_id . '_section',
		array(
			'title'    => $args['section_title'] ?: $args['title'],
			'panel'    => 'news_record_frontpage_panel',
			'priority' => 100,
		)
	);

	// Enable toggle
	$wp_customize->add_setting(
		$section_id . '_enable',
		array(
			'default'           => $args['default_enable'],
			'sanitize_callback' => 'news_record_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		new News_Record_Toggle_Checkbox_Custom_control(
			$wp_customize,
			$section_id . '_enable',
			array(
				'label'    => sprintf( esc_html__( 'Enable %s Section', 'news-record' ), $args['title'] ),
				'type'     => 'checkbox',
				'settings' => $section_id . '_enable',
				'section'  => $section_id . '_section',
			)
		)
	);

	// Custom title
	$wp_customize->add_setting(
		$section_id . '_custom_title',
		array(
			'default'           => $args['default_title'],
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		$section_id . '_custom_title',
		array(
			'label'           => esc_html__( 'Section Title', 'news-record' ),
			'section'         => $section_id . '_section',
			'active_callback' => 'news_record_if_section_enabled',
		)
	);

	// Content type
	$wp_customize->add_setting(
		$section_id . '_content_type',
		array(
			'default'           => 'recent',
			'sanitize_callback' => 'news_record_sanitize_select',
		)
	);
	$wp_customize->add_control(
		$section_id . '_content_type',
		array(
			'label'           => esc_html__( 'Content Type:', 'news-record' ),
			'section'         => $section_id . '_section',
			'type'            => 'select',
			'active_callback' => 'news_record_if_section_enabled',
			'choices'         => array(
				'recent'   => esc_html__( 'Recent Posts', 'news-record' ),
				'category' => esc_html__( 'By Category', 'news-record' ),
				'post'     => esc_html__( 'Specific Posts', 'news-record' ),
			),
		)
	);

	// Category selection (for category content type)
	$wp_customize->add_setting(
		$section_id . '_category',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		$section_id . '_category',
		array(
			'label'           => $args['category_label'],
			'section'         => $section_id . '_section',
			'type'            => 'text',
			'active_callback' => 'news_record_section_content_type_category',
		)
	);

	// Post count
	$wp_customize->add_setting(
		$section_id . '_post_count',
		array(
			'default'           => $args['default_count'],
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		$section_id . '_post_count',
		array(
			'label'           => esc_html__( 'Number of Posts', 'news-record' ),
			'section'         => $section_id . '_section',
			'type'            => 'number',
			'input_attrs'     => array(
				'min'  => $args['min_count'],
				'max'  => $args['max_count'],
				'step' => 1,
			),
			'active_callback' => 'news_record_if_section_enabled',
		)
	);

	// Specific posts selection (for post content type)
	for ( $i = 1; $i <= $args['max_count']; $i++ ) {
		$wp_customize->add_setting(
			$section_id . '_post_' . $i,
			array(
				'sanitize_callback' => 'news_record_sanitize_dropdown_pages',
			)
		);
		$wp_customize->add_control(
			$section_id . '_post_' . $i,
			array(
				'label'           => sprintf( esc_html__( 'Post %d', 'news-record' ), $i ),
				'section'         => $section_id . '_section',
				'type'            => 'select',
				'choices'         => news_record_get_post_choices(),
				'active_callback' => 'news_record_section_content_type_post',
			)
		);
	}
}

/**
 * Active callback helpers
 */
function news_record_if_section_enabled( $control ) {
	$section_id = str_replace( '_section', '', $control->manager->get_control( $control->id )->section );
	return $control->manager->get_setting( $section_id . '_enable' )->value();
}

function news_record_section_content_type_category( $control ) {
	$section_id = str_replace( '_section', '', $control->manager->get_control( $control->id )->section );
	$type = $control->manager->get_setting( $section_id . '_content_type' )->value();
	return news_record_if_section_enabled( $control ) && ( 'category' === $type );
}

function news_record_section_content_type_post( $control ) {
	$section_id = str_replace( '_section', '', $control->manager->get_control( $control->id )->section );
	$type = $control->manager->get_setting( $section_id . '_content_type' )->value();
	return news_record_if_section_enabled( $control ) && ( 'post' === $type );
}

/**
 * Build query for standardized sections
 */
function news_record_get_standard_section_query( $section_id ) {
	$settings = news_record_get_standard_section_settings( $section_id );

	if ( ! $settings['enable'] ) {
		return false;
	}

	$args = array(
		'post_type'           => 'post',
		'posts_per_page'      => $settings['post_count'],
		'ignore_sticky_posts' => true,
	);

	if ( 'category' === $settings['content_type'] ) {
		if ( ! empty( $settings['category'] ) ) {
			$args['category_name'] = sanitize_text_field( $settings['category'] );
		}
	} elseif ( 'post' === $settings['content_type'] ) {
		$post_ids = array();
		for ( $i = 1; $i <= $settings['post_count']; $i++ ) {
			$post_id = get_theme_mod( $section_id . '_post_' . $i );
			if ( ! empty( $post_id ) ) {
				$post_ids[] = absint( $post_id );
			}
		}
		if ( ! empty( $post_ids ) ) {
			$args['post__in'] = $post_ids;
			$args['orderby']  = 'post__in';
		}
	}

	return new WP_Query( $args );
}

/**
 * Get section title with custom override
 */
function news_record_get_section_title( $section_id, $default_title ) {
	$settings = news_record_get_standard_section_settings( $section_id );
	return ! empty( $settings['custom_title'] ) ? $settings['custom_title'] : $default_title;
}

/**
 * Get section category name
 */
function news_record_get_section_category_name( $section_id ) {
	$settings = news_record_get_standard_section_settings( $section_id );
	if ( 'category' === $settings['content_type'] && ! empty( $settings['category'] ) ) {
		$category = get_category_by_slug( $settings['category'] );
		return $category ? $category->name : '';
	}
	return '';
}

/**
 * Get section post count
 */
function news_record_get_section_post_count( $section_id ) {
	$settings = news_record_get_standard_section_settings( $section_id );
	return $settings['post_count'];
}
?>