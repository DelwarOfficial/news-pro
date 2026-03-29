<?php

/**
 * Color Options
 */

// Site tagline color setting.
$wp_customize->add_setting(
	'news_record_header_tagline',
	array(
		'default'           => '#ffffff',
		'sanitize_callback' => 'news_record_sanitize_hex_color',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'news_record_header_tagline',
		array(
			'label'   => esc_html__( 'Site tagline Color', 'news-record' ),
			'section' => 'colors',
		)
	)
);
