<?php

/**
 * Shared card render helpers for new sections/widgets.
 *
 * @package News Record
 */

if ( ! function_exists( 'news_record_primary_category_name' ) ) {
	/**
	 * Return the first category name for a post.
	 *
	 * @param int|null $post_id Post ID.
	 * @return string
	 */
	function news_record_primary_category_name( $post_id = null ) {
		$cats = get_the_category( $post_id );
		if ( empty( $cats ) || is_wp_error( $cats ) ) {
			return '';
		}
		return $cats[0]->name;
	}
}

if ( ! function_exists( 'news_record_render_numbered_item' ) ) {
	/**
	 * Echo a numbered list item card.
	 *
	 * @param WP_Post $post  Post object.
	 * @param int     $index Zero-based index.
	 */
	function news_record_render_numbered_item( $post, $index ) {
		$position = $index + 1;
		$title    = get_the_title( $post );
		$link     = get_permalink( $post );
		$cat      = news_record_primary_category_name( $post->ID );
		$date     = get_the_date( '', $post );
		?>
		<li class="numbered-item">
			<span class="numbered-rank"><?php echo esc_html( $position ); ?></span>
			<div class="numbered-meta">
				<?php if ( has_post_thumbnail( $post ) ) : ?>
					<a class="thumb" href="<?php echo esc_url( $link ); ?>">
						<?php echo get_the_post_thumbnail( $post, 'thumbnail' ); ?>
					</a>
				<?php endif; ?>
				<div class="numbered-text">
					<?php if ( $cat ) : ?>
						<span class="numbered-cat"><?php echo esc_html( $cat ); ?></span>
					<?php endif; ?>
					<h4 class="numbered-title"><a href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $title ); ?></a></h4>
					<span class="numbered-date"><?php echo esc_html( $date ); ?></span>
				</div>
			</div>
		</li>
		<?php
	}
}

if ( ! function_exists( 'news_record_render_gallery_thumb' ) ) {
	/**
	 * Echo a gallery thumb item.
	 *
	 * @param WP_Post $post Post object.
	 */
	function news_record_render_gallery_thumb( $post ) {
		$link = get_permalink( $post );
		?>
		<article class="gallery-thumb">
			<a href="<?php echo esc_url( $link ); ?>" class="gallery-thumb-link">
				<?php if ( has_post_thumbnail( $post ) ) : ?>
					<span class="gallery-thumb-image"><?php echo get_the_post_thumbnail( $post, 'medium' ); ?></span>
				<?php endif; ?>
				<span class="gallery-thumb-title"><?php echo esc_html( get_the_title( $post ) ); ?></span>
			</a>
		</article>
		<?php
	}
}
