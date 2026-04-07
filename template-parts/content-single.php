<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package News Record
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'prose max-w-none' ); ?>>

	<div class="single-page space-y-4">
			<div class="page-header-content space-y-3">
				<?php if ( is_singular() ) : ?>
					<header class="entry-header">
						<?php the_title( '<h1 class="entry-title text-3xl font-bold leading-tight">', '</h1>' ); ?>
					</header><!-- .entry-header -->
					<?php
					if ( 'post' === get_post_type() ) :
						setup_postdata( get_post() );
						?>
						<ul class="entry-meta flex items-center gap-4 text-sm text-gray-600">
							<?php
								news_record_posted_by();
								news_record_posted_on();
							?>
						</ul><!-- .entry-meta -->
						<?php
					endif;
				endif;
				?>

				<?php
				if ( has_excerpt() ) {
					echo '<div class="text-gray-700">' . wp_kses_post( get_the_excerpt() ) . '</div>';
				}
				?>
			</div>
		<div class="overflow-hidden rounded-xl"><?php news_record_post_thumbnail(); ?></div>
	</div>

	<div class="entry-content">
		<?php
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'news-record' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			)
		);
		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'news-record' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->
	<footer class="entry-footer">
		<?php news_record_entry_footer(); ?>
	</footer><!-- .entry-footer -->
	<div class="single-content-wrap">
	</div>

</article><!-- #post-<?php the_ID(); ?> -->
