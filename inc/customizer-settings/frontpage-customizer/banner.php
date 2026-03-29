<?php
/**
 * Frontpage Customizer Settings
 *
 * @package News Record
 *
 * Banner Section
 */

$wp_customize->add_section(
	'news_record_banner_section',
	array(
		'title' => esc_html__( 'Banner Section', 'news-record' ),
		'panel' => 'news_record_frontpage_panel',
	)
);

// Banner section enable settings.
$wp_customize->add_setting(
	'news_record_banner_section_enable',
	array(
		'default'           => true,
		'sanitize_callback' => 'news_record_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new News_Record_Toggle_Checkbox_Custom_control(
		$wp_customize,
		'news_record_banner_section_enable',
		array(
			'label'    => esc_html__( 'Enable Banner Section', 'news-record' ),
			'type'     => 'checkbox',
			'settings' => 'news_record_banner_section_enable',
			'section'  => 'news_record_banner_section',
		)
	)
);

// Banner Daily News Sub Heading.
$wp_customize->add_setting(
	'news_record_daily_news_sub_heading',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new News_Record_Section_Sub_Heading_Control(
		$wp_customize,
		'news_record_daily_news_sub_heading',
		array(
			'label'           => esc_html__( 'Banner Daily News Section', 'news-record' ),
			'settings'        => 'news_record_daily_news_sub_heading',
			'section'         => 'news_record_banner_section',
			'active_callback' => 'news_record_if_banner_enabled',
		)
	)
);

