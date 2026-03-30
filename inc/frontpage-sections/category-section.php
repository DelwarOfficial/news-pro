<?php
/**
 * Reusable Category Section Engine.
 * Powers multiple category-based homepage sections with different layouts.
 *
 * @package News Record
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * Expected variables (set by wrapper file beforehand):
 * $section_title - Section title string
 * $category      - Category slug or ID
 * $layout        - Layout mode (tile-list, two-col, one-plus-3, vertical, spotlight, mixed-grid)
 * $post_count    - Number of posts to display
 * $columns       - Number of columns (for mixed grids)
 * $show_meta     - Whether to show meta (boolean)
 * $show_excerpt  - Whether to show excerpt (boolean)
 * $sidebar_mode  - right, left, or none
 */

// Safe Defaults
$section_title = isset( $section_title ) ? $section_title : '';
$category      = isset( $category ) ? $category : '';
$layout        = isset( $layout ) ? $layout : 'tile-list';
$post_count    = isset( $post_count ) ? absint( $post_count ) : 5;
$columns       = isset( $columns ) ? absint( $columns ) : 3;
$show_meta     = isset( $show_meta ) ? $show_meta : true;
$show_excerpt  = isset( $show_excerpt ) ? $show_excerpt : true;
$sidebar_mode  = isset( $sidebar_mode ) ? $sidebar_mode : 'none';

// Validate layout
$allowed_layouts = array( 'tile-list', 'two-col', 'one-plus-3', 'vertical', 'spotlight', 'mixed-grid' );
if ( ! in_array( $layout, $allowed_layouts, true ) ) {
	$layout = 'tile-list';
}

// Build Query
$args = array(
	'post_type'           => 'post',
	'posts_per_page'      => $post_count,
	'ignore_sticky_posts' => true,
);

if ( ! empty( $category ) ) {
	if ( is_numeric( $category ) ) {
		$args['cat'] = absint( $category );
	} else {
		$args['category_name'] = sanitize_text_field( $category );
	}
}

$query = new WP_Query( $args );

if ( ! $query->have_posts() ) {
	return;
}

// Sidebar structural classes
$container_class = 'category-section-content layout-' . esc_attr( $layout );
$wrap_class      = '';

if ( 'right' === $sidebar_mode ) {
	$wrap_class = 'widget-element-wrap secondary-sidebar-right';
} elseif ( 'left' === $sidebar_mode ) {
	$wrap_class = 'widget-element-wrap primary-sidebar-left';
}
?>

