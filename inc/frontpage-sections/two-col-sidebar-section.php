<?php
/**
 * Default Layout 2 Column with Sidebar
 * Combines Interviews + In-Depth content into a two-column grid with optional left/right widget sidebars.
 * Shares card styling language with the 3-column layout.
 *
 * @package News Record
 */

// Gate by Customizer toggle.
$two_col_sidebar_enable = get_theme_mod( 'news_record_two_col_sidebar_section_enable', false );
if ( ! $two_col_sidebar_enable ) {
	return;
}

$has_left_sidebar  = is_active_sidebar( 'two-col-left-sidebar' );
$has_right_sidebar = is_active_sidebar( 'two-col-right-sidebar' );

// Column 1 uses dedicated controls (defaulting to Interviews settings).
$col1_title        = get_theme_mod( 'news_record_two_col_sidebar_col1_title', esc_html__( 'Interviews', 'news-record' ) );
$col1_content_type = get_theme_mod( 'news_record_two_col_sidebar_col1_content_type', 'category' );
$col1_category     = get_theme_mod( 'news_record_two_col_sidebar_col1_category', '' );
$col1_tag          = get_theme_mod( 'news_record_two_col_sidebar_col1_tag', '' );
$col1_post_count   = get_theme_mod( 'news_record_two_col_sidebar_col1_post_count', 4 );

// Column 2 uses dedicated controls (defaulting to In-Depth settings).
$col2_title        = get_theme_mod( 'news_record_two_col_sidebar_col2_title', esc_html__( 'In-Depth', 'news-record' ) );
$col2_content_type = get_theme_mod( 'news_record_two_col_sidebar_col2_content_type', 'category' );
$col2_category     = get_theme_mod( 'news_record_two_col_sidebar_col2_category', '' );
$col2_tag          = get_theme_mod( 'news_record_two_col_sidebar_col2_tag', '' );
$col2_post_count   = get_theme_mod( 'news_record_two_col_sidebar_col2_post_count', 7 );

function news_record_render_two_col_stream( $title, $content_type, $category, $tag, $post_count ) {
	$args = array(
		'post_type'           => 'post',
		'posts_per_page'      => absint( $post_count ),
		'ignore_sticky_posts' => true,
	);

	if ( 'category' === $content_type && ! empty( $category ) ) {
		if ( is_numeric( $category ) ) {
			$args['cat'] = absint( $category );
		} else {
			$args['category_name'] = sanitize_text_field( $category );
		}
	} elseif ( 'tag' === $content_type && ! empty( $tag ) ) {
		$args['tag'] = sanitize_text_field( $tag );
	}

	$query = new WP_Query( $args );

	if ( ! $query->have_posts() ) {
		return;
	}

	?>
	<div class="two-col-stream">
		<?php if ( ! empty( $title ) ) : ?>
			<div class="header-title">
				<h3 class="section-title"><?php echo esc_html( $title ); ?></h3>
			</div>
		<?php endif; ?>

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
	</div>
	<?php
}

$layout_classes = array( 'two-col-sidebar-grid' );
if ( ! $has_left_sidebar ) {
	$layout_classes[] = 'no-left-sidebar';
}
if ( ! $has_right_sidebar ) {
	$layout_classes[] = 'no-right-sidebar';
}

?>

<section id="news_record_two_col_sidebar_section" class="category-section two-col-sidebar-section section-divider">
	<div class="site-container-width">
		<div class="<?php echo esc_attr( implode( ' ', $layout_classes ) ); ?>">
			<?php if ( $has_left_sidebar ) : ?>
				<aside class="two-col-sidebar left-sidebar">
					<?php dynamic_sidebar( 'two-col-left-sidebar' ); ?>
				</aside>
			<?php endif; ?>

			<div class="two-col-main">
				<div class="two-col-content-grid">
					<?php news_record_render_two_col_stream( $col1_title, $col1_content_type, $col1_category, $col1_tag, $col1_post_count ); ?>
					<?php news_record_render_two_col_stream( $col2_title, $col2_content_type, $col2_category, $col2_tag, $col2_post_count ); ?>
				</div>
			</div>

			<?php if ( $has_right_sidebar ) : ?>
				<aside class="two-col-sidebar right-sidebar">
					<?php dynamic_sidebar( 'two-col-right-sidebar' ); ?>
				</aside>
			<?php endif; ?>
		</div>
	</div>