// Daily News title settings.
$wp_customize->add_setting(
	'news_record_daily_news_title',
	array(
		'default'           => __( 'Daily News', 'news-record' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'news_record_daily_news_title',
	array(
		'label'           => esc_html__( 'Section Title', 'news-record' ),
		'section'         => 'news_record_banner_section',
		'active_callback' => 'news_record_if_banner_enabled',
	)
);

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial(
		'news_record_daily_news_title',
		array(
			'selector'            => '.banner-section .daily-news h3.section-title',
			'settings'            => 'news_record_daily_news_title',
			'container_inclusive' => false,
			'fallback_refresh'    => true,
		)
	);
}

// banner content type settings.
$wp_customize->add_setting(
	'news_record_daily_news_content_type',
	array(
		'default'           => 'post',
		'sanitize_callback' => 'news_record_sanitize_select',
	)
);

$wp_customize->add_control(
	'news_record_daily_news_content_type',
	array(
		'label'           => esc_html__( 'Content type:', 'news-record' ),
		'description'     => esc_html__( 'Choose where you want to render the content from.', 'news-record' ),
		'section'         => 'news_record_banner_section',
		'type'            => 'select',
		'active_callback' => 'news_record_if_banner_enabled',
		'choices'         => array(
			'post'     => esc_html__( 'Post', 'news-record' ),
			'category' => esc_html__( 'Category', 'news-record' ),
		),
	)
);

for ( $i = 1; $i <= 3; $i++ ) {
	// banner post setting.
	$wp_customize->add_setting(
		'news_record_daily_news_post_' . $i,
		array(
			'sanitize_callback' => 'news_record_sanitize_dropdown_pages',
		)
	);

	$wp_customize->add_control(
		'news_record_daily_news_post_' . $i,
		array(
			'label'           => sprintf( esc_html__( 'Post %d', 'news-record' ), $i ),
			'section'         => 'news_record_banner_section',
			'type'            => 'select',
			'choices'         => news_record_get_post_choices(),
			'active_callback' => 'news_record_daily_news_content_type_post_enabled',
		)
	);

}

// banner category setting.
$wp_customize->add_setting(
	'news_record_daily_news_category',
	array(
		'sanitize_callback' => 'news_record_sanitize_select',
	)
);

$wp_customize->add_control(
	'news_record_daily_news_category',
	array(
		'label'           => esc_html__( 'Category', 'news-record' ),
		'section'         => 'news_record_banner_section',
		'type'            => 'select',
		'choices'         => news_record_get_post_cat_choices(),
		'active_callback' => 'news_record_daily_news_content_type_category_enabled',
	)
);

// Banner Posts Sub Heading.
$wp_customize->add_setting(
	'news_record_banner_posts_sub_heading',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new News_Record_Section_Sub_Heading_Control(
		$wp_customize,
		'news_record_banner_posts_sub_heading',
		array(
			'label'           => esc_html__( 'Banner Posts Section', 'news-record' ),
			'settings'        => 'news_record_banner_posts_sub_heading',
			'section'         => 'news_record_banner_section',
			'active_callback' => 'news_record_if_banner_enabled',
		)
	)
);

// Banner Posts title settings.
$wp_customize->add_setting(
	'news_record_banner_posts_title',
	array(
		'default'           => __( 'Main News', 'news-record' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'news_record_banner_posts_title',
	array(
		'label'           => esc_html__( 'Section Title', 'news-record' ),
		'section'         => 'news_record_banner_section',
		'active_callback' => 'news_record_if_banner_enabled',
	)
);

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial(
		'news_record_banner_posts_title',
		array(
			'selector'            => '.banner-section .banner-posts h3.section-title',
			'settings'            => 'news_record_banner_posts_title',
			'container_inclusive' => false,
			'fallback_refresh'    => true,
		)
	);
}

// banner content type settings.
$wp_customize->add_setting(
	'news_record_banner_posts_content_type',
	array(
		'default'           => 'post',
		'sanitize_callback' => 'news_record_sanitize_select',
	)
);

$wp_customize->add_control(
	'news_record_banner_posts_content_type',
	array(
		'label'           => esc_html__( 'Content type:', 'news-record' ),
		'description'     => esc_html__( 'Choose where you want to render the content from.', 'news-record' ),
		'section'         => 'news_record_banner_section',
		'type'            => 'select',
		'active_callback' => 'news_record_if_banner_enabled',
		'choices'         => array(
			'post'     => esc_html__( 'Post', 'news-record' ),
			'category' => esc_html__( 'Category', 'news-record' ),
		),
	)
);

for ( $i = 1; $i <= 3; $i++ ) {
	// banner post setting.
	$wp_customize->add_setting(
		'news_record_banner_posts_post_' . $i,
		array(
			'sanitize_callback' => 'news_record_sanitize_dropdown_pages',
		)
	);

	$wp_customize->add_control(
		'news_record_banner_posts_post_' . $i,
		array(
			'label'           => sprintf( esc_html__( 'Post %d', 'news-record' ), $i ),
			'section'         => 'news_record_banner_section',
			'type'            => 'select',
			'choices'         => news_record_get_post_choices(),
			'active_callback' => 'news_record_banner_posts_content_type_post_enabled',
		)
	);

}

// banner category setting.
$wp_customize->add_setting(
	'news_record_banner_posts_category',
	array(
		'sanitize_callback' => 'news_record_sanitize_select',
	)
);

$wp_customize->add_control(
	'news_record_banner_posts_category',
	array(
		'label'           => esc_html__( 'Category', 'news-record' ),
		'section'         => 'news_record_banner_section',
		'type'            => 'select',
		'choices'         => news_record_get_post_cat_choices(),
		'active_callback' => 'news_record_banner_posts_content_type_category_enabled',
	)
);

// Banner Top Stories Sub Heading.
$wp_customize->add_setting(
	'news_record_banner_top_stories_sub_heading',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new News_Record_Section_Sub_Heading_Control(
		$wp_customize,
		'news_record_banner_top_stories_sub_heading',
		array(
			'label'           => esc_html__( 'Banner Top Stories Section', 'news-record' ),
			'settings'        => 'news_record_banner_top_stories_sub_heading',
			'section'         => 'news_record_banner_section',
			'active_callback' => 'news_record_if_banner_enabled',
		)
	)
);

// Top Stories title settings.
$wp_customize->add_setting(
	'news_record_banner_top_stories_title',
	array(
		'default'           => __( 'Top Stories', 'news-record' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'news_record_banner_top_stories_title',
	array(
		'label'           => esc_html__( 'Section Title', 'news-record' ),
		'section'         => 'news_record_banner_section',
		'active_callback' => 'news_record_if_banner_enabled',
	)
);

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial(
		'news_record_banner_top_stories_title',
		array(
			'selector'            => '.banner-section .top-stories h3.section-title',
			'settings'            => 'news_record_banner_top_stories_title',
			'container_inclusive' => false,
			'fallback_refresh'    => true,
		)
	);
}

// banner content type settings.
$wp_customize->add_setting(
	'news_record_banner_top_stories_content_type',
	array(
		'default'           => 'post',
		'sanitize_callback' => 'news_record_sanitize_select',
	)
);

$wp_customize->add_control(
	'news_record_banner_top_stories_content_type',
	array(
		'label'           => esc_html__( 'Content type:', 'news-record' ),
		'description'     => esc_html__( 'Choose where you want to render the content from.', 'news-record' ),
		'section'         => 'news_record_banner_section',
		'type'            => 'select',
		'active_callback' => 'news_record_if_banner_enabled',
		'choices'         => array(
			'post'     => esc_html__( 'Post', 'news-record' ),
			'category' => esc_html__( 'Category', 'news-record' ),
		),
	)
);

for ( $i = 1; $i <= 6; $i++ ) {
	// banner post setting.
	$wp_customize->add_setting(
		'news_record_banner_top_stories_post_' . $i,
		array(
			'sanitize_callback' => 'news_record_sanitize_dropdown_pages',
		)
	);

	$wp_customize->add_control(
		'news_record_banner_top_stories_post_' . $i,
		array(
			'label'           => sprintf( esc_html__( 'Post %d', 'news-record' ), $i ),
			'section'         => 'news_record_banner_section',
			'type'            => 'select',
			'choices'         => news_record_get_post_choices(),
			'active_callback' => 'news_record_banner_top_stories_content_type_post_enabled',
		)
	);

}

// banner category setting.
$wp_customize->add_setting(
	'news_record_banner_top_stories_category',
	array(
		'sanitize_callback' => 'news_record_sanitize_select',
	)
);

$wp_customize->add_control(
	'news_record_banner_top_stories_category',
	array(
		'label'           => esc_html__( 'Category', 'news-record' ),
		'section'         => 'news_record_banner_section',
		'type'            => 'select',
		'choices'         => news_record_get_post_cat_choices(),
		'active_callback' => 'news_record_banner_top_stories_content_type_category_enabled',
	)
);

/*========================Active Callback==============================*/
function news_record_if_banner_enabled( $control ) {
	return $control->manager->get_setting( 'news_record_banner_section_enable' )->value();
}
//Banner Daily News.
function news_record_daily_news_content_type_post_enabled( $control ) {
	$content_type = $control->manager->get_setting( 'news_record_daily_news_content_type' )->value();
	return news_record_if_banner_enabled( $control ) && ( 'post' === $content_type );
}
function news_record_daily_news_content_type_category_enabled( $control ) {
	$content_type = $control->manager->get_setting( 'news_record_daily_news_content_type' )->value();
	return news_record_if_banner_enabled( $control ) && ( 'category' === $content_type );
}
//Banner Posts.
function news_record_banner_posts_content_type_post_enabled( $control ) {
	$content_type = $control->manager->get_setting( 'news_record_banner_posts_content_type' )->value();
	return news_record_if_banner_enabled( $control ) && ( 'post' === $content_type );
}
function news_record_banner_posts_content_type_category_enabled( $control ) {
	$content_type = $control->manager->get_setting( 'news_record_banner_posts_content_type' )->value();
	return news_record_if_banner_enabled( $control ) && ( 'category' === $content_type );
}
//Banner Top Stories.
function news_record_banner_top_stories_content_type_post_enabled( $control ) {
	$content_type = $control->manager->get_setting( 'news_record_banner_top_stories_content_type' )->value();
	return news_record_if_banner_enabled( $control ) && ( 'post' === $content_type );
}
function news_record_banner_top_stories_content_type_category_enabled( $control ) {
	$content_type = $control->manager->get_setting( 'news_record_banner_top_stories_content_type' )->value();
	return news_record_if_banner_enabled( $control ) && ( 'category' === $content_type );
}
