<?php
/**
 * Travel Category Section
 *
 * Displays posts from the Travel category using the reusable category-section engine.
 *
 * @package News Record
 */

$section_title = __( 'Travel', 'news-record' );
$category      = 'travel'; // Category slug
$layout        = 'mixed-grid'; // Layout mode: mixed grid with varied sizes
$post_count    = 6; // 6 posts in mixed grid
$columns       = 3;
$show_meta     = true;
$show_excerpt  = false;
$sidebar_mode  = 'none';

require get_template_directory() . '/inc/frontpage-sections/category-section.php';
