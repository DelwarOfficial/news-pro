<?php
/**
 * Entertainment Category Section
 *
 * Displays posts from the Entertainment category using the reusable category-section engine.
 *
 * @package News Record
 */

$section_title = __( 'Entertainment', 'news-record' );
$category      = 'entertainment'; // Category slug
$layout        = 'two-col'; // Layout mode: two-column grid
$post_count    = 6; // 6 posts in 2 columns
$columns       = 2;
$show_meta     = true;
$show_excerpt  = true;
$sidebar_mode  = 'none';

require get_template_directory() . '/inc/frontpage-sections/category-section.php';
