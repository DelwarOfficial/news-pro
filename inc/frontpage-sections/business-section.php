<?php
/**
 * Business Category Section
 *
 * Displays posts from the Business category using the reusable category-section engine.
 *
 * @package News Record
 */

$section_title = __( 'Business', 'news-record' );
$category      = 'business'; // Category slug
$layout        = 'vertical'; // Layout mode: vertical list
$post_count    = 4; // 4 posts in vertical list
$columns       = 1;
$show_meta     = true;
$show_excerpt  = true;
$sidebar_mode  = 'none';

require get_template_directory() . '/inc/frontpage-sections/category-section.php';
