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
								if ( 0 === $index ) :
									?>
									<div class="tri-card tri-card-hero">
										<a class="tri-hero-image" href="<?php the_permalink(); ?>">
											<?php the_post_thumbnail( 'large' ); ?>
										</a>
										<div class="tri-card-body">
											<div class="tri-meta"><?php news_record_posted_on(); ?></div>
											<h3 class="tri-title clamp-2"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
										</div>
									</div>
								<?php else : ?>
									<div class="tri-card tri-card-small">
										<a class="tri-thumb" href="<?php the_permalink(); ?>">
											<?php the_post_thumbnail( 'medium' ); ?>
										</a>
										<div class="tri-card-body">
											<div class="tri-meta"><?php news_record_posted_on(); ?></div>
											<h4 class="tri-title clamp-2"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
										</div>
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
.tri-column-section .tri-col-grid { display: grid; gap: 24px; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); }
@media (min-width: 992px) { .tri-column-section .tri-col-grid { grid-template-columns: repeat(3, 1fr); } }
@media (min-width: 640px) and (max-width: 991px) { .tri-column-section .tri-col-grid { grid-template-columns: repeat(2, 1fr); } }

.tri-column-section .tri-col-posts-wrapper { display: flex; flex-direction: column; gap: 16px; }
.tri-column-section .tri-card { background: #fff; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.06); overflow: hidden; transition: transform 150ms ease, box-shadow 150ms ease; }
.tri-column-section .tri-card:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(0,0,0,0.1); }

.tri-column-section .tri-card-hero .tri-hero-image { display: block; aspect-ratio: 16 / 9; overflow: hidden; }
.tri-column-section .tri-card-hero .tri-hero-image img { width: 100%; height: 100%; object-fit: cover; display: block; }
.tri-column-section .tri-card-hero .tri-card-body { padding: 14px 16px 16px; }

.tri-column-section .tri-card-small { display: flex; gap: 12px; padding: 12px; align-items: center; }
.tri-column-section .tri-card-small .tri-thumb { flex: 0 0 96px; max-width: 96px; aspect-ratio: 1 / 1; border-radius: 10px; overflow: hidden; display: block; }
.tri-column-section .tri-card-small .tri-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
.tri-column-section .tri-card-small .tri-card-body { flex: 1; min-width: 0; }

.tri-column-section .tri-meta { font-size: 0.85rem; color: #666; margin-bottom: 6px; }
.tri-column-section .tri-title { font-size: 1rem; line-height: 1.35; margin: 0; }
.tri-column-section .tri-card-hero .tri-title { font-size: 1.1rem; }
.tri-column-section .tri-title a { color: inherit; text-decoration: none; }
.tri-column-section .tri-title a:hover { text-decoration: underline; }

.tri-column-section .clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

.tri-column-section .tri-card-hero, .tri-column-section .tri-card-small { border-radius: 12px; }
.tri-column-section .tri-card-hero .tri-hero-image img,
.tri-column-section .tri-card-small .tri-thumb img { border-radius: 12px; }
</style>
