<?php

// Home Page Customizer panel.
$wp_customize->add_panel(
	'news_record_frontpage_panel',
	array(
		'title'    => esc_html__( 'Frontpage Sections', 'news-record' ),
		'priority' => 140,
	)
);

// Existing sections.
$customizer_settings = array( 'highlights-news', 'banner', 'recent-articles' );

foreach ( $customizer_settings as $customizer ) {

	require get_template_directory() . '/inc/customizer-settings/frontpage-customizer/' . $customizer . '.php';

}

// New Pro sections (categories, editor choice, featured posts, carousel).
require get_template_directory() . '/inc/customizer-settings/frontpage-customizer/new-sections.php';
