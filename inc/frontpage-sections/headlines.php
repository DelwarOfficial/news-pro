<?php
/**
 * Frontpage Headlines Section.
 * Displays the latest news headlines in a numbered list format.
 *
 * @package News Record
 */

// Check if enabled in Customizer.
$headlines_section = get_theme_mod( 'news_record_headlines_section_enable', false );

if ( false === $headlines_section ) {
	return;
}

$section_title = get_theme_mod( 'news_record_headlines_title', __( 'Headlines', 'news-record' ) );
$content_type  = get_theme_mod( 'news_record_headlines_content_type', 'recent' );
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
		'posts_per_page'      => 6,
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
		'posts_per_page'      => 6,
		'ignore_sticky_posts' => true,
		'orderby'             => 'date',
	);
}

$query = new WP_Query( $args );
if ( ! $query->have_posts() ) {
	return;
}
?>

<section id="news_record_headlines_section" class="headlines-section section-divider">
	<div class="site-container-width">

		<?php if ( ! empty( $section_title ) ) : ?>
			<div class="header-title">
				<h3 class="section-title"><?php echo esc_html( $section_title ); ?></h3>
			</div>
		<?php endif; ?>

		<ul class="headlines-list">
			<?php $index = 1; while ( $query->have_posts() ) : $query->the_post(); ?>
				<li class="headline-item">
					<span class="headline-number"><?php echo esc_html( sprintf( '%02d', $index ) ); ?></span>
					<a class="headline-link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					<span class="headline-meta"><?php news_record_posted_on(); ?></span>
				</li>
				<?php $index++; endwhile; ?>
			<?php wp_reset_postdata(); ?>
		</ul>

	</div>
</section>
