<?php
/**
 * Frontpage Customizer Settings
 *
 * @package News Record
 *
 * New Sections: Categories, Editor Choice, Featured Posts, Posts Carousel
 */

/* ============================================================
   1. CATEGORIES SECTION
   ============================================================ */

$wp_customize->add_section(
	'news_record_categories_section',
	array(
		'title' => esc_html__( 'Categories Section', 'news-record' ),
		'panel' => 'news_record_frontpage_panel',
	)
);

// Enable toggle.
$wp_customize->add_setting(
	'news_record_categories_section_enable',
	array(
		'default'           => true,
		'sanitize_callback' => 'news_record_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new News_Record_Toggle_Checkbox_Custom_control(
		$wp_customize,
		'news_record_categories_section_enable',
		array(
			'label'    => esc_html__( 'Enable Categories Section', 'news-record' ),
			'type'     => 'checkbox',
			'settings' => 'news_record_categories_section_enable',
			'section'  => 'news_record_categories_section',
		)
	)
);

// Section title.
$wp_customize->add_setting(
	'news_record_categories_section_title',
	array(
		'default'           => __( 'Categories', 'news-record' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_categories_section_title',
	array(
		'label'           => esc_html__( 'Section Title', 'news-record' ),
		'section'         => 'news_record_categories_section',
		'active_callback' => 'news_record_if_categories_section_enabled',
	)
);

// Category selectors (up to 6).
for ( $i = 1; $i <= 6; $i++ ) {
	$wp_customize->add_setting(
		'news_record_categories_section_cat_' . $i,
		array(
			'sanitize_callback' => 'news_record_sanitize_dropdown_pages',
		)
	);
	$wp_customize->add_control(
		'news_record_categories_section_cat_' . $i,
		array(
			/* translators: %d: category number */
			'label'           => sprintf( esc_html__( 'Category %d', 'news-record' ), $i ),
			'section'         => 'news_record_categories_section',
			'type'            => 'select',
			'choices'         => news_record_get_post_cat_choices(),
			'active_callback' => 'news_record_if_categories_section_enabled',
		)
	);
}

/* ============================================================
   2. HEADLINES SECTION
   ============================================================ */

$wp_customize->add_section(
	'news_record_headlines_section',
	array(
		'title' => esc_html__( 'Headlines Section', 'news-record' ),
		'panel' => 'news_record_frontpage_panel',
	)
);

// Enable toggle.
$wp_customize->add_setting(
	'news_record_headlines_section_enable',
	array(
		'default'           => true,
		'sanitize_callback' => 'news_record_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new News_Record_Toggle_Checkbox_Custom_control(
		$wp_customize,
		'news_record_headlines_section_enable',
		array(
			'label'    => esc_html__( 'Enable Headlines Section', 'news-record' ),
			'type'     => 'checkbox',
			'settings' => 'news_record_headlines_section_enable',
			'section'  => 'news_record_headlines_section',
		)
	)
);

// Section title.
$wp_customize->add_setting(
	'news_record_headlines_title',
	array(
		'default'           => __( 'Headlines', 'news-record' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_headlines_title',
	array(
		'label'           => esc_html__( 'Section Title', 'news-record' ),
		'section'         => 'news_record_headlines_section',
		'active_callback' => 'news_record_if_headlines_enabled',
	)
);

// Content type.
$wp_customize->add_setting(
	'news_record_headlines_content_type',
	array(
		'default'           => 'recent',
		'sanitize_callback' => 'news_record_sanitize_select',
	)
);
$wp_customize->add_control(
	'news_record_headlines_content_type',
	array(
		'label'           => esc_html__( 'Content Type:', 'news-record' ),
		'section'         => 'news_record_headlines_section',
		'type'            => 'select',
		'active_callback' => 'news_record_if_headlines_enabled',
		'choices'         => array(
			'recent'   => esc_html__( 'Recent Posts', 'news-record' ),
			'post'     => esc_html__( 'Specific Posts', 'news-record' ),
			'category' => esc_html__( 'By Category', 'news-record' ),
		),
	)
);

// Category picker.
$wp_customize->add_setting(
	'news_record_headlines_category',
	array(
		'sanitize_callback' => 'news_record_sanitize_dropdown_pages',
	)
);
$wp_customize->add_control(
	'news_record_headlines_category',
	array(
		'label'           => esc_html__( 'Select Category', 'news-record' ),
		'section'         => 'news_record_headlines_section',
		'type'            => 'select',
		'choices'         => news_record_get_post_cat_choices(),
		'active_callback' => 'news_record_headlines_content_type_category',
	)
);

// Specific posts.
for ( $i = 1; $i <= 6; $i++ ) {
	$wp_customize->add_setting(
		'news_record_headlines_post_' . $i,
		array(
			'sanitize_callback' => 'news_record_sanitize_dropdown_pages',
		)
	);
	$wp_customize->add_control(
		'news_record_headlines_post_' . $i,
		array(
			'label'           => sprintf( esc_html__( 'Post %d', 'news-record' ), $i ),
			'section'         => 'news_record_headlines_section',
			'type'            => 'select',
			'choices'         => news_record_get_post_choices(),
			'active_callback' => 'news_record_headlines_content_type_post',
		)
	);
}

/* ============================================================
   3. EDITOR CHOICE SECTION
   ============================================================ */

$wp_customize->add_section(
	'news_record_editor_choice_section',
	array(
		'title' => esc_html__( 'Editor Choice Section', 'news-record' ),
		'panel' => 'news_record_frontpage_panel',
	)
);

// Enable toggle.
$wp_customize->add_setting(
	'news_record_editor_choice_section_enable',
	array(
		'default'           => true,
		'sanitize_callback' => 'news_record_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new News_Record_Toggle_Checkbox_Custom_control(
		$wp_customize,
		'news_record_editor_choice_section_enable',
		array(
			'label'    => esc_html__( 'Enable Editor Choice Section', 'news-record' ),
			'type'     => 'checkbox',
			'settings' => 'news_record_editor_choice_section_enable',
			'section'  => 'news_record_editor_choice_section',
		)
	)
);

// Section title.
$wp_customize->add_setting(
	'news_record_editor_choice_title',
	array(
		'default'           => __( 'Editor Choice', 'news-record' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_editor_choice_title',
	array(
		'label'           => esc_html__( 'Section Title', 'news-record' ),
		'section'         => 'news_record_editor_choice_section',
		'active_callback' => 'news_record_if_editor_choice_enabled',
	)
);

// Content type: recent / post / category.
$wp_customize->add_setting(
	'news_record_editor_choice_content_type',
	array(
		'default'           => 'recent',
		'sanitize_callback' => 'news_record_sanitize_select',
	)
);
$wp_customize->add_control(
	'news_record_editor_choice_content_type',
	array(
		'label'           => esc_html__( 'Content Type:', 'news-record' ),
		'description'     => esc_html__( 'Choose where to pull posts from.', 'news-record' ),
		'section'         => 'news_record_editor_choice_section',
		'type'            => 'select',
		'active_callback' => 'news_record_if_editor_choice_enabled',
		'choices'         => array(
			'recent'   => esc_html__( 'Recent Posts', 'news-record' ),
			'post'     => esc_html__( 'Specific Posts', 'news-record' ),
			'category' => esc_html__( 'By Category', 'news-record' ),
		),
	)
);

// Category picker (shown only when content_type = category).
$wp_customize->add_setting(
	'news_record_editor_choice_category',
	array(
		'sanitize_callback' => 'news_record_sanitize_dropdown_pages',
	)
);
$wp_customize->add_control(
	'news_record_editor_choice_category',
	array(
		'label'           => esc_html__( 'Select Category', 'news-record' ),
		'section'         => 'news_record_editor_choice_section',
		'type'            => 'select',
		'choices'         => news_record_get_post_cat_choices(),
		'active_callback' => 'news_record_editor_choice_content_type_category',
	)
);

// Individual post pickers (shown only when content_type = post).
for ( $i = 1; $i <= 6; $i++ ) {
	$wp_customize->add_setting(
		'news_record_editor_choice_post_' . $i,
		array(
			'sanitize_callback' => 'news_record_sanitize_dropdown_pages',
		)
	);
	$wp_customize->add_control(
		'news_record_editor_choice_post_' . $i,
		array(
			/* translators: %d: post number */
			'label'           => sprintf( esc_html__( 'Post %d', 'news-record' ), $i ),
			'section'         => 'news_record_editor_choice_section',
			'type'            => 'select',
			'choices'         => news_record_get_post_choices(),
			'active_callback' => 'news_record_editor_choice_content_type_post',
		)
	);
}

/* ============================================================
   3. FEATURED POSTS SECTION
   ============================================================ */

$wp_customize->add_section(
	'news_record_featured_posts_section',
	array(
		'title' => esc_html__( 'Featured Posts Section', 'news-record' ),
		'panel' => 'news_record_frontpage_panel',
	)
);

// Enable toggle.
$wp_customize->add_setting(
	'news_record_featured_posts_section_enable',
	array(
		'default'           => true,
		'sanitize_callback' => 'news_record_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new News_Record_Toggle_Checkbox_Custom_control(
		$wp_customize,
		'news_record_featured_posts_section_enable',
		array(
			'label'    => esc_html__( 'Enable Featured Posts Section', 'news-record' ),
			'type'     => 'checkbox',
			'settings' => 'news_record_featured_posts_section_enable',
			'section'  => 'news_record_featured_posts_section',
		)
	)
);

// Section title.
$wp_customize->add_setting(
	'news_record_featured_posts_title',
	array(
		'default'           => __( 'Featured Posts', 'news-record' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_featured_posts_title',
	array(
		'label'           => esc_html__( 'Section Title', 'news-record' ),
		'section'         => 'news_record_featured_posts_section',
		'active_callback' => 'news_record_if_featured_posts_enabled',
	)
);

// Content type.
$wp_customize->add_setting(
	'news_record_featured_posts_content_type',
	array(
		'default'           => 'recent',
		'sanitize_callback' => 'news_record_sanitize_select',
	)
);
$wp_customize->add_control(
	'news_record_featured_posts_content_type',
	array(
		'label'           => esc_html__( 'Content Type:', 'news-record' ),
		'section'         => 'news_record_featured_posts_section',
		'type'            => 'select',
		'active_callback' => 'news_record_if_featured_posts_enabled',
		'choices'         => array(
			'recent'   => esc_html__( 'Recent Posts', 'news-record' ),
			'post'     => esc_html__( 'Specific Posts', 'news-record' ),
			'category' => esc_html__( 'By Category', 'news-record' ),
		),
	)
);

// Category picker.
$wp_customize->add_setting(
	'news_record_featured_posts_category',
	array(
		'sanitize_callback' => 'news_record_sanitize_dropdown_pages',
	)
);
$wp_customize->add_control(
	'news_record_featured_posts_category',
	array(
		'label'           => esc_html__( 'Select Category', 'news-record' ),
		'section'         => 'news_record_featured_posts_section',
		'type'            => 'select',
		'choices'         => news_record_get_post_cat_choices(),
		'active_callback' => 'news_record_featured_posts_content_type_category',
	)
);

// Individual post pickers.
for ( $i = 1; $i <= 4; $i++ ) {
	$wp_customize->add_setting(
		'news_record_featured_posts_post_' . $i,
		array(
			'sanitize_callback' => 'news_record_sanitize_dropdown_pages',
		)
	);
	$wp_customize->add_control(
		'news_record_featured_posts_post_' . $i,
		array(
			/* translators: %d: post number */
			'label'           => sprintf( esc_html__( 'Post %d', 'news-record' ), $i ),
			'section'         => 'news_record_featured_posts_section',
			'type'            => 'select',
			'choices'         => news_record_get_post_choices(),
			'active_callback' => 'news_record_featured_posts_content_type_post',
		)
	);
}

/* ============================================================
   4. POSTS CAROUSEL SECTION
   ============================================================ */

$wp_customize->add_section(
	'news_record_posts_carousel_section',
	array(
		'title' => esc_html__( 'Posts Carousel Section', 'news-record' ),
		'panel' => 'news_record_frontpage_panel',
	)
);

// Enable toggle.
$wp_customize->add_setting(
	'news_record_posts_carousel_section_enable',
	array(
		'default'           => true,
		'sanitize_callback' => 'news_record_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new News_Record_Toggle_Checkbox_Custom_control(
		$wp_customize,
		'news_record_posts_carousel_section_enable',
		array(
			'label'    => esc_html__( 'Enable Posts Carousel Section', 'news-record' ),
			'type'     => 'checkbox',
			'settings' => 'news_record_posts_carousel_section_enable',
			'section'  => 'news_record_posts_carousel_section',
		)
	)
);

// Section title.
$wp_customize->add_setting(
	'news_record_posts_carousel_title',
	array(
		'default'           => __( 'Posts Carousel', 'news-record' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_posts_carousel_title',
	array(
		'label'           => esc_html__( 'Section Title', 'news-record' ),
		'section'         => 'news_record_posts_carousel_section',
		'active_callback' => 'news_record_if_posts_carousel_enabled',
	)
);

// Content type.
$wp_customize->add_setting(
	'news_record_posts_carousel_content_type',
	array(
		'default'           => 'recent',
		'sanitize_callback' => 'news_record_sanitize_select',
	)
);
$wp_customize->add_control(
	'news_record_posts_carousel_content_type',
	array(
		'label'           => esc_html__( 'Content Type:', 'news-record' ),
		'section'         => 'news_record_posts_carousel_section',
		'type'            => 'select',
		'active_callback' => 'news_record_if_posts_carousel_enabled',
		'choices'         => array(
			'recent'   => esc_html__( 'Recent Posts', 'news-record' ),
			'post'     => esc_html__( 'Specific Posts', 'news-record' ),
			'category' => esc_html__( 'By Category', 'news-record' ),
		),
	)
);

// Category picker.
$wp_customize->add_setting(
	'news_record_posts_carousel_category',
	array(
		'sanitize_callback' => 'news_record_sanitize_dropdown_pages',
	)
);
$wp_customize->add_control(
	'news_record_posts_carousel_category',
	array(
		'label'           => esc_html__( 'Select Category', 'news-record' ),
		'section'         => 'news_record_posts_carousel_section',
		'type'            => 'select',
		'choices'         => news_record_get_post_cat_choices(),
		'active_callback' => 'news_record_carousel_content_type_category',
	)
);

// Individual post pickers.
for ( $i = 1; $i <= 9; $i++ ) {
	$wp_customize->add_setting(
		'news_record_posts_carousel_post_' . $i,
		array(
			'sanitize_callback' => 'news_record_sanitize_dropdown_pages',
		)
	);
	$wp_customize->add_control(
		'news_record_posts_carousel_post_' . $i,
		array(
			/* translators: %d: post number */
			'label'           => sprintf( esc_html__( 'Post %d', 'news-record' ), $i ),
			'section'         => 'news_record_posts_carousel_section',
			'type'            => 'select',
			'choices'         => news_record_get_post_choices(),
			'active_callback' => 'news_record_carousel_content_type_post',
		)
	);
}

/* ============================================================
   5. VIDEOS SECTION
   ============================================================ */

$wp_customize->add_section(
	'news_record_videos_section',
	array(
		'title' => esc_html__( 'Videos Section', 'news-record' ),
		'panel' => 'news_record_frontpage_panel',
	)
);

// Enable toggle.
$wp_customize->add_setting(
	'news_record_videos_section_enable',
	array(
		'default'           => true,
		'sanitize_callback' => 'news_record_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new News_Record_Toggle_Checkbox_Custom_control(
		$wp_customize,
		'news_record_videos_section_enable',
		array(
			'label'    => esc_html__( 'Enable Videos Section', 'news-record' ),
			'type'     => 'checkbox',
			'settings' => 'news_record_videos_section_enable',
			'section'  => 'news_record_videos_section',
		)
	)
);

// Section title.
$wp_customize->add_setting(
	'news_record_videos_title',
	array(
		'default'           => __( 'Videos', 'news-record' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_videos_title',
	array(
		'label'           => esc_html__( 'Section Title', 'news-record' ),
		'section'         => 'news_record_videos_section',
		'active_callback' => 'news_record_if_videos_enabled',
	)
);

// Content type.
$wp_customize->add_setting(
	'news_record_videos_content_type',
	array(
		'default'           => 'recent',
		'sanitize_callback' => 'news_record_sanitize_select',
	)
);
$wp_customize->add_control(
	'news_record_videos_content_type',
	array(
		'label'           => esc_html__( 'Content Type:', 'news-record' ),
		'section'         => 'news_record_videos_section',
		'type'            => 'select',
		'active_callback' => 'news_record_if_videos_enabled',
		'choices'         => array(
			'recent'   => esc_html__( 'Recent Posts', 'news-record' ),
			'post'     => esc_html__( 'Specific Posts', 'news-record' ),
			'category' => esc_html__( 'By Category', 'news-record' ),
		),
	)
);

// Category picker.
$wp_customize->add_setting(
	'news_record_videos_category',
	array(
		'sanitize_callback' => 'news_record_sanitize_dropdown_pages',
	)
);
$wp_customize->add_control(
	'news_record_videos_category',
	array(
		'label'           => esc_html__( 'Select Category', 'news-record' ),
		'section'         => 'news_record_videos_section',
		'type'            => 'select',
		'choices'         => news_record_get_post_cat_choices(),
		'active_callback' => 'news_record_videos_content_type_category',
	)
);

// Individual post pickers.
for ( $i = 1; $i <= 6; $i++ ) {
	$wp_customize->add_setting(
		'news_record_videos_post_' . $i,
		array(
			'sanitize_callback' => 'news_record_sanitize_dropdown_pages',
		)
	);
	$wp_customize->add_control(
		'news_record_videos_post_' . $i,
		array(
			'label'           => sprintf( esc_html__( 'Post %d', 'news-record' ), $i ),
			'section'         => 'news_record_videos_section',
			'type'            => 'select',
			'choices'         => news_record_get_post_choices(),
			'active_callback' => 'news_record_videos_content_type_post',
		)
	);
}

/* ============================================================
   ACTIVE CALLBACKS — Controls when customizer fields appear
   ============================================================ */

/** Categories section */
function news_record_if_categories_section_enabled( $control ) {
	return $control->manager->get_setting( 'news_record_categories_section_enable' )->value();
}

/** Editor Choice section */
function news_record_if_editor_choice_enabled( $control ) {
	return $control->manager->get_setting( 'news_record_editor_choice_section_enable' )->value();
}
function news_record_editor_choice_content_type_post( $control ) {
	$type = $control->manager->get_setting( 'news_record_editor_choice_content_type' )->value();
	return news_record_if_editor_choice_enabled( $control ) && ( 'post' === $type );
}
function news_record_editor_choice_content_type_category( $control ) {
	$type = $control->manager->get_setting( 'news_record_editor_choice_content_type' )->value();
	return news_record_if_editor_choice_enabled( $control ) && ( 'category' === $type );
}

/** Featured Posts section */
function news_record_if_featured_posts_enabled( $control ) {
	return $control->manager->get_setting( 'news_record_featured_posts_section_enable' )->value();
}
function news_record_featured_posts_content_type_post( $control ) {
	$type = $control->manager->get_setting( 'news_record_featured_posts_content_type' )->value();
	return news_record_if_featured_posts_enabled( $control ) && ( 'post' === $type );
}
function news_record_featured_posts_content_type_category( $control ) {
	$type = $control->manager->get_setting( 'news_record_featured_posts_content_type' )->value();
	return news_record_if_featured_posts_enabled( $control ) && ( 'category' === $type );
}

/** Posts Carousel section */
function news_record_if_posts_carousel_enabled( $control ) {
	return $control->manager->get_setting( 'news_record_posts_carousel_section_enable' )->value();
}
function news_record_carousel_content_type_post( $control ) {
	$type = $control->manager->get_setting( 'news_record_posts_carousel_content_type' )->value();
	return news_record_if_posts_carousel_enabled( $control ) && ( 'post' === $type );
}
function news_record_carousel_content_type_category( $control ) {
	$type = $control->manager->get_setting( 'news_record_posts_carousel_content_type' )->value();
	return news_record_if_posts_carousel_enabled( $control ) && ( 'category' === $type );
}

/** Headlines section */
function news_record_if_headlines_enabled( $control ) {
	return $control->manager->get_setting( 'news_record_headlines_section_enable' )->value();
}
function news_record_headlines_content_type_post( $control ) {
	$type = $control->manager->get_setting( 'news_record_headlines_content_type' )->value();
	return news_record_if_headlines_enabled( $control ) && ( 'post' === $type );
}
function news_record_headlines_content_type_category( $control ) {
	$type = $control->manager->get_setting( 'news_record_headlines_content_type' )->value();
	return news_record_if_headlines_enabled( $control ) && ( 'category' === $type );
}

/** Videos section */
function news_record_if_videos_enabled( $control ) {
	return $control->manager->get_setting( 'news_record_videos_section_enable' )->value();
}
function news_record_videos_content_type_post( $control ) {
	$type = $control->manager->get_setting( 'news_record_videos_content_type' )->value();
	return news_record_if_videos_enabled( $control ) && ( 'post' === $type );
}
function news_record_videos_content_type_category( $control ) {
	$type = $control->manager->get_setting( 'news_record_videos_content_type' )->value();
	return news_record_if_videos_enabled( $control ) && ( 'category' === $type );
}

/* ============================================================
   6. TRAVEL SECTION
   ============================================================ */

$wp_customize->add_section(
	'news_record_travel_section',
	array(
		'title' => esc_html__( 'Travel Section', 'news-record' ),
		'panel' => 'news_record_frontpage_panel',
	)
);

// Enable toggle.
$wp_customize->add_setting(
	'news_record_travel_section_enable',
	array(
		'default'           => true,
		'sanitize_callback' => 'news_record_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new News_Record_Toggle_Checkbox_Custom_control(
		$wp_customize,
		'news_record_travel_section_enable',
		array(
			'label'    => esc_html__( 'Enable Travel Section', 'news-record' ),
			'type'     => 'checkbox',
			'settings' => 'news_record_travel_section_enable',
			'section'  => 'news_record_travel_section',
		)
	)
);

// Section title.
$wp_customize->add_setting(
	'news_record_travel_title',
	array(
		'default'           => __( 'Travel', 'news-record' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_travel_title',
	array(
		'label'           => esc_html__( 'Section Title', 'news-record' ),
		'section'         => 'news_record_travel_section',
		'active_callback' => 'news_record_if_travel_enabled',
	)
);

// Category picker.
$wp_customize->add_setting(
	'news_record_travel_category',
	array(
		'default'           => 'travel',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_travel_category',
	array(
		'label'           => esc_html__( 'Category Slug', 'news-record' ),
		'description'     => esc_html__( 'Enter the category slug to display posts from.', 'news-record' ),
		'section'         => 'news_record_travel_section',
		'type'            => 'text',
		'active_callback' => 'news_record_if_travel_enabled',
	)
);

// Active callbacks.
function news_record_if_travel_enabled( $control ) {
	return $control->manager->get_setting( 'news_record_travel_section_enable' )->value();
}
