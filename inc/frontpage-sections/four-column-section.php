<?php
/**
 * Default Layout 4 Column
 * Four-column news grid with hero + list per column, aligned to tri-column styling.
 *
 * @package News Record
 */

// Check if the section is enabled via Customizer.
$four_col_section_enable = get_theme_mod( 'news_record_four_col_section_enable', false );

if ( ! $four_col_section_enable ) {
	return;
}

?>
<section id="news_record_four_col_section" class="category-section four-column-section section-divider">
	<div class="site-container-width">
		<div class="four-col-grid">
			<?php
			for ( $col = 1; $col <= 4; $col++ ) {
				$section_title = get_theme_mod( 'news_record_four_col_' . $col . '_title', 'Column ' . $col );
				$content_type  = get_theme_mod( 'news_record_four_col_' . $col . '_content_type', 'recent' );
				$post_count    = get_theme_mod( 'news_record_four_col_' . $col . '_post_count', 4 );
				$category      = get_theme_mod( 'news_record_four_col_' . $col . '_category', '' );
				$tag           = get_theme_mod( 'news_record_four_col_' . $col . '_tag', '' );

				$args = array(
					'post_type'           => 'post',
					'posts_per_page'      => absint( $post_count ),
					'ignore_sticky_posts' => true,
					'orderby'             => 'date',
					'order'               => 'DESC',
				);

				if ( 'category' === $content_type && ! empty( $category ) ) {
					$args['cat'] = absint( $category );
				} elseif ( 'tag' === $content_type && ! empty( $tag ) ) {
					$args['tag'] = sanitize_text_field( $tag );
				}

				$query = new WP_Query( $args );

				?>
				<div class="four-col-column" id="news_record_four_col_<?php echo esc_attr( $col ); ?>">
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
						<div class="four-col-posts-wrapper">
							<?php
							$index = 0;
							while ( $query->have_posts() ) :
								$query->the_post();
								if ( 0 === $index ) :
									?>
									<div class="four-card four-card-hero">
										<a class="four-hero-image" href="<?php the_permalink(); ?>">
											<?php the_post_thumbnail( 'large' ); ?>
										</a>
										<div class="four-card-body">
											<h3 class="four-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
											<?php if ( has_excerpt() ) : ?>
												<div class="four-excerpt clamp-3"><?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?></div>
											<?php endif; ?>
										</div>
									</div>
								<?php else : ?>
									<div class="four-list-item">
										<h4 class="four-title list-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
									</div>
								<?php
								endif;
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

<style>
.four-column-section .four-col-grid { display: grid; gap: 24px; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); }
@media (min-width: 1200px) { .four-column-section .four-col-grid { grid-template-columns: repeat(4, minmax(0, 1fr)); } }
@media (min-width: 768px) and (max-width: 1199px) { .four-column-section .four-col-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }

.four-column-section .four-col-posts-wrapper { display: flex; flex-direction: column; gap: 14px; }

.four-column-section .four-card { background: #fff; border-radius: 12px; box-shadow: 0 8px 22px rgba(0,0,0,0.06); overflow: hidden; transition: transform 150ms ease, box-shadow 150ms ease; }
.four-column-section .four-card:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(0,0,0,0.1); }

.four-column-section .four-card-hero .four-hero-image { display: block; aspect-ratio: 16 / 9; overflow: hidden; }
.four-column-section .four-card-hero .four-hero-image img { width: 100%; height: 100%; object-fit: cover; display: block; }
.four-column-section .four-card-body { padding: 14px 16px 16px; display: flex; flex-direction: column; gap: 8px; }
.four-column-section .four-title { margin: 0; font-size: 1.05rem; line-height: 1.35; }
.four-column-section .four-title a { color: inherit; text-decoration: none; }
.four-column-section .four-title a:hover { text-decoration: underline; }
.four-column-section .four-excerpt { color: #555; font-size: 0.96rem; line-height: 1.5; }
.four-column-section .clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }

.four-column-section .four-list-item { padding-bottom: 10px; margin-bottom: 10px; border-bottom: 1px solid rgba(0,0,0,0.08); }
.four-column-section .four-list-item:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
.four-column-section .list-title { font-size: 1rem; line-height: 1.4; margin: 0; }

@media (max-width: 767px) { .four-column-section .four-title { font-size: 1rem; } }
</style>