<section id="news_record_category_<?php echo esc_attr( sanitize_title( $layout . '-' . $category ) ); ?>" class="category-section section-divider">
	<div class="site-container-width">
		
		<?php if ( ! empty( $section_title ) ) : ?>
			<div class="header-title">
				<h3 class="section-title"><?php echo esc_html( $section_title ); ?></h3>
			</div>
		<?php endif; ?>

		<?php if ( 'none' !== $sidebar_mode ) : ?>
			<div class="<?php echo esc_attr( $wrap_class ); ?>">
				<div class="primary-widget-section">
		<?php endif; ?>

		<div class="<?php echo esc_attr( $container_class ); ?>">
			<?php
			$posts = array();
			while ( $query->have_posts() ) {
				$query->the_post();
				$posts[] = get_post();
			}
			wp_reset_postdata();

			// Layout: Tile-List (1 Large Tile, remaining smaller lists)
			if ( 'tile-list' === $layout ) :
				foreach ( $posts as $index => $post ) : setup_postdata( $post );
					$card_class = ( 0 === $index ) ? 'tile-card' : 'list-card';
					?>
					<div class="single-card-container <?php echo esc_attr( $card_class ); ?>">
						<div class="single-card-image">
							<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 0 === $index ? 'large' : 'medium' ); ?></a>
						</div>
						<div class="single-card-detail">
							<?php if ( $show_meta ) : ?>
								<div class="card-meta">
									<?php news_record_categories_list(); news_record_posted_by(); news_record_posted_on(); ?>
								</div>
							<?php endif; ?>
							<h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<?php if ( $show_excerpt && 0 === $index ) : ?>
								<div class="card-excerpt"><?php the_excerpt(); ?></div>
							<?php endif; ?>
						</div>
					</div>
				<?php
				endforeach; wp_reset_postdata();

			// Layout: Two Column Split
			elseif ( 'two-col' === $layout ) :
				$mid = ceil( count( $posts ) / 2 );
				$cols = array( array_slice( $posts, 0, $mid ), array_slice( $posts, $mid ) );
				?>
				<div class="two-columns">
					<?php foreach ( $cols as $col ) : ?>
						<div class="column">
							<?php foreach ( $col as $post ) : setup_postdata( $post ); ?>
								<div class="single-card-container list-card">
									<div class="single-card-image">
										<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'medium' ); ?></a>
									</div>
									<div class="single-card-detail">
										<?php if ( $show_meta ) : ?>
											<div class="card-meta">
												<?php news_record_categories_list(); news_record_posted_on(); ?>
											</div>
										<?php endif; ?>
										<h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
									</div>
								</div>
							<?php endforeach; wp_reset_postdata(); ?>
						</div>
					<?php endforeach; ?>
				</div>
				<?php

			// Layout: One Large + 3 Small Grid
			elseif ( 'one-plus-3' === $layout ) :
				$large_post = array_shift( $posts );
				?>
				<div class="one-plus-three-wrapper">
					<div class="one-plus-three-large">
						<?php setup_postdata( $large_post ); ?>
						<div class="single-card-container tile-card">
							<div class="single-card-image"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'large' ); ?></a></div>
							<div class="single-card-detail">
								<?php if ( $show_meta ) : ?><div class="card-meta"><?php news_record_categories_list(); news_record_posted_on(); ?></div><?php endif; ?>
								<h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							</div>
						</div>
						<?php wp_reset_postdata(); ?>
					</div>
					<div class="one-plus-three-small">
						<?php foreach ( array_slice( $posts, 0, 3 ) as $post ) : setup_postdata( $post ); ?>
							<div class="single-card-container grid-card">
								<div class="single-card-image"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'medium_large' ); ?></a></div>
								<div class="single-card-detail">
									<?php if ( $show_meta ) : ?><div class="card-meta"><?php news_record_posted_on(); ?></div><?php endif; ?>
									<h4 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
								</div>
							</div>
						<?php endforeach; wp_reset_postdata(); ?>
					</div>
				</div>
				<?php

			// Layout: Mixed Grid (1 Large tile followed by flex grid) 
			elseif ( 'mixed-grid' === $layout ) :
				$first_post = array_shift( $posts );
				$grid_cols  = max( 1, $columns - 1 );
				?>
				<div class="mixed-grid-wrapper">
					<div class="mixed-grid-large">
						<?php setup_postdata( $first_post ); ?>
						<div class="single-card-container tile-card">
							<div class="single-card-image"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'large' ); ?></a></div>
							<div class="single-card-detail">
								<?php if ( $show_meta ) : ?><div class="card-meta"><?php news_record_categories_list(); news_record_posted_on(); ?></div><?php endif; ?>
								<h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							</div>
						</div>
						<?php wp_reset_postdata(); ?>
					</div>
					<div class="mixed-grid-items mixed-grid-col-<?php echo esc_attr( $grid_cols ); ?>">
						<?php foreach ( $posts as $post ) : setup_postdata( $post ); ?>
							<div class="single-card-container grid-card">
								<div class="single-card-image"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'medium' ); ?></a></div>
								<div class="single-card-detail">
									<?php if ( $show_meta ) : ?><div class="card-meta"><?php news_record_posted_on(); ?></div><?php endif; ?>
									<h4 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
								</div>
							</div>
						<?php endforeach; wp_reset_postdata(); ?>
					</div>
				</div>
				<?php
			endif;
			?>
		</div>

		<?php if ( 'none' !== $sidebar_mode ) : ?>
				</div><!-- .primary-widget-section -->
				<div class="secondary-widget-section">
					<?php dynamic_sidebar( ( 'left' === $sidebar_mode ) ? 'primary-widgets-area' : 'secondary-widgets-area' ); ?>
				</div>
			</div><!-- .widget-element-wrap -->
		<?php endif; ?>

	</div>
</section>

<style>
/* Minimal Layout Core for Category Engine */
.layout-two-col .two-columns { display: flex; gap: 30px; }
.layout-two-col .column { flex: 1; display: flex; flex-direction: column; gap: 20px;}

.layout-one-plus-3 .one-plus-three-wrapper,
.layout-mixed-grid .mixed-grid-wrapper { display: flex; gap: 30px; }

.one-plus-three-large, .mixed-grid-large { flex: 0 0 45%; }
.one-plus-three-small, .mixed-grid-items { flex: 1; display: flex; flex-wrap: wrap; gap: 20px; align-content: flex-start; }

.one-plus-three-small .grid-card { flex: 0 0 calc(50% - 10px); }
.mixed-grid-col-2 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;}
.mixed-grid-col-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;}

@media (max-width: 991px) {
    .layout-two-col .two-columns,
    .layout-one-plus-3 .one-plus-three-wrapper,
    .layout-mixed-grid .mixed-grid-wrapper { flex-direction: column; }
    .one-plus-three-large, .mixed-grid-large { flex: 100%; }
}
</style>