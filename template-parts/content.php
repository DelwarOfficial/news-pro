<?php
/**
 * Template part for displaying archive posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package News Record
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'mb-8' ); ?>>
	<div class="single-card-container grid-card">
		<div class="single-card-image overflow-hidden rounded-lg">
			<?php news_record_post_thumbnail(); ?>
		</div>
		<div class="single-card-detail space-y-3">
			<?php
				if ( is_singular() ) :
					the_title( '<h1 class="entry-title text-2xl font-bold leading-tight">', '</h1>' );
				else :
					the_title( '<h2 class="card-title text-xl font-semibold leading-snug"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				endif;
				?>
			<div class="post-exerpt text-gray-700">
				<?php echo wp_kses_post( wp_trim_words( get_the_excerpt(), get_theme_mod( 'news_record_excerpt_length', 15 ) ) ); ?>
			</div><!-- post-exerpt -->
			<?php
			if ( 'post' === get_post_type() ) :
				?>
				<div class="card-meta text-sm text-gray-600 flex items-center gap-3">
					<?php
						news_record_posted_by();
						news_record_posted_on();
					?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
