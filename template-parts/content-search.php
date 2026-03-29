<?php
/**
 * Template part for displaying posts search
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package News Record
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="single-card-container grid-card">
		<div class="single-card-image">
			<?php news_record_post_thumbnail(); ?>
		</div>
		<div class="single-card-detail">
			<?php news_record_categories_list(); ?>
			<?php
				if ( is_singular() ) :
					the_title( '<h1 class="entry-title">', '</h1>' );
				else :
					the_title( '<h2 class="card-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				endif;
			?>
			<div class="post-exerpt">
				<?php echo wp_kses_post( wp_trim_words( get_the_excerpt(), get_theme_mod( 'news_record_excerpt_length', 15 ) ) ); ?>
			</div><!-- post-exerpt -->
			<?php
			if ( 'post' === get_post_type() ) :
				?>
				<div class="card-meta">
					<?php
						news_record_posted_by();
						news_record_posted_on();
					?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
