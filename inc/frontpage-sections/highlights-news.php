<?php
/**
 * Frontpage Highlights News Section.
 *
 * @package News Record
 */

// Highlights News Section.
$highlights_news_section = get_theme_mod( 'news_record_highlights_news_section_enable', false );

if ( false === $highlights_news_section ) {
	return;
}

$content_ids                  = $section_content = array();
$highlights_news_content_type = get_theme_mod( 'news_record_highlights_news_content_type', 'post' );

if ( $highlights_news_content_type === 'post' ) {

	for ( $i = 1; $i <= 6; $i++ ) {
		$post_id = get_theme_mod( 'news_record_highlights_news_post_' . $i );
		if ( ! empty( $post_id ) ) {
			$content_ids[] = absint( $post_id );
		}
	}

	$args = array(
		'post_type'           => 'post',
		'posts_per_page'      => absint( 6 ),
		'ignore_sticky_posts' => true,
	);
	if ( ! empty( $content_ids ) ) {
		$args['post__in'] = $content_ids;
		$args['orderby']  = 'post__in';
	} else {
		$args['orderby'] = 'date';
	}
} else {
	$cat_content_id = get_theme_mod( 'news_record_highlights_news_category' );
	$args           = array(
		'cat'            => $cat_content_id,
		'posts_per_page' => absint( 6 ),
	);
}

$query = new WP_Query( $args );
if ( $query->have_posts() ) :
	$section_title    = get_theme_mod( 'news_record_highlights_news_title', __( 'Highlights News', 'news-record' ) );
	?>
	<div id="news_record_highlights_news_section" class="news-highlights">
		<div class="news-highlights-container">
			<?php if ( ! empty( $section_title ) ) : ?>
				<span class="news-highlights-icon">
					<span class="highlights-title"><?php echo esc_html( $section_title ); ?></span>
					<span class="highlights-icon"></span>
				</span>
			<?php endif; ?>
			<div class="js-conveyor">
				<ul>
					<?php
					while ( $query->have_posts() ) :
						$query->the_post();
						?>
						<li>
							<div class="highlights-content">
								<?php if ( has_post_thumbnail() ) { ?>
									<div class="content-img">
										<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( array( 40, 40 ) ); ?></a>
									</div>
								<?php } ?>
								<div class="content-title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</div>
							</div>
						</li>
						<?php
					endwhile;
					wp_reset_postdata();
					?>
				</ul>
			</div>
		</div>
	</div>
	<?php
endif;
