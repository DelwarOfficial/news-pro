<?php
/**
 * Header Options
 */

// Header Options.
$wp_customize->add_section(
	'news_record_header_section',
	array(
		'title' => esc_html__( 'Header Options', 'news-record' ),
		'panel' => 'news_record_theme_options_panel',
	)
);

// Header Button label setting.
$wp_customize->add_setting(
	'news_record_header_button_label',
	array(
		'default'           => __( 'Sign In', 'news-record' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'news_record_header_button_label',
	array(
		'label'    => esc_html__( 'Header Button Label', 'news-record' ),
		'section'  => 'news_record_header_section',
		'settings' => 'news_record_header_button_label',
		'type'     => 'text',
	)
);

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial(
		'news_record_header_button_label',
		array(
			'selector'            => '.header-button a',
			'settings'            => 'news_record_header_button_label',
			'container_inclusive' => false,
			'fallback_refresh'    => true,
		)
	);
}

// Header Button URL setting.
$wp_customize->add_setting(
	'news_record_header_button_url',
	array(
		'default'           => '#',
		'sanitize_callback' => 'esc_url_raw',
	)
);

$wp_customize->add_control(
	'news_record_header_button_url',
	array(
		'label'    => esc_html__( 'Header Button Link', 'news-record' ),
		'section'  => 'news_record_header_section',
		'settings' => 'news_record_header_button_url',
		'type'     => 'url',
	)
);
