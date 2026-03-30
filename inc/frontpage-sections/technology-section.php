<?php
/**
 * Technology Category Section
 *
 * Displays posts from the Technology category using the reusable category-section engine.
 *
 * @package News Record
 */

$section_title = __( 'Technology', 'news-record' );
$category      = 'technology'; // Category slug
$layout        = 'spotlight'; // Layout mode: spotlight (1 large + sidebar list)
$post_count    = 5; // 1 spotlight + 4 sidebar items
$columns       = 1;
$show_meta     = true;
$show_excerpt  = true;
$sidebar_mode  = 'list';

require get_template_directory() . '/inc/frontpage-sections/category-section.php';
