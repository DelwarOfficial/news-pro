<?php
/**
 * Footer copyright
 */

// Footer copyright
$wp_customize->add_section(
	'news_record_footer_section',
	array(
		'title' => esc_html__( 'Footer Options', 'news-record' ),
		'panel' => 'news_record_theme_options_panel',
	)
);

$copyright_default = sprintf( esc_html_x( 'Copyright &copy; %1$s %2$s', '1: Year, 2: Site Title with home URL', 'news-record' ), '[the-year]', '[site-link]' );

// Footer copyright setting.
$wp_customize->add_setting(
	'news_record_copyright_txt',
	array(
		'default'           => $copyright_default,
		'sanitize_callback' => 'news_record_sanitize_html',
	)
);

$wp_customize->add_control(
	'news_record_copyright_txt',
	array(
		'label'   => esc_html__( 'Copyright text', 'news-record' ),
		'section' => 'news_record_footer_section',
		'type'    => 'textarea',
	)
);

// Footer Newsletter Enable
$wp_customize->add_setting(
	'news_record_footer_newsletter_enable',
	array(
		'default'           => true,
		'sanitize_callback' => 'news_record_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new News_Record_Toggle_Checkbox_Custom_control(
		$wp_customize,
		'news_record_footer_newsletter_enable',
		array(
			'label'    => esc_html__( 'Enable Footer Newsletter', 'news-record' ),
			'type'     => 'checkbox',
			'settings' => 'news_record_footer_newsletter_enable',
			'section'  => 'news_record_footer_section',
		)
	)
);

// Footer Newsletter Title
$wp_customize->add_setting(
	'news_record_footer_newsletter_title',
	array(
		'default'           => __( 'Subscribe to Newsletter', 'news-record' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_footer_newsletter_title',
	array(
		'label'           => esc_html__( 'Newsletter Title', 'news-record' ),
		'section'         => 'news_record_footer_section',
		'active_callback' => 'news_record_if_footer_newsletter_enabled',
	)
);

// Footer Newsletter Description
$wp_customize->add_setting(
	'news_record_footer_newsletter_desc',
	array(
		'default'           => __( 'Get the latest news and updates delivered to your inbox.', 'news-record' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_footer_newsletter_desc',
	array(
		'label'           => esc_html__( 'Newsletter Description', 'news-record' ),
		'section'         => 'news_record_footer_section',
		'type'            => 'textarea',
		'active_callback' => 'news_record_if_footer_newsletter_enabled',
	)
);

// Footer Newsletter Button Text
$wp_customize->add_setting(
	'news_record_footer_newsletter_button',
	array(
		'default'           => __( 'Subscribe', 'news-record' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_footer_newsletter_button',
	array(
		'label'           => esc_html__( 'Button Text', 'news-record' ),
		'section'         => 'news_record_footer_section',
		'active_callback' => 'news_record_if_footer_newsletter_enabled',
	)
);

// Active callback for footer newsletter
function news_record_if_footer_newsletter_enabled( $control ) {
	return $control->manager->get_setting( 'news_record_footer_newsletter_enable' )->value();
}
