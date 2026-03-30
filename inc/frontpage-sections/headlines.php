<?php
/**
 * Frontpage Headlines Section.
 * Displays news headlines in a 2-column overlay-card layout.
 *
 * @package News Record
 */

// Check if enabled in Customizer.
$headlines_section = get_theme_mod( 'news_record_headlines_section_enable', false );

if ( false === $headlines_section ) {
	return;
}

$section_title = get_theme_mod( 'news_record_headlines_title', esc_html__( 'Headlines', 'news-record' ) );
$content_type  = get_theme_mod( 'news_record_headlines_content_type', 'recent' );
$post_count    = get_theme_mod( 'news_record_headlines_post_count', 6 );
$content_ids   = array();

if ( 'post' === $content_type ) {
	for ( $i = 1; $i <= 6; $i++ ) {
		$post_id = get_theme_mod( 'news_record_headlines_post_' . $i );
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
	$cat_id = get_theme_mod( 'news_record_headlines_category' );
	$args   = array(
		'cat'            => absint( $cat_id ),
		'posts_per_page' => 6,
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

$posts         = $query->posts;
$featured_post = isset( $posts[0] ) ? $posts[0] : null;
$grid_posts    = array_slice( $posts, 1, max( 0, absint( $post_count ) - 1 ) );
?>

<section id="news_record_headlines_section" class="headlines-section section-divider">
	<div class="site-container-width">

		<?php if ( ! empty( $section_title ) ) : ?>
			<div class="header-title">
				<h3 class="section-title"><?php echo esc_html( $section_title ); ?></h3>
			</div>
		<?php endif; ?>

		<div class="headlines-overlay-grid">
			<?php if ( $featured_post ) : ?>
				<div class="headlines-featured">
					<article class="overlay-card featured-card">
						<a href="<?php echo esc_url( get_permalink( $featured_post->ID ) ); ?>" class="overlay-card-link">
							<?php if ( has_post_thumbnail( $featured_post->ID ) ) : ?>
								<div class="overlay-card-image">
									<?php echo get_the_post_thumbnail( $featured_post->ID, 'large', array( 'class' => 'featured-img' ) ); ?>
								</div>
							<?php endif; ?>
							<div class="overlay-card-content">
								<?php
								$featured_cats = get_the_category( $featured_post->ID );
								if ( ! empty( $featured_cats ) && ! is_wp_error( $featured_cats ) ) {
									echo '<span class="overlay-card-category">' . esc_html( $featured_cats[0]->name ) . '</span>';
								}
								?>
								<h2 class="overlay-card-title"><?php echo esc_html( get_the_title( $featured_post->ID ) ); ?></h2>
								<span class="overlay-card-date"><?php echo esc_html( get_the_date( '', $featured_post->ID ) ); ?></span>
							</div>
						</a>
					</article>
				</div>
			<?php endif; ?>

			<div class="headlines-grid">
				<?php foreach ( $grid_posts as $post ) : setup_postdata( $post ); ?>
					<article class="overlay-card grid-card">
						<a href="<?php the_permalink(); ?>" class="overlay-card-link">
							<?php if ( has_post_thumbnail() ) : ?>
								<div class="overlay-card-image">
									<?php the_post_thumbnail( 'medium', array( 'class' => 'grid-img' ) ); ?>
								</div>
							<?php endif; ?>
							<div class="overlay-card-content">
								<?php
								$grid_cats = get_the_category();
								if ( ! empty( $grid_cats ) && ! is_wp_error( $grid_cats ) ) {
									echo '<span class="overlay-card-category">' . esc_html( $grid_cats[0]->name ) . '</span>';
								}
								?>
								<h3 class="overlay-card-title"><?php the_title(); ?></h3>
								<span class="overlay-card-date"><?php echo esc_html( get_the_date() ); ?></span>
							</div>
						</a>
					</article>
				<?php endforeach; wp_reset_postdata(); ?>
			</div>
		</div>

	</div>
</section>
