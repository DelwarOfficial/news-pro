<?php
/**
 * Frontpage Posts Carousel Section.
 * Uses the Slick slider library (already enqueued) to display
 * posts in a horizontally scrolling overlay card carousel.
 *
 * @package News Record
 */

// Check if the section is enabled via Customizer.
$carousel_section = get_theme_mod( 'news_record_posts_carousel_section_enable', false );

if ( false === $carousel_section ) {
	return;
}

$section_title = get_theme_mod( 'news_record_posts_carousel_title', __( 'Posts Carousel', 'news-record' ) );
$content_type  = get_theme_mod( 'news_record_posts_carousel_content_type', 'recent' );
$content_ids   = array();

if ( 'post' === $content_type ) {
	for ( $i = 1; $i <= 9; $i++ ) {
		$post_id = get_theme_mod( 'news_record_posts_carousel_post_' . $i );
		if ( ! empty( $post_id ) ) {
			$content_ids[] = absint( $post_id );
		}
	}

	$args = array(
		'post_type'           => 'post',
		'posts_per_page'      => 9,
		'ignore_sticky_posts' => true,
	);

	if ( ! empty( $content_ids ) ) {
		$args['post__in'] = $content_ids;
		$args['orderby']  = 'post__in';
	} else {
		$args['orderby'] = 'date';
	}
} elseif ( 'category' === $content_type ) {
	$cat_id = get_theme_mod( 'news_record_posts_carousel_category' );
	$args   = array(
		'cat'            => absint( $cat_id ),
		'posts_per_page' => 9,
	);
} else {
	// Default: recent posts.
	$args = array(
		'post_type'           => 'post',
		'posts_per_page'      => 9,
		'ignore_sticky_posts' => true,
		'orderby'             => 'date',
	);
}

$query = new WP_Query( $args );

if ( ! $query->have_posts() ) {
	return;
}
?>

<section id="news_record_posts_carousel_section" class="posts-carousel-section section-divider">
	<div class="site-container-width">

		<?php if ( ! empty( $section_title ) ) : ?>
			<div class="header-title">
				<h3 class="section-title"><?php echo esc_html( $section_title ); ?></h3>
			</div>
		<?php endif; ?>

		<!-- Professional carousel container with enhanced styling -->
		<div class="posts-carousel-container">
			<!-- Slick slider wrapper with improved structure -->
			<div class="posts-carousel-slider news-record-slick-carousel">
				<?php while ( $query->have_posts() ) : $query->the_post(); ?>

					<div class="carousel-slide">
						<div class="carousel-card">
							<!-- Enhanced background image with better aspect ratio -->
							<?php if ( has_post_thumbnail() ) : ?>
								<div class="carousel-card-bg" style="background-image: url(<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'large' ) ); ?>);"></div>
							<?php else : ?>
								<div class="carousel-card-bg carousel-card-bg--placeholder"></div>
							<?php endif; ?>

							<!-- Sophisticated gradient overlay with multiple layers -->
							<div class="carousel-card-overlay">
								<div class="carousel-card-overlay-primary"></div>
								<div class="carousel-card-overlay-secondary"></div>
							</div>

							<!-- Professional content layout (desktop bottom-left style) -->
							<div class="carousel-card-content">
								<div class="carousel-card-category">
									<?php news_record_categories_list(); ?>
								</div>

								<div class="carousel-card-detail">
									<h3 class="carousel-card-title">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h3>

									<div class="carousel-card-meta">
										<div class="carousel-meta-item">
											<?php news_record_posted_by(); ?>
										</div>
										<div class="carousel-meta-separator">•</div>
										<div class="carousel-meta-item">
											<?php news_record_posted_on(); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div><!-- .carousel-slide -->

				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
			</div><!-- .posts-carousel-slider -->

			<!-- Professional navigation indicators -->
			<div class="carousel-navigation">
				<div class="carousel-dots"></div>
			</div>
		</div><!-- .posts-carousel-container -->

	</div><!-- .site-container-width -->
</section><!-- #news_record_posts_carousel_section -->
