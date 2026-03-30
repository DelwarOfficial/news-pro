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

/** Tri-Column section */
function news_record_if_tri_col_enabled( $control ) {
	return $control->manager->get_setting( 'news_record_tri_col_section_enable' )->value();
}
function news_record_tri_col_1_content_type_category( $control ) {
	$type = $control->manager->get_setting( 'news_record_tri_col_1_content_type' )->value();
	return news_record_if_tri_col_enabled( $control ) && ( 'category' === $type );
}
function news_record_tri_col_1_content_type_tag( $control ) {
	$type = $control->manager->get_setting( 'news_record_tri_col_1_content_type' )->value();
	return news_record_if_tri_col_enabled( $control ) && ( 'tag' === $type );
}
function news_record_tri_col_2_content_type_category( $control ) {
	$type = $control->manager->get_setting( 'news_record_tri_col_2_content_type' )->value();
	return news_record_if_tri_col_enabled( $control ) && ( 'category' === $type );
}
function news_record_tri_col_2_content_type_tag( $control ) {
	$type = $control->manager->get_setting( 'news_record_tri_col_2_content_type' )->value();
	return news_record_if_tri_col_enabled( $control ) && ( 'tag' === $type );
}
function news_record_tri_col_3_content_type_category( $control ) {
	$type = $control->manager->get_setting( 'news_record_tri_col_3_content_type' )->value();
	return news_record_if_tri_col_enabled( $control ) && ( 'category' === $type );
}
function news_record_tri_col_3_content_type_tag( $control ) {
	$type = $control->manager->get_setting( 'news_record_tri_col_3_content_type' )->value();
	return news_record_if_tri_col_enabled( $control ) && ( 'tag' === $type );
}

/* ============================================================
   TRI-COLUMN DEFAULT LAYOUT SECTION
   ============================================================ */

$wp_customize->add_section(
	'news_record_tri_col_section',
	array(
		'title'    => esc_html__( 'Default Layout 3 Column', 'news-record' ),
		'panel'    => 'news_record_frontpage_panel',
		'priority' => 190,
	)
);

// Enable toggle.
$wp_customize->add_setting(
	'news_record_tri_col_section_enable',
	array(
		'default'           => false,
		'sanitize_callback' => 'news_record_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new News_Record_Toggle_Checkbox_Custom_control(
		$wp_customize,
		'news_record_tri_col_section_enable',
		array(
			'label'    => esc_html__( 'Enable 3 Column Section', 'news-record' ),
			'type'     => 'checkbox',
			'settings' => 'news_record_tri_col_section_enable',
			'section'  => 'news_record_tri_col_section',
		)
	)
);

