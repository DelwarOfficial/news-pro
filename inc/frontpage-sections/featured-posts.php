<?php
/**
 * Frontpage Featured Posts Section.
 * Shows 1 large tile post on the left + 3 overlay cards on the right,
 * matching the Pro design layout exactly.
 *
 * @package News Record
 */

// Check if the section is enabled via Customizer.
$featured_posts_section = get_theme_mod( 'news_record_featured_posts_section_enable', false );

if ( false === $featured_posts_section ) {
	return;
}

$section_title = get_theme_mod( 'news_record_featured_posts_title', __( 'Featured Posts', 'news-record' ) );
$content_type  = get_theme_mod( 'news_record_featured_posts_content_type', 'recent' );
$content_ids   = array();

if ( 'post' === $content_type ) {
	// Manually selected posts — up to 4 (1 large + 3 small).
	for ( $i = 1; $i <= 4; $i++ ) {
		$post_id = get_theme_mod( 'news_record_featured_posts_post_' . $i );
		if ( ! empty( $post_id ) ) {
			$content_ids[] = absint( $post_id );
		}
	}

	$args = array(
		'post_type'           => 'post',
		'posts_per_page'      => 4,
		'ignore_sticky_posts' => true,
	);

	if ( ! empty( $content_ids ) ) {
		$args['post__in'] = $content_ids;
		$args['orderby']  = 'post__in';
	} else {
		$args['orderby'] = 'date';
	}
} elseif ( 'category' === $content_type ) {
	$cat_id = get_theme_mod( 'news_record_featured_posts_category' );
	$args   = array(
		'cat'            => absint( $cat_id ),
		'posts_per_page' => 4,
	);
} else {
	// Default: recent posts.
	$args = array(
		'post_type'           => 'post',
		'posts_per_page'      => 4,
		'ignore_sticky_posts' => true,
		'orderby'             => 'date',
	);
}

$query = new WP_Query( $args );

if ( ! $query->have_posts() ) {
	return;
}

// Collect posts into an array for easier layout control.
$posts = array();
while ( $query->have_posts() ) {
	$query->the_post();
	$posts[] = get_post();
}
wp_reset_postdata();

// Need at least 1 post to show the section.
if ( empty( $posts ) ) {
	return;
}
?>

<section id="news_record_featured_posts_section" class="featured-posts-section section-divider">
	<div class="site-container-width">

		<?php if ( ! empty( $section_title ) ) : ?>
			<div class="header-title">
				<h3 class="section-title"><?php echo esc_html( $section_title ); ?></h3>
			</div>
		<?php endif; ?>

		<div class="featured-posts-wrapper">

			<!-- Left: Large featured tile (first post) -->
			<?php if ( isset( $posts[0] ) ) :
				$large_post = $posts[0];
				setup_postdata( $large_post );
				?>
				<div class="fp-large-card">
					<div class="fp-large-image">
						<a href="<?php echo esc_url( get_permalink( $large_post->ID ) ); ?>">
							<?php if ( has_post_thumbnail( $large_post->ID ) ) : ?>
								<?php echo get_the_post_thumbnail( $large_post->ID, 'large' ); ?>
							<?php else : ?>
								<div class="fp-no-image"></div>
							<?php endif; ?>
						</a>
					</div>
					<div class="fp-large-detail">
						<!-- Category label -->
						<?php
						$cats = get_the_category( $large_post->ID );
						if ( $cats ) :
							$cat      = $cats[0];
							$color    = get_term_meta( $cat->term_id, 'news_record_custom_category_hue', true );
							$color    = $color ? $color : 'var(--theme-primary-hue)';
							?>
							<a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>"
							   class="fp-category"
							   style="background-color: <?php echo esc_attr( $color ); ?>;">
								<?php echo esc_html( $cat->name ); ?>
							</a>
						<?php endif; ?>
						<h3 class="fp-title">
							<a href="<?php echo esc_url( get_permalink( $large_post->ID ) ); ?>">
								<?php echo esc_html( get_the_title( $large_post->ID ) ); ?>
							</a>
						</h3>
						<div class="fp-meta">
							<span class="fp-author">
								<i class="fas fa-user"></i>
								<?php echo esc_html( get_the_author_meta( 'display_name', $large_post->post_author ) ); ?>
							</span>
							<span class="fp-date">
								<?php echo esc_html( human_time_diff( get_post_time( 'U', false, $large_post->ID ), current_time( 'timestamp' ) ) . ' ' . __( 'ago', 'news-record' ) ); ?>
							</span>
						</div>
					</div>
				</div>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>

			<!-- Right: 3 smaller overlay cards (posts 2, 3, 4) -->
			<div class="fp-small-cards">
				<?php
				$small_posts = array_slice( $posts, 1, 3 );
				foreach ( $small_posts as $small_post ) :
					setup_postdata( $small_post );
					$cats  = get_the_category( $small_post->ID );
					$color = 'var(--theme-primary-hue)';
					if ( $cats ) {
						$c     = get_term_meta( $cats[0]->term_id, 'news_record_custom_category_hue', true );
						$color = $c ? $c : $color;
					}
					?>
					<div class="fp-small-card">
						<!-- Background image -->
						<?php if ( has_post_thumbnail( $small_post->ID ) ) : ?>
							<div class="fp-small-bg" style="background-image: url(<?php echo esc_url( get_the_post_thumbnail_url( $small_post->ID, 'medium_large' ) ); ?>);"></div>
						<?php else : ?>
							<div class="fp-small-bg fp-small-bg--placeholder"></div>
						<?php endif; ?>
						<!-- Dark gradient overlay -->
						<div class="fp-small-overlay"></div>
						<!-- Content on top of image -->
						<div class="fp-small-detail">
							<?php if ( $cats ) : ?>
								<a href="<?php echo esc_url( get_category_link( $cats[0]->term_id ) ); ?>"
								   class="fp-category"
								   style="background-color: <?php echo esc_attr( $color ); ?>;">
									<?php echo esc_html( $cats[0]->name ); ?>
								</a>
							<?php endif; ?>
							<h4 class="fp-small-title">
								<a href="<?php echo esc_url( get_permalink( $small_post->ID ) ); ?>">
									<?php echo esc_html( get_the_title( $small_post->ID ) ); ?>
								</a>
							</h4>
							<div class="fp-meta">
								<span class="fp-author">
									<i class="fas fa-user"></i>
									<?php echo esc_html( get_the_author_meta( 'display_name', $small_post->post_author ) ); ?>
								</span>
								<span class="fp-date">
									<?php echo esc_html( human_time_diff( get_post_time( 'U', false, $small_post->ID ), current_time( 'timestamp' ) ) . ' ' . __( 'ago', 'news-record' ) ); ?>
								</span>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
				<?php wp_reset_postdata(); ?>
			</div><!-- .fp-small-cards -->

		</div><!-- .featured-posts-wrapper -->

	</div><!-- .site-container-width -->
</section><!-- #news_record_featured_posts_section -->
