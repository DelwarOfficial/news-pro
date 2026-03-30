<?php
/**
 * Frontpage Editor Choice Section.
 * Displays a 3-column grid of hand-picked posts with image, category, and title.
 *
 * @package News Record
 */

// Check if the section is enabled via Customizer.
$editor_choice_section = get_theme_mod( 'news_record_editor_choice_section_enable', false );

if ( false === $editor_choice_section ) {
	return;
}

$section_title   = get_theme_mod( 'news_record_editor_choice_title', __( 'Editor Choice', 'news-record' ) );
$content_type    = get_theme_mod( 'news_record_editor_choice_content_type', 'recent' );
$post_count      = get_theme_mod( 'news_record_editor_choice_post_count', 6 );
$content_ids     = array();

if ( 'post' === $content_type ) {
	// Get manually selected posts (up to 6).
	for ( $i = 1; $i <= 6; $i++ ) {
		$post_id = get_theme_mod( 'news_record_editor_choice_post_' . $i );
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
	// Get posts from a selected category.
	$cat_id = get_theme_mod( 'news_record_editor_choice_category' );
	$args   = array(
		'cat'            => absint( $cat_id ),
		'posts_per_page' => absint( $post_count ),
	);
} else {
	// Default: most recent 6 posts.
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

<section id="news_record_editor_choice_section" class="editor-choice-section section-divider">
	<div class="site-container-width">

		<?php if ( ! empty( $section_title ) ) : ?>
			<div class="header-title">
				<h3 class="section-title"><?php echo esc_html( $section_title ); ?></h3>
			</div>
		<?php endif; ?>

		<div class="editor-choice-grid">
			<?php
			$count = 0;
			while ( $query->have_posts() ) :
				$query->the_post();
				$count++;

				// First post gets a larger "featured" card style.
				$card_class = ( 1 === $count ) ? 'ec-card ec-card--featured' : 'ec-card ec-card--normal';
				?>

				<div class="<?php echo esc_attr( $card_class ); ?>">
					<!-- Post thumbnail link -->
					<div class="ec-card-image">
						<a href="<?php the_permalink(); ?>">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'large' ); ?>
							<?php else : ?>
								<!-- Fallback placeholder when no image is set -->
								<div class="ec-card-no-image"></div>
							<?php endif; ?>
						</a>
					</div>

					<!-- Card content overlay / below -->
					<div class="ec-card-detail">
						<?php news_record_categories_list(); ?>
						<h3 class="ec-card-title">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h3>
						<div class="ec-card-meta">
							<?php news_record_posted_by(); ?>
							<?php news_record_posted_on(); ?>
						</div>
					</div>
				</div><!-- .ec-card -->

			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		</div><!-- .editor-choice-grid -->

	</div><!-- .site-container-width -->
</section><!-- #news_record_editor_choice_section -->
