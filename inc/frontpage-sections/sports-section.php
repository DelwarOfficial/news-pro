<?php
/**
 * Sports Category Section
 *
 * Displays posts from the Sports category using the reusable category-section engine.
 *
 * @package News Record
 */

$section_title = __( 'Sports', 'news-record' );
$category      = 'sports'; // Category slug
$layout        = 'two-col'; // Layout mode: two-column grid
$post_count    = 4; // 4 posts in 2 columns
$columns       = 2;
$show_meta     = true;
$show_excerpt  = true;
$sidebar_mode  = 'none';

require get_template_directory() . '/inc/frontpage-sections/category-section.php';
