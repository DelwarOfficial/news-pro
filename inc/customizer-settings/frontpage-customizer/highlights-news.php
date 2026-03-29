<?php
/**
 * Highlights Section
 */

$wp_customize->add_section(
	'news_record_highlights_news_section',
	array(
		'title' => esc_html__( 'Highlights Section', 'news-record' ),
		'panel' => 'news_record_frontpage_panel',
	)
);

// Highlights News section enable settings.
$wp_customize->add_setting(
	'news_record_highlights_news_section_enable',
	array(
		'default'           => true,
		'sanitize_callback' => 'news_record_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new News_Record_Toggle_Checkbox_Custom_control(
		$wp_customize,
		'news_record_highlights_news_section_enable',
		array(
			'label'    => esc_html__( 'Enable Highlights News Section', 'news-record' ),
			'type'     => 'checkbox',
			'settings' => 'news_record_highlights_news_section_enable',
			'section'  => 'news_record_highlights_news_section',
		)
	)
);

// Highlights News title settings.
$wp_customize->add_setting(
	'news_record_highlights_news_title',
	array(
		'default'           => __( 'Highlights News', 'news-record' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'news_record_highlights_news_title',
	array(
		'label'           => esc_html__( 'Section Title', 'news-record' ),
		'section'         => 'news_record_highlights_news_section',
		'active_callback' => 'news_record_if_highlights_news_enabled',
	)
);

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial(
		'news_record_highlights_news_title',
		array(
			'selector'            => '.recentpost h3.section-title',
			'settings'            => 'news_record_highlights_news_title',
			'container_inclusive' => false,
			'fallback_refresh'    => true,
		)
	);
}

// Highlights news content type settings.
$wp_customize->add_setting(
	'news_record_highlights_news_content_type',
	array(
		'default'           => 'post',
		'sanitize_callback' => 'news_record_sanitize_select',
	)
);

$wp_customize->add_control(
	'news_record_highlights_news_content_type',
	array(
		'label'           => esc_html__( 'Content type:', 'news-record' ),
		'description'     => esc_html__( 'Choose where you want to render the content from.', 'news-record' ),
		'section'         => 'news_record_highlights_news_section',
		'type'            => 'select',
		'active_callback' => 'news_record_if_highlights_news_enabled',
		'choices'         => array(
			'post'     => esc_html__( 'Post', 'news-record' ),
			'category' => esc_html__( 'Category', 'news-record' ),
		),
	)
);

for ( $i = 1; $i <= 6; $i++ ) {
	// Highlights news post setting.
	$wp_customize->add_setting(
		'news_record_highlights_news_post_' . $i,
		array(
			'sanitize_callback' => 'news_record_sanitize_dropdown_pages',
		)
	);

	$wp_customize->add_control(
		'news_record_highlights_news_post_' . $i,
		array(
			'label'           => sprintf( esc_html__( 'Post %d', 'news-record' ), $i ),
			'section'         => 'news_record_highlights_news_section',
			'type'            => 'select',
			'choices'         => news_record_get_post_choices(),
			'active_callback' => 'news_record_highlights_news_section_content_type_post_enabled',
		)
	);

}

// Highlights news category setting.
$wp_customize->add_setting(
	'news_record_highlights_news_category',
	array(
		'sanitize_callback' => 'news_record_sanitize_select',
	)
);

$wp_customize->add_control(
	'news_record_highlights_news_category',
	array(
		'label'           => esc_html__( 'Category', 'news-record' ),
		'section'         => 'news_record_highlights_news_section',
		'type'            => 'select',
		'choices'         => news_record_get_post_cat_choices(),
		'active_callback' => 'news_record_highlights_news_section_content_type_category_enabled',
	)
);

/*========================Active Callback==============================*/
function news_record_if_highlights_news_enabled( $control ) {
	return $control->manager->get_setting( 'news_record_highlights_news_section_enable' )->value();
}
function news_record_highlights_news_section_content_type_post_enabled( $control ) {
	$content_type = $control->manager->get_setting( 'news_record_highlights_news_content_type' )->value();
	return news_record_if_highlights_news_enabled( $control ) && ( 'post' === $content_type );
}
function news_record_highlights_news_section_content_type_category_enabled( $control ) {
	$content_type = $control->manager->get_setting( 'news_record_highlights_news_content_type' )->value();
	return news_record_if_highlights_news_enabled( $control ) && ( 'category' === $content_type );
}

/*========================Partial Refresh==============================*/
if ( ! function_exists( 'news_record_highlights_news_title_text_partial' ) ) :
	// Title.
	function news_record_highlights_news_title_text_partial() {
		return esc_html( get_theme_mod( 'news_record_highlights_news_title' ) );
	}
endif;
