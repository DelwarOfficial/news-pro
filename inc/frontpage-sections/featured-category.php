<?php
/**
 * Featured Category Section
 *
 * Displays posts from the Featured category using the reusable category-section engine.
 *
 * @package News Record
 */

$section_title = __( 'Featured', 'news-record' );
$category      = 'featured'; // Category slug
$layout        = 'tile-list'; // Layout mode: tile-list
$post_count    = 5; // 1 tile + 4 list cards
$columns       = 1;
$show_meta     = true;
$show_excerpt  = false;
$sidebar_mode  = 'none';

require get_template_directory() . '/inc/frontpage-sections/category-section.php';
