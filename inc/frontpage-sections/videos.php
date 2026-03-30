<?php
/**
 * Frontpage Videos Section.
 * Displays a modern videos block with poster image / play overlay.
 *
 * @package News Record
 */

// Check if the section is enabled via Customizer.
$videos_section = get_theme_mod( 'news_record_videos_section_enable', false );

if ( false === $videos_section ) {
	return;
}

$section_title = get_theme_mod( 'news_record_videos_title', __( 'Videos', 'news-record' ) );
$content_type  = get_theme_mod( 'news_record_videos_content_type', 'recent' );
$post_count    = get_theme_mod( 'news_record_videos_post_count', 6 );
$content_ids   = array();

if ( 'post' === $content_type ) {
	for ( $i = 1; $i <= 6; $i++ ) {
		$post_id = get_theme_mod( 'news_record_videos_post_' . $i );
		if ( ! empty( $post_id ) ) {
			$content_ids[] = absint( $post_id );
		}
	}

	$args = array(
		'post_type'           => 'post',
		'posts_per_page'      => absint( $post_count ),
		'ignore_sticky_posts' => true,
	);

	if ( ! empty( $content_ids ) ) {
		$args['post__in'] = $content_ids;
		$args['orderby']  = 'post__in';
	} else {
		$args['orderby'] = 'date';
	}
} elseif ( 'category' === $content_type ) {
	$cat_id = get_theme_mod( 'news_record_videos_category' );
	$args   = array(
		'cat'            => absint( $cat_id ),
		'posts_per_page' => absint( $post_count ),
	);
} else {
	$args = array(
		'post_type'           => 'post',
		'posts_per_page'      => absint( $post_count ),
		'ignore_sticky_posts' => true,
		'orderby'             => 'date',
	);
}

$query = new WP_Query( $args );

if ( ! $query->have_posts() ) {
	return;
}
?>

<section id="news_record_videos_section" class="videos-section section-divider">
	<div class="site-container-width">

		<?php if ( ! empty( $section_title ) ) : ?>
			<div class="header-title">
				<h3 class="section-title"><?php echo esc_html( $section_title ); ?></h3>
			</div>
		<?php endif; ?>

		<div class="videos-grid">
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				<div class="video-card">
					<a href="<?php the_permalink(); ?>" class="video-card-link">
						<div class="video-card-thumb">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'medium_large' ); ?>
							<?php else : ?>
								<div class="video-thumb-placeholder"></div>
							<?php endif; ?>
							<div class="video-play-button">
								<i class="fas fa-play"></i>
							</div>
						</div>
						<div class="video-card-detail">
							<div class="video-card-meta">
								<?php news_record_categories_list(); ?>
								<span><?php news_record_posted_on(); ?></span>
							</div>
							<h4 class="video-card-title"><?php the_title(); ?></h4>
						</div>
					</a>
				</div>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		</div>

	</div>
</section>