</section>

<style>
.two-col-sidebar-section .site-container-width {
	max-width: 1320px;
	width: 100%;
	margin: 0 auto;
	padding: 0 16px;
}
.two-col-sidebar-section .two-col-sidebar-grid {
	display: grid;
	gap: 24px;
	grid-template-columns: minmax(0, 300px) minmax(0, 1fr) minmax(0, 300px);
}
.two-col-sidebar-section .two-col-sidebar-grid.no-left-sidebar {
	grid-template-columns: minmax(0, 1fr) minmax(0, 300px);
}
.two-col-sidebar-section .two-col-sidebar-grid.no-right-sidebar {
	grid-template-columns: minmax(0, 300px) minmax(0, 1fr);
}
.two-col-sidebar-section .two-col-sidebar-grid.no-left-sidebar.no-right-sidebar {
	grid-template-columns: minmax(0, 1fr);
}

.two-col-sidebar-section .two-col-main { width: 100%; }
.two-col-sidebar-section .two-col-content-grid { display: grid; gap: 24px; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); }
@media (min-width: 992px) {
	.two-col-sidebar-section .two-col-content-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
}
.two-col-sidebar-section .two-col-content-grid .two-col-stream { height: 100%; }

.two-col-sidebar-section .two-col-sidebar { background: #f8f8f8; padding: 16px; border-radius: 12px; }
.two-col-sidebar-section .two-col-sidebar .widget { margin-bottom: 16px; }
.two-col-sidebar-section .two-col-sidebar .widget:last-child { margin-bottom: 0; }

/* Reuse card styles from tri-column layout */
.two-col-sidebar-section .tri-col-posts-wrapper { display: flex; flex-direction: column; gap: 16px; }
.two-col-sidebar-section .tri-card { background: #fff; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.06); overflow: hidden; transition: transform 150ms ease, box-shadow 150ms ease; }
.two-col-sidebar-section .tri-card:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(0,0,0,0.1); }
.two-col-sidebar-section .tri-card-hero .tri-hero-image { display: block; aspect-ratio: 16 / 9; overflow: hidden; }
.two-col-sidebar-section .tri-card-hero .tri-hero-image img { width: 100%; height: 100%; object-fit: cover; display: block; border-radius: 12px; }
.two-col-sidebar-section .tri-card-hero .tri-card-body { padding: 14px 16px 16px; }

.two-col-sidebar-section .tri-card-small { display: flex; gap: 12px; padding: 12px; align-items: center; }
.two-col-sidebar-section .tri-card-small .tri-thumb { flex: 0 0 96px; max-width: 96px; aspect-ratio: 1 / 1; border-radius: 10px; overflow: hidden; display: block; }
.two-col-sidebar-section .tri-card-small .tri-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; border-radius: 10px; }
.two-col-sidebar-section .tri-card-small .tri-card-body { flex: 1; min-width: 0; }

.two-col-sidebar-section .tri-meta { font-size: 0.85rem; color: #666; margin-bottom: 6px; }
.two-col-sidebar-section .tri-title { font-size: 1rem; line-height: 1.35; margin: 0; }
.two-col-sidebar-section .tri-card-hero .tri-title { font-size: 1.1rem; }
.two-col-sidebar-section .tri-title a { color: inherit; text-decoration: none; }
.two-col-sidebar-section .tri-title a:hover { text-decoration: underline; }
.two-col-sidebar-section .clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

@media (max-width: 991px) {
	.two-col-sidebar-section .two-col-sidebar-grid { grid-template-columns: 1fr; }
	.two-col-sidebar-section .two-col-sidebar { order: 2; }
	.two-col-sidebar-section .two-col-main { order: 1; }
}

@media (max-width: 639px) {
	.two-col-sidebar-section .two-col-content-grid { grid-template-columns: 1fr; }
}
</style>
