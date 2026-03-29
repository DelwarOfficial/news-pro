<?php
/**
 * Frontpage Banner Section.
 *
 * @package News Record
 */

// Banner Section.
$banner_section = get_theme_mod( 'news_record_banner_section_enable', true );

if ( false === $banner_section ) {
	return;
}

$daily_news_content_ids    = $banner_posts_content_ids = $top_stories_content_ids = array();
$daily_news_content_type   = get_theme_mod( 'news_record_daily_news_content_type', 'post' );
$banner_posts_content_type = get_theme_mod( 'news_record_banner_posts_content_type', 'post' );
$top_stories_content_type  = get_theme_mod( 'news_record_banner_top_stories_content_type', 'post' );

if ( $daily_news_content_type === 'post' ) {

	for ( $i = 1; $i <= 3; $i++ ) {
		$post_id = get_theme_mod( 'news_record_daily_news_post_' . $i );
		if ( ! empty( $post_id ) ) {
			$daily_news_content_ids[] = absint( $post_id );
		}
	}

	$daily_news_args = array(
		'post_type'           => 'post',
		'posts_per_page'      => absint( 3 ),
		'ignore_sticky_posts' => true,
	);
	if ( ! empty( $daily_news_content_ids ) ) {
		$daily_news_args['post__in'] = $daily_news_content_ids;
		$daily_news_args['orderby']  = 'post__in';
	} else {
		$daily_news_args['orderby'] = 'date';
	}

} else {
	$cat_content_id  = get_theme_mod( 'news_record_daily_news_category' );
	$daily_news_args = array(
		'cat'            => $cat_content_id,
		'posts_per_page' => absint( 3 ),
	);
}

if ( $banner_posts_content_type === 'post' ) {

	for ( $i = 1; $i <= 3; $i++ ) {
		$post_id = get_theme_mod( 'news_record_banner_posts_post_' . $i );
		if ( ! empty( $post_id ) ) {
			$banner_posts_content_ids[] = absint( $post_id );
		}
	}

	$banner_posts_args = array(
		'post_type'           => 'post',
		'posts_per_page'      => absint( 3 ),
		'ignore_sticky_posts' => true,
	);
	if ( ! empty( $banner_posts_content_ids ) ) {
		$banner_posts_args['post__in'] = $banner_posts_content_ids;
		$banner_posts_args['orderby']  = 'post__in';
	} else {
		$banner_posts_args['orderby'] = 'date';
	}

} else {
	$cat_content_id    = get_theme_mod( 'news_record_banner_posts_category' );
	$banner_posts_args = array(
		'cat'            => $cat_content_id,
		'posts_per_page' => absint( 3 ),
	);
}

if ( $top_stories_content_type === 'post' ) {

	for ( $i = 1; $i <= 6; $i++ ) {
		$post_id = get_theme_mod( 'news_record_banner_top_stories_post_' . $i );
		if ( ! empty( $post_id ) ) {
			$top_stories_content_ids[] = absint( $post_id );
		}
	}

	$top_stories_args = array(
		'post_type'           => 'post',
		'posts_per_page'      => absint( 6 ),
		'ignore_sticky_posts' => true,
	);
	if ( ! empty( $top_stories_content_ids ) ) {
		$top_stories_args['post__in'] = $top_stories_content_ids;
		$top_stories_args['orderby']  = 'post__in';
	} else {
		$top_stories_args['orderby'] = 'date';
	}

} else {
	$cat_content_id   = get_theme_mod( 'news_record_banner_top_stories_category' );
	$top_stories_args = array(
		'cat'            => $cat_content_id,
		'posts_per_page' => absint( 6 ),
	);
}

?>

<section id="news_record_banner_section" class="banner-section banner-layout-2">
	<div class="site-container-width">
		<div class="banner-section-wrapper">
			
			<?php
			require get_template_directory() . '/inc/frontpage-sections/banner/banner-posts.php';
			require get_template_directory() . '/inc/frontpage-sections/banner/daily-news.php';
			require get_template_directory() . '/inc/frontpage-sections/banner/top-stories.php';
			?>
			
		</div>
	</div>
</section>