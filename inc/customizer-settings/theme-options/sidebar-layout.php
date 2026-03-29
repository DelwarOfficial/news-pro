<?php
/**
 * Sidebar settings
 */

$wp_customize->add_section(
	'news_record_sidebar_option',
	array(
		'title' => esc_html__( 'Sidebar Options', 'news-record' ),
		'panel' => 'news_record_theme_options_panel',
	)
);

// Sidebar Option - Archive Sidebar Position.
$wp_customize->add_setting(
	'news_record_archive_sidebar_position',
	array(
		'sanitize_callback' => 'news_record_sanitize_select',
		'default'           => 'right-sidebar',
	)
);

$wp_customize->add_control(
	'news_record_archive_sidebar_position',
	array(
		'label'   => esc_html__( 'Archive Sidebar Position', 'news-record' ),
		'section' => 'news_record_sidebar_option',
		'type'    => 'select',
		'choices' => array(
			'right-sidebar' => esc_html__( 'Right Sidebar', 'news-record' ),
			'no-sidebar'    => esc_html__( 'No Sidebar', 'news-record' ),
		),
	)
);

// Sidebar Option - Post Sidebar Position.
$wp_customize->add_setting(
	'news_record_post_sidebar_position',
	array(
		'sanitize_callback' => 'news_record_sanitize_select',
		'default'           => 'right-sidebar',
	)
);

$wp_customize->add_control(
	'news_record_post_sidebar_position',
	array(
		'label'   => esc_html__( 'Post Sidebar Position', 'news-record' ),
		'section' => 'news_record_sidebar_option',
		'type'    => 'select',
		'choices' => array(
			'right-sidebar' => esc_html__( 'Right Sidebar', 'news-record' ),
			'no-sidebar'    => esc_html__( 'No Sidebar', 'news-record' ),
		),
	)
);

// Sidebar Option - Page Sidebar Position.
$wp_customize->add_setting(
	'news_record_page_sidebar_position',
	array(
		'sanitize_callback' => 'news_record_sanitize_select',
		'default'           => 'right-sidebar',
	)
);

$wp_customize->add_control(
	'news_record_page_sidebar_position',
	array(
		'label'   => esc_html__( 'Page Sidebar Position', 'news-record' ),
		'section' => 'news_record_sidebar_option',
		'type'    => 'select',
		'choices' => array(
			'right-sidebar' => esc_html__( 'Right Sidebar', 'news-record' ),
			'no-sidebar'    => esc_html__( 'No Sidebar', 'news-record' ),
		),
	)
);
