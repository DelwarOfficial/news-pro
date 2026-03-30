<?php
/**
 * Tri-Column Category Section
 *
 * Displays up to 3 columns of categorized posts in a grid.
 * Configurable via Theme Customizer > Frontpage Sections > Default Layout 3 Column.
 *
 * @package News Record
 */

// Check if the section is enabled via Customizer.
$tri_col_section_enable = get_theme_mod( 'news_record_tri_col_section_enable', false );

if ( ! $tri_col_section_enable ) {
	return;
}

?>
<section id="news_record_tri_col_section" class="category-section tri-column-section section-divider">
	<div class="site-container-width">
		<div class="tri-col-grid">
			<?php
			for ( $col = 1; $col <= 3; $col++ ) {
				$section_title = get_theme_mod( 'news_record_tri_col_' . $col . '_title', 'Column ' . $col );
				$content_type  = get_theme_mod( 'news_record_tri_col_' . $col . '_content_type', 'recent' );
				$post_count    = get_theme_mod( 'news_record_tri_col_' . $col . '_post_count', 4 );
				$category      = get_theme_mod( 'news_record_tri_col_' . $col . '_category', '' );
				$tag           = get_theme_mod( 'news_record_tri_col_' . $col . '_tag', '' );

				$args = array(
					'post_type'           => 'post',
					'posts_per_page'      => absint( $post_count ),
					'ignore_sticky_posts' => true,
				);

				if ( 'category' === $content_type && ! empty( $category ) ) {
					$args['cat'] = absint( $category );
				} elseif ( 'tag' === $content_type && ! empty( $tag ) ) {
					$args['tag'] = sanitize_text_field( $tag );
				}

				$query = new WP_Query( $args );

				?>
				<div class="tri-col-column" id="news_record_tri_col_<?php echo esc_attr( $col ); ?>">
					
					<?php if ( ! empty( $section_title ) ) : ?>
						<div class="header-title">
							<h3 class="section-title">
								<?php if ( 'category' === $content_type && ! empty( $category ) ) : ?>
									<a href="<?php echo esc_url( get_category_link( absint( $category ) ) ); ?>"><?php echo esc_html( $section_title ); ?></a>
								<?php else : ?>
									<?php echo esc_html( $section_title ); ?>
								<?php endif; ?>
							</h3>
						</div>
					<?php endif; ?>

					<?php if ( $query->have_posts() ) : ?>
						<div class="tri-col-posts-wrapper">
							<?php
							$index = 0;
							while ( $query->have_posts() ) :
								$query->the_post();
								$card_class = ( 0 === $index ) ? 'tile-card' : 'list-card';
								?>
								<div class="single-card-container <?php echo esc_attr( $card_class ); ?>">
									<div class="single-card-image">
										<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 0 === $index ? 'large' : 'medium' ); ?></a>
									</div>
									<div class="single-card-detail">
										<?php news_record_categories_list(); ?>
										<div class="card-meta">
											<?php news_record_posted_on(); ?>
										</div>
										<h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
									</div>
								</div>
								<?php
								$index++;
							endwhile;
							wp_reset_postdata();
							?>
						</div>
					<?php endif; ?>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</section>