for ( $col = 1; $col <= 3; $col++ ) {
	
	// Title
	$wp_customize->add_setting(
		'news_record_tri_col_' . $col . '_title',
		array(
			'default'           => 'Column ' . $col,
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'news_record_tri_col_' . $col . '_title',
		array(
			/* translators: %d: column number */
			'label'           => sprintf( esc_html__( 'Column %d Title', 'news-record' ), $col ),
			'section'         => 'news_record_tri_col_section',
			'active_callback' => 'news_record_if_tri_col_enabled',
		)
	);

	// Content Type
	$wp_customize->add_setting(
		'news_record_tri_col_' . $col . '_content_type',
		array(
			'default'           => 'recent',
			'sanitize_callback' => 'news_record_sanitize_select',
		)
	);
	$wp_customize->add_control(
		'news_record_tri_col_' . $col . '_content_type',
		array(
			'label'           => sprintf( esc_html__( 'Column %d Content Type:', 'news-record' ), $col ),
			'section'         => 'news_record_tri_col_section',
			'type'            => 'select',
			'active_callback' => 'news_record_if_tri_col_enabled',
			'choices'         => array(
				'recent'   => esc_html__( 'Recent Posts', 'news-record' ),
				'category' => esc_html__( 'By Category', 'news-record' ),
				'tag'      => esc_html__( 'By Tag', 'news-record' ),
			),
		)
	);

	// Category
	$wp_customize->add_setting(
		'news_record_tri_col_' . $col . '_category',
		array(
			'default'           => '',
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		'news_record_tri_col_' . $col . '_category',
		array(
			'label'           => sprintf( esc_html__( 'Column %d Category', 'news-record' ), $col ),
			'section'         => 'news_record_tri_col_section',
			'type'            => 'select',
			'choices'         => news_record_get_post_cat_choices(),
			'active_callback' => 'news_record_tri_col_' . $col . '_content_type_category',
		)
	);

	// Tag
	$wp_customize->add_setting(
		'news_record_tri_col_' . $col . '_tag',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'news_record_tri_col_' . $col . '_tag',
		array(
			'label'           => sprintf( esc_html__( 'Column %d Tag', 'news-record' ), $col ),
			'section'         => 'news_record_tri_col_section',
			'type'            => 'select',
			'choices'         => news_record_get_tag_choices(),
			'active_callback' => 'news_record_tri_col_' . $col . '_content_type_tag',
		)
	);

	// Number of posts
	$wp_customize->add_setting(
		'news_record_tri_col_' . $col . '_post_count',
		array(
			'default'           => 4,
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		'news_record_tri_col_' . $col . '_post_count',
		array(
			'label'           => sprintf( esc_html__( 'Column %d Posts Count', 'news-record' ), $col ),
			'section'         => 'news_record_tri_col_section',
			'type'            => 'number',
			'input_attrs'     => array(
				'min'  => 1,
				'max'  => 10,
				'step' => 1,
			),
			'active_callback' => 'news_record_if_tri_col_enabled',
		)
	);
}

/* ============================================================
   6. TRAVEL SECTION
   ============================================================ */

$wp_customize->add_section(
	'news_record_travel_section',
	array(
		'title'    => esc_html__( 'Travel Section', 'news-record' ),
		'panel'    => 'news_record_frontpage_panel',
		'priority' => 200,
	)
);

// Enable toggle.
$wp_customize->add_setting(
	'news_record_travel_section_enable',
	array(
		'default'           => false,
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

// Number of posts.
$wp_customize->add_setting(
	'news_record_videos_post_count',
	array(
		'default'           => 6,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'news_record_videos_post_count',
	array(
		'label'           => esc_html__( 'Number of Posts', 'news-record' ),
		'section'         => 'news_record_videos_section',
		'type'            => 'number',
		'input_attrs'     => array(
			'min'  => 3,
			'max'  => 6,
			'step' => 1,
		),
		'active_callback' => 'news_record_if_videos_enabled',
	)
);

// Number of posts.
$wp_customize->add_setting(
	'news_record_posts_carousel_post_count',
	array(
		'default'           => 9,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'news_record_posts_carousel_post_count',
	array(
		'label'           => esc_html__( 'Number of Posts', 'news-record' ),
		'section'         => 'news_record_posts_carousel_section',
		'type'            => 'number',
		'input_attrs'     => array(
			'min'  => 3,
			'max'  => 9,
			'step' => 1,
		),
		'active_callback' => 'news_record_if_posts_carousel_enabled',
	)
);

// Number of posts.
$wp_customize->add_setting(
	'news_record_featured_posts_post_count',
	array(
		'default'           => 4,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'news_record_featured_posts_post_count',
	array(
		'label'           => esc_html__( 'Number of Posts', 'news-record' ),
		'section'         => 'news_record_featured_posts_section',
		'type'            => 'number',
		'input_attrs'     => array(
			'min'  => 1,
			'max'  => 4,
			'step' => 1,
		),
		'active_callback' => 'news_record_if_featured_posts_enabled',
	)
);

// Number of posts.
$wp_customize->add_setting(
	'news_record_editor_choice_post_count',
	array(
		'default'           => 6,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'news_record_editor_choice_post_count',
	array(
		'label'           => esc_html__( 'Number of Posts', 'news-record' ),
		'section'         => 'news_record_editor_choice_section',
		'type'            => 'number',
		'input_attrs'     => array(
			'min'  => 3,
			'max'  => 6,
			'step' => 1,
		),
		'active_callback' => 'news_record_if_editor_choice_enabled',
	)
);

// Number of posts.
$wp_customize->add_setting(
	'news_record_headlines_post_count',
	array(
		'default'           => 6,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'news_record_headlines_post_count',
	array(
		'label'           => esc_html__( 'Number of Posts', 'news-record' ),
		'section'         => 'news_record_headlines_section',
		'type'            => 'number',
		'input_attrs'     => array(
			'min'  => 3,
			'max'  => 6,
			'step' => 1,
		),
		'active_callback' => 'news_record_if_headlines_enabled',
	)
);

// Content Source.
$wp_customize->add_setting(
	'news_record_travel_content_type',
	array(
		'default'           => 'category',
		'sanitize_callback' => 'news_record_sanitize_select',
	)
);
$wp_customize->add_control(
	'news_record_travel_content_type',
	array(
		'label'           => esc_html__( 'Content Source', 'news-record' ),
		'section'         => 'news_record_travel_section',
		'type'            => 'select',
		'choices'         => array(
			'recent'   => esc_html__( 'Recent', 'news-record' ),
			'category' => esc_html__( 'Category', 'news-record' ),
			'tag'      => esc_html__( 'Tag', 'news-record' ),
		),
		'active_callback' => 'news_record_if_travel_enabled',
	)
);

// Category slug.
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
		'active_callback' => 'news_record_if_travel_category_source',
	)
);

// Tag select.
$wp_customize->add_setting(
	'news_record_travel_tag',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_travel_tag',
	array(
		'label'           => esc_html__( 'Select Tag', 'news-record' ),
		'section'         => 'news_record_travel_section',
		'type'            => 'select',
		'choices'         => news_record_get_tag_choices(),
		'active_callback' => 'news_record_if_travel_tag_source',
	)
);

// Post count.
$wp_customize->add_setting(
	'news_record_travel_post_count',
	array(
		'default'           => 6,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'news_record_travel_post_count',
	array(
		'label'           => esc_html__( 'Number of Posts', 'news-record' ),
		'section'         => 'news_record_travel_section',
		'type'            => 'number',
		'input_attrs'     => array(
			'min'  => 3,
			'max'  => 12,
			'step' => 1,
		),
		'active_callback' => 'news_record_if_travel_enabled',
	)
);

/* ============================================================
   8. POLITICS SECTION
   ============================================================ */

$wp_customize->add_section(
	'news_record_politics_section',
	array(
		'title'    => esc_html__( 'Politics Section', 'news-record' ),
		'panel'    => 'news_record_frontpage_panel',
		'priority' => 220,
	)
);

$wp_customize->add_setting(
	'news_record_politics_section_enable',
	array(
		'default'           => false,
		'sanitize_callback' => 'news_record_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new News_Record_Toggle_Checkbox_Custom_control(
		$wp_customize,
		'news_record_politics_section_enable',
		array(
			'label'    => esc_html__( 'Enable Politics Section', 'news-record' ),
			'type'     => 'checkbox',
			'settings' => 'news_record_politics_section_enable',
			'section'  => 'news_record_politics_section',
		)
	)
);

$wp_customize->add_setting(
	'news_record_politics_title',
	array(
		'default'           => __( 'Politics', 'news-record' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_politics_title',
	array(
		'label'           => esc_html__( 'Section Title', 'news-record' ),
		'section'         => 'news_record_politics_section',
		'active_callback' => 'news_record_if_politics_enabled',
	)
);

// Content Source.
$wp_customize->add_setting(
	'news_record_politics_content_type',
	array(
		'default'           => 'category',
		'sanitize_callback' => 'news_record_sanitize_select',
	)
);
$wp_customize->add_control(
	'news_record_politics_content_type',
	array(
		'label'           => esc_html__( 'Content Source', 'news-record' ),
		'section'         => 'news_record_politics_section',
		'type'            => 'select',
		'choices'         => array(
			'recent'   => esc_html__( 'Recent', 'news-record' ),
			'category' => esc_html__( 'Category', 'news-record' ),
			'tag'      => esc_html__( 'Tag', 'news-record' ),
		),
		'active_callback' => 'news_record_if_politics_enabled',
	)
);

$wp_customize->add_setting(
	'news_record_politics_category',
	array(
		'default'           => 'politics',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_politics_category',
	array(
		'label'           => esc_html__( 'Category Slug', 'news-record' ),
		'description'     => esc_html__( 'Enter the category slug to display posts from.', 'news-record' ),
		'section'         => 'news_record_politics_section',
		'type'            => 'text',
		'active_callback' => 'news_record_if_politics_category_source',
	)
);

// Tag select.
$wp_customize->add_setting(
	'news_record_politics_tag',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_politics_tag',
	array(
		'label'           => esc_html__( 'Select Tag', 'news-record' ),
		'section'         => 'news_record_politics_section',
		'type'            => 'select',
		'choices'         => news_record_get_tag_choices(),
		'active_callback' => 'news_record_if_politics_tag_source',
	)
);

$wp_customize->add_setting(
	'news_record_politics_post_count',
	array(
		'default'           => 6,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'news_record_politics_post_count',
	array(
		'label'           => esc_html__( 'Number of Posts', 'news-record' ),
		'section'         => 'news_record_politics_section',
		'type'            => 'number',
		'input_attrs'     => array(
			'min'  => 3,
			'max'  => 12,
			'step' => 1,
		),
		'active_callback' => 'news_record_if_politics_enabled',
	)
);

/* ============================================================
   9. LIFESTYLE SECTION
   ============================================================ */

$wp_customize->add_section(
	'news_record_lifestyle_section',
	array(
		'title'    => esc_html__( 'Lifestyle Section', 'news-record' ),
		'panel'    => 'news_record_frontpage_panel',
		'priority' => 230,
	)
);

$wp_customize->add_setting(
	'news_record_lifestyle_section_enable',
	array(
		'default'           => false,
		'sanitize_callback' => 'news_record_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new News_Record_Toggle_Checkbox_Custom_control(
		$wp_customize,
		'news_record_lifestyle_section_enable',
		array(
			'label'    => esc_html__( 'Enable Lifestyle Section', 'news-record' ),
			'type'     => 'checkbox',
			'settings' => 'news_record_lifestyle_section_enable',
			'section'  => 'news_record_lifestyle_section',
		)
	)
);

$wp_customize->add_setting(
	'news_record_lifestyle_title',
	array(
		'default'           => __( 'Lifestyle', 'news-record' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_lifestyle_title',
	array(
		'label'           => esc_html__( 'Section Title', 'news-record' ),
		'section'         => 'news_record_lifestyle_section',
		'active_callback' => 'news_record_if_lifestyle_enabled',
	)
);

// Content Source.
$wp_customize->add_setting(
	'news_record_lifestyle_content_type',
	array(
		'default'           => 'category',
		'sanitize_callback' => 'news_record_sanitize_select',
	)
);
$wp_customize->add_control(
	'news_record_lifestyle_content_type',
	array(
		'label'           => esc_html__( 'Content Source', 'news-record' ),
		'section'         => 'news_record_lifestyle_section',
		'type'            => 'select',
		'choices'         => array(
			'recent'   => esc_html__( 'Recent', 'news-record' ),
			'category' => esc_html__( 'Category', 'news-record' ),
			'tag'      => esc_html__( 'Tag', 'news-record' ),
		),
		'active_callback' => 'news_record_if_lifestyle_enabled',
	)
);

$wp_customize->add_setting(
	'news_record_lifestyle_category',
	array(
		'default'           => 'lifestyle',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_lifestyle_category',
	array(
		'label'           => esc_html__( 'Category Slug', 'news-record' ),
		'description'     => esc_html__( 'Enter the category slug to display posts from.', 'news-record' ),
		'section'         => 'news_record_lifestyle_section',
		'type'            => 'text',
		'active_callback' => 'news_record_if_lifestyle_category_source',
	)
);

// Tag select.
$wp_customize->add_setting(
	'news_record_lifestyle_tag',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_lifestyle_tag',
	array(
		'label'           => esc_html__( 'Select Tag', 'news-record' ),
		'section'         => 'news_record_lifestyle_section',
		'type'            => 'select',
		'choices'         => news_record_get_tag_choices(),
		'active_callback' => 'news_record_if_lifestyle_tag_source',
	)
);

$wp_customize->add_setting(
	'news_record_lifestyle_post_count',
	array(
		'default'           => 6,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'news_record_lifestyle_post_count',
	array(
		'label'           => esc_html__( 'Number of Posts', 'news-record' ),
		'section'         => 'news_record_lifestyle_section',
		'type'            => 'number',
		'input_attrs'     => array(
			'min'  => 3,
			'max'  => 12,
			'step' => 1,
		),
		'active_callback' => 'news_record_if_lifestyle_enabled',
	)
);

/* ============================================================
   10. OPINIONS SECTION
   ============================================================ */

$wp_customize->add_section(
	'news_record_opinions_section',
	array(
		'title'    => esc_html__( 'Opinions Section', 'news-record' ),
		'panel'    => 'news_record_frontpage_panel',
		'priority' => 240,
	)
);

$wp_customize->add_setting(
	'news_record_opinions_section_enable',
	array(
		'default'           => false,
		'sanitize_callback' => 'news_record_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new News_Record_Toggle_Checkbox_Custom_control(
		$wp_customize,
		'news_record_opinions_section_enable',
		array(
			'label'    => esc_html__( 'Enable Opinions Section', 'news-record' ),
			'type'     => 'checkbox',
			'settings' => 'news_record_opinions_section_enable',
			'section'  => 'news_record_opinions_section',
		)
	)
);

$wp_customize->add_setting(
	'news_record_opinions_title',
	array(
		'default'           => __( 'Opinions', 'news-record' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_opinions_title',
	array(
		'label'           => esc_html__( 'Section Title', 'news-record' ),
		'section'         => 'news_record_opinions_section',
		'active_callback' => 'news_record_if_opinions_enabled',
	)
);

// Content Source.
$wp_customize->add_setting(
	'news_record_opinions_content_type',
	array(
		'default'           => 'category',
		'sanitize_callback' => 'news_record_sanitize_select',
	)
);
$wp_customize->add_control(
	'news_record_opinions_content_type',
	array(
		'label'           => esc_html__( 'Content Source', 'news-record' ),
		'section'         => 'news_record_opinions_section',
		'type'            => 'select',
		'choices'         => array(
			'recent'   => esc_html__( 'Recent', 'news-record' ),
			'category' => esc_html__( 'Category', 'news-record' ),
			'tag'      => esc_html__( 'Tag', 'news-record' ),
		),
		'active_callback' => 'news_record_if_opinions_enabled',
	)
);

$wp_customize->add_setting(
	'news_record_opinions_category',
	array(
		'default'           => 'opinions',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_opinions_category',
	array(
		'label'           => esc_html__( 'Category Slug', 'news-record' ),
		'description'     => esc_html__( 'Enter the category slug to display posts from.', 'news-record' ),
		'section'         => 'news_record_opinions_section',
		'type'            => 'text',
		'active_callback' => 'news_record_if_opinions_category_source',
	)
);

// Tag select.
$wp_customize->add_setting(
	'news_record_opinions_tag',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_opinions_tag',
	array(
		'label'           => esc_html__( 'Select Tag', 'news-record' ),
		'section'         => 'news_record_opinions_section',
		'type'            => 'select',
		'choices'         => news_record_get_tag_choices(),
		'active_callback' => 'news_record_if_opinions_tag_source',
	)
);

$wp_customize->add_setting(
	'news_record_opinions_post_count',
	array(
		'default'           => 4,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'news_record_opinions_post_count',
	array(
		'label'           => esc_html__( 'Number of Posts', 'news-record' ),
		'section'         => 'news_record_opinions_section',
		'type'            => 'number',
		'input_attrs'     => array(
			'min'  => 3,
			'max'  => 12,
			'step' => 1,
		),
		'active_callback' => 'news_record_if_opinions_enabled',
	)
);

/* ============================================================
   11. INTERVIEWS SECTION
   ============================================================ */

$wp_customize->add_section(
	'news_record_interviews_section',
	array(
		'title'    => esc_html__( 'Interviews Section', 'news-record' ),
		'panel'    => 'news_record_frontpage_panel',
		'priority' => 250,
	)
);

$wp_customize->add_setting(
	'news_record_interviews_section_enable',
	array(
		'default'           => false,
		'sanitize_callback' => 'news_record_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new News_Record_Toggle_Checkbox_Custom_control(
		$wp_customize,
		'news_record_interviews_section_enable',
		array(
			'label'    => esc_html__( 'Enable Interviews Section', 'news-record' ),
			'type'     => 'checkbox',
			'settings' => 'news_record_interviews_section_enable',
			'section'  => 'news_record_interviews_section',
		)
	)
);

$wp_customize->add_setting(
	'news_record_interviews_title',
	array(
		'default'           => __( 'Interviews', 'news-record' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_interviews_title',
	array(
		'label'           => esc_html__( 'Section Title', 'news-record' ),
		'section'         => 'news_record_interviews_section',
		'active_callback' => 'news_record_if_interviews_enabled',
	)
);

// Content Source.
$wp_customize->add_setting(
	'news_record_interviews_content_type',
	array(
		'default'           => 'category',
		'sanitize_callback' => 'news_record_sanitize_select',
	)
);
$wp_customize->add_control(
	'news_record_interviews_content_type',
	array(
		'label'           => esc_html__( 'Content Source', 'news-record' ),
		'section'         => 'news_record_interviews_section',
		'type'            => 'select',
		'choices'         => array(
			'recent'   => esc_html__( 'Recent', 'news-record' ),
			'category' => esc_html__( 'Category', 'news-record' ),
			'tag'      => esc_html__( 'Tag', 'news-record' ),
		),
		'active_callback' => 'news_record_if_interviews_enabled',
	)
);

$wp_customize->add_setting(
	'news_record_interviews_category',
	array(
		'default'           => 'interviews',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_interviews_category',
	array(
		'label'           => esc_html__( 'Category Slug', 'news-record' ),
		'description'     => esc_html__( 'Enter the category slug to display posts from.', 'news-record' ),
		'section'         => 'news_record_interviews_section',
		'type'            => 'text',
		'active_callback' => 'news_record_if_interviews_category_source',
	)
);

// Tag select.
$wp_customize->add_setting(
	'news_record_interviews_tag',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_interviews_tag',
	array(
		'label'           => esc_html__( 'Select Tag', 'news-record' ),
		'section'         => 'news_record_interviews_section',
		'type'            => 'select',
		'choices'         => news_record_get_tag_choices(),
		'active_callback' => 'news_record_if_interviews_tag_source',
	)
);

$wp_customize->add_setting(
	'news_record_interviews_post_count',
	array(
		'default'           => 4,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'news_record_interviews_post_count',
	array(
		'label'           => esc_html__( 'Number of Posts', 'news-record' ),
		'section'         => 'news_record_interviews_section',
		'type'            => 'number',
		'input_attrs'     => array(
			'min'  => 3,
			'max'  => 12,
			'step' => 1,
		),
		'active_callback' => 'news_record_if_interviews_enabled',
	)
);

/* ============================================================
   12. SPOTLIGHT SECTION
   ============================================================ */

$wp_customize->add_section(
	'news_record_spotlight_section',
	array(
		'title'    => esc_html__( 'Spotlight Section', 'news-record' ),
		'panel'    => 'news_record_frontpage_panel',
		'priority' => 260,
	)
);

$wp_customize->add_setting(
	'news_record_spotlight_section_enable',
	array(
		'default'           => false,
		'sanitize_callback' => 'news_record_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new News_Record_Toggle_Checkbox_Custom_control(
		$wp_customize,
		'news_record_spotlight_section_enable',
		array(
			'label'    => esc_html__( 'Enable Spotlight Section', 'news-record' ),
			'type'     => 'checkbox',
			'settings' => 'news_record_spotlight_section_enable',
			'section'  => 'news_record_spotlight_section',
		)
	)
);

$wp_customize->add_setting(
	'news_record_spotlight_title',
	array(
		'default'           => __( 'Spotlight', 'news-record' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_spotlight_title',
	array(
		'label'           => esc_html__( 'Section Title', 'news-record' ),
		'section'         => 'news_record_spotlight_section',
		'active_callback' => 'news_record_if_spotlight_enabled',
	)
);

// Content Source.
$wp_customize->add_setting(
	'news_record_spotlight_content_type',
	array(
		'default'           => 'category',
		'sanitize_callback' => 'news_record_sanitize_select',
	)
);
$wp_customize->add_control(
	'news_record_spotlight_content_type',
	array(
		'label'           => esc_html__( 'Content Source', 'news-record' ),
		'section'         => 'news_record_spotlight_section',
		'type'            => 'select',
		'choices'         => array(
			'recent'   => esc_html__( 'Recent', 'news-record' ),
			'category' => esc_html__( 'Category', 'news-record' ),
			'tag'      => esc_html__( 'Tag', 'news-record' ),
		),
		'active_callback' => 'news_record_if_spotlight_enabled',
	)
);

$wp_customize->add_setting(
	'news_record_spotlight_category',
	array(
		'default'           => 'spotlight',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_spotlight_category',
	array(
		'label'           => esc_html__( 'Category Slug', 'news-record' ),
		'description'     => esc_html__( 'Enter the category slug to display posts from.', 'news-record' ),
		'section'         => 'news_record_spotlight_section',
		'type'            => 'text',
		'active_callback' => 'news_record_if_spotlight_category_source',
	)
);

// Tag select.
$wp_customize->add_setting(
	'news_record_spotlight_tag',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_spotlight_tag',
	array(
		'label'           => esc_html__( 'Select Tag', 'news-record' ),
		'section'         => 'news_record_spotlight_section',
		'type'            => 'select',
		'choices'         => news_record_get_tag_choices(),
		'active_callback' => 'news_record_if_spotlight_tag_source',
	)
);

$wp_customize->add_setting(
	'news_record_spotlight_post_count',
	array(
		'default'           => 5,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'news_record_spotlight_post_count',
	array(
		'label'           => esc_html__( 'Number of Posts', 'news-record' ),
		'section'         => 'news_record_spotlight_section',
		'type'            => 'number',
		'input_attrs'     => array(
			'min'  => 3,
			'max'  => 12,
			'step' => 1,
		),
		'active_callback' => 'news_record_if_spotlight_enabled',
	)
);

/* ============================================================
   13. SPORTS SECTION
   ============================================================ */

$wp_customize->add_section(
	'news_record_sports_section',
	array(
		'title'    => esc_html__( 'Sports Section', 'news-record' ),
		'panel'    => 'news_record_frontpage_panel',
		'priority' => 270,
	)
);

$wp_customize->add_setting(
	'news_record_sports_section_enable',
	array(
		'default'           => false,
		'sanitize_callback' => 'news_record_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new News_Record_Toggle_Checkbox_Custom_control(
		$wp_customize,
		'news_record_sports_section_enable',
		array(
			'label'    => esc_html__( 'Enable Sports Section', 'news-record' ),
			'type'     => 'checkbox',
			'settings' => 'news_record_sports_section_enable',
			'section'  => 'news_record_sports_section',
		)
	)
);

$wp_customize->add_setting(
	'news_record_sports_title',
	array(
		'default'           => __( 'Sports', 'news-record' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_sports_title',
	array(
		'label'           => esc_html__( 'Section Title', 'news-record' ),
		'section'         => 'news_record_sports_section',
		'active_callback' => 'news_record_if_sports_enabled',
	)
);

// Content Source.
$wp_customize->add_setting(
	'news_record_sports_content_type',
	array(
		'default'           => 'category',
		'sanitize_callback' => 'news_record_sanitize_select',
	)
);
$wp_customize->add_control(
	'news_record_sports_content_type',
	array(
		'label'           => esc_html__( 'Content Source', 'news-record' ),
		'section'         => 'news_record_sports_section',
		'type'            => 'select',
		'choices'         => array(
			'recent'   => esc_html__( 'Recent', 'news-record' ),
			'category' => esc_html__( 'Category', 'news-record' ),
			'tag'      => esc_html__( 'Tag', 'news-record' ),
		),
		'active_callback' => 'news_record_if_sports_enabled',
	)
);

$wp_customize->add_setting(
	'news_record_sports_category',
	array(
		'default'           => 'sports',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_sports_category',
	array(
		'label'           => esc_html__( 'Category Slug', 'news-record' ),
		'description'     => esc_html__( 'Enter the category slug to display posts from.', 'news-record' ),
		'section'         => 'news_record_sports_section',
		'type'            => 'text',
		'active_callback' => 'news_record_if_sports_category_source',
	)
);

// Tag select.
$wp_customize->add_setting(
	'news_record_sports_tag',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_sports_tag',
	array(
		'label'           => esc_html__( 'Select Tag', 'news-record' ),
		'section'         => 'news_record_sports_section',
		'type'            => 'select',
		'choices'         => news_record_get_tag_choices(),
		'active_callback' => 'news_record_if_sports_tag_source',
	)
);

$wp_customize->add_setting(
	'news_record_sports_post_count',
	array(
		'default'           => 5,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'news_record_sports_post_count',
	array(
		'label'           => esc_html__( 'Number of Posts', 'news-record' ),
		'section'         => 'news_record_sports_section',
		'type'            => 'number',
		'input_attrs'     => array(
			'min'  => 3,
			'max'  => 12,
			'step' => 1,
		),
		'active_callback' => 'news_record_if_sports_enabled',
	)
);

/* ============================================================
   14. IN-DEPTH SECTION
   ============================================================ */

$wp_customize->add_section(
	'news_record_in_depth_section',
	array(
		'title'    => esc_html__( 'In-Depth Section', 'news-record' ),
		'panel'    => 'news_record_frontpage_panel',
		'priority' => 280,
	)
);

$wp_customize->add_setting(
	'news_record_in_depth_section_enable',
	array(
		'default'           => false,
		'sanitize_callback' => 'news_record_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new News_Record_Toggle_Checkbox_Custom_control(
		$wp_customize,
		'news_record_in_depth_section_enable',
		array(
			'label'    => esc_html__( 'Enable In-Depth Section', 'news-record' ),
			'type'     => 'checkbox',
			'settings' => 'news_record_in_depth_section_enable',
			'section'  => 'news_record_in_depth_section',
		)
	)
);

$wp_customize->add_setting(
	'news_record_in_depth_title',
	array(
		'default'           => __( 'In-Depth', 'news-record' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_in_depth_title',
	array(
		'label'           => esc_html__( 'Section Title', 'news-record' ),
		'section'         => 'news_record_in_depth_section',
		'active_callback' => 'news_record_if_in_depth_enabled',
	)
);

// Content Source.
$wp_customize->add_setting(
	'news_record_in_depth_content_type',
	array(
		'default'           => 'category',
		'sanitize_callback' => 'news_record_sanitize_select',
	)
);
$wp_customize->add_control(
	'news_record_in_depth_content_type',
	array(
		'label'           => esc_html__( 'Content Source', 'news-record' ),
		'section'         => 'news_record_in_depth_section',
		'type'            => 'select',
		'choices'         => array(
			'recent'   => esc_html__( 'Recent', 'news-record' ),
			'category' => esc_html__( 'Category', 'news-record' ),
			'tag'      => esc_html__( 'Tag', 'news-record' ),
		),
		'active_callback' => 'news_record_if_in_depth_enabled',
	)
);

$wp_customize->add_setting(
	'news_record_in_depth_category',
	array(
		'default'           => 'in-depth',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_in_depth_category',
	array(
		'label'           => esc_html__( 'Category Slug', 'news-record' ),
		'description'     => esc_html__( 'Enter the category slug to display posts from.', 'news-record' ),
		'section'         => 'news_record_in_depth_section',
		'type'            => 'text',
		'active_callback' => 'news_record_if_in_depth_category_source',
	)
);

// Tag select.
$wp_customize->add_setting(
	'news_record_in_depth_tag',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_in_depth_tag',
	array(
		'label'           => esc_html__( 'Select Tag', 'news-record' ),
		'section'         => 'news_record_in_depth_section',
		'type'            => 'select',
		'choices'         => news_record_get_tag_choices(),
		'active_callback' => 'news_record_if_in_depth_tag_source',
	)
);

$wp_customize->add_setting(
	'news_record_in_depth_post_count',
	array(
		'default'           => 7,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'news_record_in_depth_post_count',
	array(
		'label'           => esc_html__( 'Number of Posts', 'news-record' ),
		'section'         => 'news_record_in_depth_section',
		'type'            => 'number',
		'input_attrs'     => array(
			'min'  => 3,
			'max'  => 12,
			'step' => 1,
		),
		'active_callback' => 'news_record_if_in_depth_enabled',
	)
);

/* ============================================================
   15. TECHNOLOGY SECTION
   ============================================================ */

$wp_customize->add_section(
	'news_record_technology_section',
	array(
		'title'    => esc_html__( 'Technology Section', 'news-record' ),
		'panel'    => 'news_record_frontpage_panel',
		'priority' => 290,
	)
);

$wp_customize->add_setting(
	'news_record_technology_section_enable',
	array(
		'default'           => false,
		'sanitize_callback' => 'news_record_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new News_Record_Toggle_Checkbox_Custom_control(
		$wp_customize,
		'news_record_technology_section_enable',
		array(
			'label'    => esc_html__( 'Enable Technology Section', 'news-record' ),
			'type'     => 'checkbox',
			'settings' => 'news_record_technology_section_enable',
			'section'  => 'news_record_technology_section',
		)
	)
);

$wp_customize->add_setting(
	'news_record_technology_title',
	array(
		'default'           => __( 'Technology', 'news-record' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_technology_title',
	array(
		'label'           => esc_html__( 'Section Title', 'news-record' ),
		'section'         => 'news_record_technology_section',
		'active_callback' => 'news_record_if_technology_enabled',
	)
);

// Content Source.
$wp_customize->add_setting(
	'news_record_technology_content_type',
	array(
		'default'           => 'category',
		'sanitize_callback' => 'news_record_sanitize_select',
	)
);
$wp_customize->add_control(
	'news_record_technology_content_type',
	array(
		'label'           => esc_html__( 'Content Source', 'news-record' ),
		'section'         => 'news_record_technology_section',
		'type'            => 'select',
		'choices'         => array(
			'recent'   => esc_html__( 'Recent', 'news-record' ),
			'category' => esc_html__( 'Category', 'news-record' ),
			'tag'      => esc_html__( 'Tag', 'news-record' ),
		),
		'active_callback' => 'news_record_if_technology_enabled',
	)
);

$wp_customize->add_setting(
	'news_record_technology_category',
	array(
		'default'           => 'technology',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_technology_category',
	array(
		'label'           => esc_html__( 'Category Slug', 'news-record' ),
		'description'     => esc_html__( 'Enter the category slug to display posts from.', 'news-record' ),
		'section'         => 'news_record_technology_section',
		'type'            => 'text',
		'active_callback' => 'news_record_if_technology_category_source',
	)
);

// Tag select.
$wp_customize->add_setting(
	'news_record_technology_tag',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_technology_tag',
	array(
		'label'           => esc_html__( 'Select Tag', 'news-record' ),
		'section'         => 'news_record_technology_section',
		'type'            => 'select',
		'choices'         => news_record_get_tag_choices(),
		'active_callback' => 'news_record_if_technology_tag_source',
	)
);

$wp_customize->add_setting(
	'news_record_technology_post_count',
	array(
		'default'           => 5,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'news_record_technology_post_count',
	array(
		'label'           => esc_html__( 'Number of Posts', 'news-record' ),
		'section'         => 'news_record_technology_section',
		'type'            => 'number',
		'input_attrs'     => array(
			'min'  => 3,
			'max'  => 12,
			'step' => 1,
		),
		'active_callback' => 'news_record_if_technology_enabled',
	)
);

/* ============================================================
   16. FEATURED CATEGORY SECTION
   ============================================================ */

$wp_customize->add_section(
	'news_record_featured_category_section',
	array(
		'title'    => esc_html__( 'Featured Category Section', 'news-record' ),
		'panel'    => 'news_record_frontpage_panel',
		'priority' => 300,
	)
);

$wp_customize->add_setting(
	'news_record_featured_category_section_enable',
	array(
		'default'           => false,
		'sanitize_callback' => 'news_record_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new News_Record_Toggle_Checkbox_Custom_control(
		$wp_customize,
		'news_record_featured_category_section_enable',
		array(
			'label'    => esc_html__( 'Enable Featured Category Section', 'news-record' ),
			'type'     => 'checkbox',
			'settings' => 'news_record_featured_category_section_enable',
			'section'  => 'news_record_featured_category_section',
		)
	)
);

$wp_customize->add_setting(
	'news_record_featured_category_title',
	array(
		'default'           => __( 'Featured', 'news-record' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_featured_category_title',
	array(
		'label'           => esc_html__( 'Section Title', 'news-record' ),
		'section'         => 'news_record_featured_category_section',
		'active_callback' => 'news_record_if_featured_category_enabled',
	)
);

// Content Source.
$wp_customize->add_setting(
	'news_record_featured_category_content_type',
	array(
		'default'           => 'category',
		'sanitize_callback' => 'news_record_sanitize_select',
	)
);
$wp_customize->add_control(
	'news_record_featured_category_content_type',
	array(
		'label'           => esc_html__( 'Content Source', 'news-record' ),
		'section'         => 'news_record_featured_category_section',
		'type'            => 'select',
		'choices'         => array(
			'recent'   => esc_html__( 'Recent', 'news-record' ),
			'category' => esc_html__( 'Category', 'news-record' ),
			'tag'      => esc_html__( 'Tag', 'news-record' ),
		),
		'active_callback' => 'news_record_if_featured_category_enabled',
	)
);

$wp_customize->add_setting(
	'news_record_featured_category_category',
	array(
		'default'           => 'featured',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_featured_category_category',
	array(
		'label'           => esc_html__( 'Category Slug', 'news-record' ),
		'description'     => esc_html__( 'Enter the category slug to display posts from.', 'news-record' ),
		'section'         => 'news_record_featured_category_section',
		'type'            => 'text',
		'active_callback' => 'news_record_if_featured_category_category_source',
	)
);

// Tag select.
$wp_customize->add_setting(
	'news_record_featured_category_tag',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_featured_category_tag',
	array(
		'label'           => esc_html__( 'Select Tag', 'news-record' ),
		'section'         => 'news_record_featured_category_section',
		'type'            => 'select',
		'choices'         => news_record_get_tag_choices(),
		'active_callback' => 'news_record_if_featured_category_tag_source',
	)
);

$wp_customize->add_setting(
	'news_record_featured_category_post_count',
	array(
		'default'           => 5,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'news_record_featured_category_post_count',
	array(
		'label'           => esc_html__( 'Number of Posts', 'news-record' ),
		'section'         => 'news_record_featured_category_section',
		'type'            => 'number',
		'input_attrs'     => array(
			'min'  => 3,
			'max'  => 12,
			'step' => 1,
		),
		'active_callback' => 'news_record_if_featured_category_enabled',
	)
);

/* ============================================================
   17. ENTERTAINMENT SECTION
   ============================================================ */

$wp_customize->add_section(
	'news_record_entertainment_section',
	array(
		'title'    => esc_html__( 'Entertainment Section', 'news-record' ),
		'panel'    => 'news_record_frontpage_panel',
		'priority' => 310,
	)
);

$wp_customize->add_setting(
	'news_record_entertainment_section_enable',
	array(
		'default'           => false,
		'sanitize_callback' => 'news_record_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new News_Record_Toggle_Checkbox_Custom_control(
		$wp_customize,
		'news_record_entertainment_section_enable',
		array(
			'label'    => esc_html__( 'Enable Entertainment Section', 'news-record' ),
			'type'     => 'checkbox',
			'settings' => 'news_record_entertainment_section_enable',
			'section'  => 'news_record_entertainment_section',
		)
	)
);

$wp_customize->add_setting(
	'news_record_entertainment_title',
	array(
		'default'           => __( 'Entertainment', 'news-record' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_entertainment_title',
	array(
		'label'           => esc_html__( 'Section Title', 'news-record' ),
		'section'         => 'news_record_entertainment_section',
		'active_callback' => 'news_record_if_entertainment_enabled',
	)
);

// Content Source.
$wp_customize->add_setting(
	'news_record_entertainment_content_type',
	array(
		'default'           => 'category',
		'sanitize_callback' => 'news_record_sanitize_select',
	)
);
$wp_customize->add_control(
	'news_record_entertainment_content_type',
	array(
		'label'           => esc_html__( 'Content Source', 'news-record' ),
		'section'         => 'news_record_entertainment_section',
		'type'            => 'select',
		'choices'         => array(
			'recent'   => esc_html__( 'Recent', 'news-record' ),
			'category' => esc_html__( 'Category', 'news-record' ),
			'tag'      => esc_html__( 'Tag', 'news-record' ),
		),
		'active_callback' => 'news_record_if_entertainment_enabled',
	)
);

$wp_customize->add_setting(
	'news_record_entertainment_category',
	array(
		'default'           => 'entertainment',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_entertainment_category',
	array(
		'label'           => esc_html__( 'Category Slug', 'news-record' ),
		'description'     => esc_html__( 'Enter the category slug to display posts from.', 'news-record' ),
		'section'         => 'news_record_entertainment_section',
		'type'            => 'text',
		'active_callback' => 'news_record_if_entertainment_category_source',
	)
);

// Tag select.
$wp_customize->add_setting(
	'news_record_entertainment_tag',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_entertainment_tag',
	array(
		'label'           => esc_html__( 'Select Tag', 'news-record' ),
		'section'         => 'news_record_entertainment_section',
		'type'            => 'select',
		'choices'         => news_record_get_tag_choices(),
		'active_callback' => 'news_record_if_entertainment_tag_source',
	)
);

$wp_customize->add_setting(
	'news_record_entertainment_post_count',
	array(
		'default'           => 6,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'news_record_entertainment_post_count',
	array(
		'label'           => esc_html__( 'Number of Posts', 'news-record' ),
		'section'         => 'news_record_entertainment_section',
		'type'            => 'number',
		'input_attrs'     => array(
			'min'  => 3,
			'max'  => 12,
			'step' => 1,
		),
		'active_callback' => 'news_record_if_entertainment_enabled',
	)
);

/* ============================================================
   18. BUSINESS SECTION
   ============================================================ */

$wp_customize->add_section(
	'news_record_business_section',
	array(
		'title'    => esc_html__( 'Business Section', 'news-record' ),
		'panel'    => 'news_record_frontpage_panel',
		'priority' => 320,
	)
);

$wp_customize->add_setting(
	'news_record_business_section_enable',
	array(
		'default'           => false,
		'sanitize_callback' => 'news_record_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new News_Record_Toggle_Checkbox_Custom_control(
		$wp_customize,
		'news_record_business_section_enable',
		array(
			'label'    => esc_html__( 'Enable Business Section', 'news-record' ),
			'type'     => 'checkbox',
			'settings' => 'news_record_business_section_enable',
			'section'  => 'news_record_business_section',
		)
	)
);

$wp_customize->add_setting(
	'news_record_business_title',
	array(
		'default'           => __( 'Business', 'news-record' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_business_title',
	array(
		'label'           => esc_html__( 'Section Title', 'news-record' ),
		'section'         => 'news_record_business_section',
		'active_callback' => 'news_record_if_business_enabled',
	)
);

// Content Source.
$wp_customize->add_setting(
	'news_record_business_content_type',
	array(
		'default'           => 'category',
		'sanitize_callback' => 'news_record_sanitize_select',
	)
);
$wp_customize->add_control(
	'news_record_business_content_type',
	array(
		'label'           => esc_html__( 'Content Source', 'news-record' ),
		'section'         => 'news_record_business_section',
		'type'            => 'select',
		'choices'         => array(
			'recent'   => esc_html__( 'Recent', 'news-record' ),
			'category' => esc_html__( 'Category', 'news-record' ),
			'tag'      => esc_html__( 'Tag', 'news-record' ),
		),
		'active_callback' => 'news_record_if_business_enabled',
	)
);

$wp_customize->add_setting(
	'news_record_business_category',
	array(
		'default'           => 'business',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_business_category',
	array(
		'label'           => esc_html__( 'Category Slug', 'news-record' ),
		'description'     => esc_html__( 'Enter the category slug to display posts from.', 'news-record' ),
		'section'         => 'news_record_business_section',
		'type'            => 'text',
		'active_callback' => 'news_record_if_business_category_source',
	)
);

// Tag select.
$wp_customize->add_setting(
	'news_record_business_tag',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'news_record_business_tag',
	array(
		'label'           => esc_html__( 'Select Tag', 'news-record' ),
		'section'         => 'news_record_business_section',
		'type'            => 'select',
		'choices'         => news_record_get_tag_choices(),
		'active_callback' => 'news_record_if_business_tag_source',
	)
);

$wp_customize->add_setting(
	'news_record_business_post_count',
	array(
		'default'           => 4,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'news_record_business_post_count',
	array(
		'label'           => esc_html__( 'Number of Posts', 'news-record' ),
		'section'         => 'news_record_business_section',
		'type'            => 'number',
		'input_attrs'     => array(
			'min'  => 3,
			'max'  => 12,
			'step' => 1,
		),
		'active_callback' => 'news_record_if_business_enabled',
	)
);

/* ============================================================
   ACTIVE CALLBACKS — Category Sections
   ============================================================ */

// Travel.
function news_record_if_travel_enabled( $control ) {
	return $control->manager->get_setting( 'news_record_travel_section_enable' )->value();
}
function news_record_if_travel_category_source( $control ) {
	$type = $control->manager->get_setting( 'news_record_travel_content_type' )->value();
	return news_record_if_travel_enabled( $control ) && ( 'category' === $type );
}
function news_record_if_travel_tag_source( $control ) {
	$type = $control->manager->get_setting( 'news_record_travel_content_type' )->value();
	return news_record_if_travel_enabled( $control ) && ( 'tag' === $type );
}

// Politics.
function news_record_if_politics_enabled( $control ) {
	return $control->manager->get_setting( 'news_record_politics_section_enable' )->value();
}
function news_record_if_politics_category_source( $control ) {
	$type = $control->manager->get_setting( 'news_record_politics_content_type' )->value();
	return news_record_if_politics_enabled( $control ) && ( 'category' === $type );
}
function news_record_if_politics_tag_source( $control ) {
	$type = $control->manager->get_setting( 'news_record_politics_content_type' )->value();
	return news_record_if_politics_enabled( $control ) && ( 'tag' === $type );
}

// Lifestyle.
function news_record_if_lifestyle_enabled( $control ) {
	return $control->manager->get_setting( 'news_record_lifestyle_section_enable' )->value();
}
function news_record_if_lifestyle_category_source( $control ) {
	$type = $control->manager->get_setting( 'news_record_lifestyle_content_type' )->value();
	return news_record_if_lifestyle_enabled( $control ) && ( 'category' === $type );
}
function news_record_if_lifestyle_tag_source( $control ) {
	$type = $control->manager->get_setting( 'news_record_lifestyle_content_type' )->value();
	return news_record_if_lifestyle_enabled( $control ) && ( 'tag' === $type );
}

// Opinions.
function news_record_if_opinions_enabled( $control ) {
	return $control->manager->get_setting( 'news_record_opinions_section_enable' )->value();
}
function news_record_if_opinions_category_source( $control ) {
	$type = $control->manager->get_setting( 'news_record_opinions_content_type' )->value();
	return news_record_if_opinions_enabled( $control ) && ( 'category' === $type );
}
function news_record_if_opinions_tag_source( $control ) {
	$type = $control->manager->get_setting( 'news_record_opinions_content_type' )->value();
	return news_record_if_opinions_enabled( $control ) && ( 'tag' === $type );
}

// Interviews.
function news_record_if_interviews_enabled( $control ) {
	return $control->manager->get_setting( 'news_record_interviews_section_enable' )->value();
}
function news_record_if_interviews_category_source( $control ) {
	$type = $control->manager->get_setting( 'news_record_interviews_content_type' )->value();
	return news_record_if_interviews_enabled( $control ) && ( 'category' === $type );
}
function news_record_if_interviews_tag_source( $control ) {
	$type = $control->manager->get_setting( 'news_record_interviews_content_type' )->value();
	return news_record_if_interviews_enabled( $control ) && ( 'tag' === $type );
}

// Spotlight.
function news_record_if_spotlight_enabled( $control ) {
	return $control->manager->get_setting( 'news_record_spotlight_section_enable' )->value();
}
function news_record_if_spotlight_category_source( $control ) {
	$type = $control->manager->get_setting( 'news_record_spotlight_content_type' )->value();
	return news_record_if_spotlight_enabled( $control ) && ( 'category' === $type );
}
function news_record_if_spotlight_tag_source( $control ) {
	$type = $control->manager->get_setting( 'news_record_spotlight_content_type' )->value();
	return news_record_if_spotlight_enabled( $control ) && ( 'tag' === $type );
}

// Sports.
function news_record_if_sports_enabled( $control ) {
	return $control->manager->get_setting( 'news_record_sports_section_enable' )->value();
}
function news_record_if_sports_category_source( $control ) {
	$type = $control->manager->get_setting( 'news_record_sports_content_type' )->value();
	return news_record_if_sports_enabled( $control ) && ( 'category' === $type );
}
function news_record_if_sports_tag_source( $control ) {
	$type = $control->manager->get_setting( 'news_record_sports_content_type' )->value();
	return news_record_if_sports_enabled( $control ) && ( 'tag' === $type );
}

// In-Depth.
function news_record_if_in_depth_enabled( $control ) {
	return $control->manager->get_setting( 'news_record_in_depth_section_enable' )->value();
}
function news_record_if_in_depth_category_source( $control ) {
	$type = $control->manager->get_setting( 'news_record_in_depth_content_type' )->value();
	return news_record_if_in_depth_enabled( $control ) && ( 'category' === $type );
}
function news_record_if_in_depth_tag_source( $control ) {
	$type = $control->manager->get_setting( 'news_record_in_depth_content_type' )->value();
	return news_record_if_in_depth_enabled( $control ) && ( 'tag' === $type );
}

// Technology.
function news_record_if_technology_enabled( $control ) {
	return $control->manager->get_setting( 'news_record_technology_section_enable' )->value();
}
function news_record_if_technology_category_source( $control ) {
	$type = $control->manager->get_setting( 'news_record_technology_content_type' )->value();
	return news_record_if_technology_enabled( $control ) && ( 'category' === $type );
}
function news_record_if_technology_tag_source( $control ) {
	$type = $control->manager->get_setting( 'news_record_technology_content_type' )->value();
	return news_record_if_technology_enabled( $control ) && ( 'tag' === $type );
}

// Featured Category.
function news_record_if_featured_category_enabled( $control ) {
	return $control->manager->get_setting( 'news_record_featured_category_section_enable' )->value();
}
function news_record_if_featured_category_category_source( $control ) {
	$type = $control->manager->get_setting( 'news_record_featured_category_content_type' )->value();
	return news_record_if_featured_category_enabled( $control ) && ( 'category' === $type );
}
function news_record_if_featured_category_tag_source( $control ) {
	$type = $control->manager->get_setting( 'news_record_featured_category_content_type' )->value();
	return news_record_if_featured_category_enabled( $control ) && ( 'tag' === $type );
}

// Entertainment.
function news_record_if_entertainment_enabled( $control ) {
	return $control->manager->get_setting( 'news_record_entertainment_section_enable' )->value();
}
function news_record_if_entertainment_category_source( $control ) {
	$type = $control->manager->get_setting( 'news_record_entertainment_content_type' )->value();
	return news_record_if_entertainment_enabled( $control ) && ( 'category' === $type );
}
function news_record_if_entertainment_tag_source( $control ) {
	$type = $control->manager->get_setting( 'news_record_entertainment_content_type' )->value();
	return news_record_if_entertainment_enabled( $control ) && ( 'tag' === $type );
}

// Business.
function news_record_if_business_enabled( $control ) {
	return $control->manager->get_setting( 'news_record_business_section_enable' )->value();
}
function news_record_if_business_category_source( $control ) {
	$type = $control->manager->get_setting( 'news_record_business_content_type' )->value();
	return news_record_if_business_enabled( $control ) && ( 'category' === $type );
}
function news_record_if_business_tag_source( $control ) {
	$type = $control->manager->get_setting( 'news_record_business_content_type' )->value();
	return news_record_if_business_enabled( $control ) && ( 'tag' === $type );
}
