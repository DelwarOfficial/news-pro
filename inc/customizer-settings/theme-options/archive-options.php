<?php
/**
 * Blog / Archive Options
 */

$wp_customize->add_section(
	'news_record_archive_page_options',
	array(
		'title' => esc_html__( 'Blog / Archive Pages Options', 'news-record' ),
		'panel' => 'news_record_theme_options_panel',
	)
);

// Excerpt - Excerpt Length.
$wp_customize->add_setting(
	'news_record_excerpt_length',
	array(
		'default'           => 15,
		'sanitize_callback' => 'news_record_sanitize_number_range',
	)
);

$wp_customize->add_control(
	'news_record_excerpt_length',
	array(
		'label'       => esc_html__( 'Excerpt Length (no. of words)', 'news-record' ),
		'section'     => 'news_record_archive_page_options',
		'settings'    => 'news_record_excerpt_length',
		'type'        => 'number',
		'input_attrs' => array(
			'min'  => 5,
			'max'  => 200,
			'step' => 1,
		),
	)
);

// Archive Column layout options.
$wp_customize->add_setting(
	'news_record_archive_column_layout',
	array(
		'default'           => 'double-column',
		'sanitize_callback' => 'news_record_sanitize_select',
	)
);

$wp_customize->add_control(
	'news_record_archive_column_layout',
	array(
		'label'   => esc_html__( 'Column Layout', 'news-record' ),
		'section' => 'news_record_archive_page_options',
		'type'    => 'select',
		'choices' => array(
			'double-column' => __( 'Column 2', 'news-record' ),
			'triple-column' => __( 'Column 3', 'news-record' ),
		),
	)
);
