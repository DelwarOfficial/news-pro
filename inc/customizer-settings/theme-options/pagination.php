<?php
/**
 * Pagination setting
 */

// Pagination setting.
$wp_customize->add_section(
	'news_record_pagination',
	array(
		'title' => esc_html__( 'Pagination', 'news-record' ),
		'panel' => 'news_record_theme_options_panel',
	)
);

// Pagination enable setting.
$wp_customize->add_setting(
	'news_record_pagination_enable',
	array(
		'default'           => true,
		'sanitize_callback' => 'news_record_sanitize_checkbox',
	)
);

$wp_customize->add_control(
	new News_Record_Toggle_Checkbox_Custom_control(
		$wp_customize,
		'news_record_pagination_enable',
		array(
			'label'    => esc_html__( 'Enable Pagination.', 'news-record' ),
			'settings' => 'news_record_pagination_enable',
			'section'  => 'news_record_pagination',
			'type'     => 'checkbox',
		)
	)
);

// Pagination - Pagination Style.
$wp_customize->add_setting(
	'news_record_pagination_type',
	array(
		'default'           => 'numeric',
		'sanitize_callback' => 'news_record_sanitize_select',
	)
);

$wp_customize->add_control(
	'news_record_pagination_type',
	array(
		'label'           => esc_html__( 'Pagination Style', 'news-record' ),
		'section'         => 'news_record_pagination',
		'type'            => 'select',
		'choices'         => array(
			'default'  => __( 'Default (Older/Newer)', 'news-record' ),
			'numeric'  => __( 'Numeric', 'news-record' ),
		),
		'active_callback' => 'news_record_pagination_enabled',
	)
);

/*========================Active Callback==============================*/
function news_record_pagination_enabled( $control ) {
	return $control->manager->get_setting( 'news_record_pagination_enable' )->value();
}
