<?php
/**
 * Frontpage Recent Articles Section.
 *
 * @package News Record
 */

// Recent Articles Section.
$recent_articles_section = get_theme_mod( 'news_record_recent_articles_section_enable', false );

if ( false === $recent_articles_section ) {
	return;
}

$content_ids                  = array();
$recent_articles_content_type = get_theme_mod( 'news_record_recent_articles_content_type', 'recent' );
$recent_articles_category     = get_theme_mod( 'news_record_recent_articles_category', '' );
$recent_articles_tag          = get_theme_mod( 'news_record_recent_articles_tag', '' );

if ( $recent_articles_content_type === 'post' ) {

	for ( $i = 1; $i <= 5; $i++ ) {
		$post_id = get_theme_mod( 'news_record_recent_articles_post_' . $i );
		if ( ! empty( $post_id ) ) {
			$content_ids[] = absint( $post_id );
		}
	}

	$args = array(
		'post_type'           => 'post',
		'posts_per_page'      => absint( 5 ),
		'ignore_sticky_posts' => true,
	);
	if ( ! empty( $content_ids ) ) {
		$args['post__in'] = $content_ids;
		$args['orderby']  = 'post__in';
	} else {
		$args['orderby'] = 'date';
	}
} elseif ( $recent_articles_content_type === 'recent' ) {
	$args = array(
		'post_type'           => 'post',
		'posts_per_page'      => absint( 5 ),
		'ignore_sticky_posts' => true,
	);
} elseif ( 'category' === $recent_articles_content_type ) {
	$args = array(
		'post_type'           => 'post',
		'posts_per_page'      => absint( 5 ),
		'ignore_sticky_posts' => true,
	);
	if ( ! empty( $recent_articles_category ) ) {
		if ( is_numeric( $recent_articles_category ) ) {
			$args['cat'] = absint( $recent_articles_category );
		} else {
			$args['category_name'] = sanitize_text_field( $recent_articles_category );
		}
	}
} elseif ( 'tag' === $recent_articles_content_type ) {
	$args = array(
		'post_type'           => 'post',
		'posts_per_page'      => absint( 5 ),
		'ignore_sticky_posts' => true,
	);
	if ( ! empty( $recent_articles_tag ) ) {
		$args['tag'] = sanitize_text_field( $recent_articles_tag );
	}
}

$query = new WP_Query( $args );
if ( $query->have_posts() ) {
	$section_title = get_theme_mod( 'news_record_recent_articles_title', __( 'Recent Articles', 'news-record' ) );
	?>
	<section id="news_record_recent_articles_section" class="recent-articles section-divider recent-layout-2">
		<div class="site-container-width">
			<?php if ( ! empty( $section_title ) ) : ?>
				<div class="header-title">
					<h3 class="section-title"><?php echo esc_html( $section_title ); ?></h3>
				</div>
			<?php endif; ?>
			<div class="container-wrap">
				<?php
				$i = 1;
				while ( $query->have_posts() ) :
					$query->the_post();
					?>
					<div class="single-card-container <?php echo esc_attr( $i === 1 ? 'tile-card' : 'list-card' ); ?>">
						<div class="single-card-image">
							<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
						</div>
						<div class="single-card-detail">
							<?php news_record_categories_list(); ?>
							<h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<div class="card-meta">
								<?php
									news_record_posted_by();
									news_record_posted_on();
								?>
							</div>
						</div>
					</div>
					<?php
					$i++;
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</div>
	</section>

	<?php
}
