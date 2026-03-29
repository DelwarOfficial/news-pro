<?php
/**
 * Frontpage Customizer Settings
 *
 * @package News Record
 *
 * Recent Articles Section
 */

$wp_customize->add_section(
	'news_record_recent_articles_section',
	array(
		'title' => esc_html__( 'Recent Articles Section', 'news-record' ),
		'panel' => 'news_record_frontpage_panel',
	)
);

// Recent Articles section enable settings.
$wp_customize->add_setting(
	'news_record_recent_articles_section_enable',
	array(
		'default'           => true,
		'sanitize_callback' => 'news_record_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new News_Record_Toggle_Checkbox_Custom_control(
		$wp_customize,
		'news_record_recent_articles_section_enable',
		array(
			'label'    => esc_html__( 'Enable Recent Articles Section', 'news-record' ),
			'type'     => 'checkbox',
			'settings' => 'news_record_recent_articles_section_enable',
			'section'  => 'news_record_recent_articles_section',
		)
	)
);

// Recent Articles title settings.
$wp_customize->add_setting(
	'news_record_recent_articles_title',
	array(
		'default'           => __( 'Recent Articles', 'news-record' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'news_record_recent_articles_title',
	array(
		'label'           => esc_html__( 'Section Title', 'news-record' ),
		'section'         => 'news_record_recent_articles_section',
		'active_callback' => 'news_record_if_recent_articles_enabled',
	)
);

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial(
		'news_record_recent_articles_title',
		array(
			'selector'            => '.recent-articles h3.section-title',
			'settings'            => 'news_record_recent_articles_title',
			'container_inclusive' => false,
			'fallback_refresh'    => true,
		)
	);
}

// recent_articles content type settings.
$wp_customize->add_setting(
	'news_record_recent_articles_content_type',
	array(
		'default'           => 'recent',
		'sanitize_callback' => 'news_record_sanitize_select',
	)
);

$wp_customize->add_control(
	'news_record_recent_articles_content_type',
	array(
		'label'           => esc_html__( 'Content type:', 'news-record' ),
		'description'     => esc_html__( 'Choose where you want to render the content from.', 'news-record' ),
		'section'         => 'news_record_recent_articles_section',
		'type'            => 'select',
		'active_callback' => 'news_record_if_recent_articles_enabled',
		'choices'         => array(
			'post'   => esc_html__( 'Post', 'news-record' ),
			'recent' => esc_html__( 'Recent', 'news-record' ),
		),
	)
);

for ( $i = 1; $i <= 5; $i++ ) {
	// recent_articles post setting.
	$wp_customize->add_setting(
		'news_record_recent_articles_post_' . $i,
		array(
			'sanitize_callback' => 'news_record_sanitize_dropdown_pages',
		)
	);

	$wp_customize->add_control(
		'news_record_recent_articles_post_' . $i,
		array(
			'label'           => sprintf( esc_html__( 'Post %d', 'news-record' ), $i ),
			'section'         => 'news_record_recent_articles_section',
			'type'            => 'select',
			'choices'         => news_record_get_post_choices(),
			'active_callback' => 'news_record_recent_articles_section_content_type_post_enabled',
		)
	);

}


/*========================Active Callback==============================*/
function news_record_if_recent_articles_enabled( $control ) {
	return $control->manager->get_setting( 'news_record_recent_articles_section_enable' )->value();
}
function news_record_recent_articles_section_content_type_post_enabled( $control ) {
	$content_type = $control->manager->get_setting( 'news_record_recent_articles_content_type' )->value();
	return news_record_if_recent_articles_enabled( $control ) && ( 'post' === $content_type );
}

/*========================Partial Refresh==============================*/
if ( ! function_exists( 'news_record_recent_articles_title_text_partial' ) ) :
	// Title.
	function news_record_recent_articles_title_text_partial() {
		return esc_html( get_theme_mod( 'news_record_recent_articles_title' ) );
	}
endif;
