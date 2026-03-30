<?php
/**
 * Lifestyle Category Section
 *
 * Displays posts from the Lifestyle category using the reusable category-section engine.
 * Configurable via Theme Customizer > Frontpage Sections > Lifestyle Section.
 *
 * @package News Record
 */

// Check if the section is enabled via Customizer.
$lifestyle_section_enable = get_theme_mod( 'news_record_lifestyle_section_enable', false );

if ( ! $lifestyle_section_enable ) {
	return;
}

$section_title = get_theme_mod( 'news_record_lifestyle_title', esc_html__( 'Lifestyle', 'news-record' ) );
$category      = get_theme_mod( 'news_record_lifestyle_category', 'lifestyle' );
$tag           = get_theme_mod( 'news_record_lifestyle_tag', '' );
$content_type  = get_theme_mod( 'news_record_lifestyle_content_type', 'category' );
$post_count    = get_theme_mod( 'news_record_lifestyle_post_count', 6 );
$layout        = 'three-col';
$columns       = 3;
$show_meta     = true;
$show_excerpt  = false;
$sidebar_mode  = 'none';

?>
<style>
/* Reverse Layout & Square Image Ratio for Lifestyle Section */
#news_record_category_<?php echo esc_attr( sanitize_title( $layout . '-' . $category ) ); ?> .list-card {
	flex-direction: row-reverse;
	align-items: center; /* Prevents vertical stretching */
}
#news_record_category_<?php echo esc_attr( sanitize_title( $layout . '-' . $category ) ); ?> .list-card .single-card-image {
	width: 35%; /* Slightly wider to maintain healthy ratio in 3-col */
}
#news_record_category_<?php echo esc_attr( sanitize_title( $layout . '-' . $category ) ); ?> .list-card .single-card-image > a img {
	aspect-ratio: 1 / 1; /* Smart perfect square */
	object-fit: cover;
}
</style>
<?php


require get_template_directory() . '/inc/frontpage-sections/category-section.php';
