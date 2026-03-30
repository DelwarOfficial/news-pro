<?php
/**
 * Unified Section Implementation
 * Updates all existing sections to use the unified engine
 *
 * @package News Record
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Update categories-section.php to use unified engine
 */
function news_record_update_categories_section() {
	$section_id = 'categories';
	$settings = news_record_get_standard_section_settings( $section_id );

	if ( ! $settings['enable'] ) {
		return;
	}

	// Get section title
	$section_title = ! empty( $settings['custom_title'] ) ? $settings['custom_title'] : 'Categories';

	// Get selected category IDs from Customizer
	$selected_cat_ids = array();
	for ( $i = 1; $i <= 6; $i++ ) {
		$cat_id = get_theme_mod( 'news_record_categories_section_cat_' . $i );
		if ( ! empty( $cat_id ) ) {
			$selected_cat_ids[] = absint( $cat_id );
		}
	}

	// If no categories manually selected, fall back to most-used categories
	if ( empty( $selected_cat_ids ) ) {
		$all_cats = get_categories( array(
			'orderby'    => 'count',
			'order'      => 'DESC',
			'hide_empty' => true,
			'number'     => 6,
		) );
	} else {
		$all_cats = get_categories( array(
			'include'    => $selected_cat_ids,
			'hide_empty' => false,
		) );
	}

	// Only render if categories exist
	if ( empty( $all_cats ) ) {
		return;
	}

	// Get category colors
	$category_colors = array();
	foreach ( $all_cats as $category ) {
		$color = get_term_meta( $category->term_id, 'news_record_custom_category_hue', true );
		$category_colors[ $category->term_id ] = $color ?: 'var(--theme-primary-hue)';
	}

	// Render the section
	?>
	<section id="news_record_categories_section" class="categories-section section-divider">
		<div class="site-container-width">

			<?php if ( ! empty( $section_title ) ) : ?>
				<div class="header-title">
					<h3 class="section-title"><?php echo esc_html( $section_title ); ?></h3>
				</div>
			<?php endif; ?>

			<div class="categories-grid">
				<?php foreach ( $all_cats as $category ) :

					// Get category link and info
					$cat_link  = get_category_link( $category->term_id );
					$cat_name  = $category->name;
					$cat_count = $category->count;

					// Get category color
					$cat_color = isset( $category_colors[ $category->term_id ] ) ? $category_colors[ $category->term_id ] : 'var(--theme-primary-hue)';

					// Try to get a featured image from the latest post in this category
					$cat_posts = get_posts( array(
						'numberposts'    => 1,
						'category'       => $category->term_id,
						'post_status'    => 'publish',
						'has_thumbnail'  => true,
					) );

					$bg_image = '';
					if ( ! empty( $cat_posts ) && has_post_thumbnail( $cat_posts[0]->ID ) ) {
						$img_src  = get_the_post_thumbnail_url( $cat_posts[0]->ID, 'medium' );
						$bg_image = ' style="background-image: url(' . esc_url( $img_src ) . ');"';
					}

					// Render category card
					?>

					<div class="category-card">
						<a href="<?php echo esc_url( $cat_link ); ?>" class="category-card-link">
							<!-- Background image layer -->
							<div class="category-card-bg"<?php echo $bg_image; ?>></div>
							<!-- Color overlay using category color -->
							<div class="category-card-overlay" style="--cat-color: <?php echo esc_attr( $cat_color ); ?>;"></div>
							<!-- Category info -->
							<div class="category-card-info">
								<span class="category-card-name"><?php echo esc_html( $cat_name ); ?></span>
								<span class="category-card-count"><?php echo absint( $cat_count ); ?></span>
							</div>
						</a>
					</div>

				<?php endforeach; ?>
			</div><!-- .categories-grid -->

		</div><!-- .site-container-width -->
	</section><!-- #news_record_categories_section -->
	<?php
}

/**
 * Update headlines.php to use unified engine
 */
function news_record_update_headlines_section() {
	$section_id = 'headlines';
	$query = news_record_get_standard_section_query( $section_id );

	if ( ! $query || ! $query->have_posts() ) {
		return;
	}

	$settings = news_record_get_standard_section_settings( $section_id );
	$section_title = ! empty( $settings['custom_title'] ) ? $settings['custom_title'] : 'Headlines';

	$posts = array();
	while ( $query->have_posts() ) {
		$query->the_post();
		$posts[] = get_post();
	}
	wp_reset_postdata();

	$featured_post = isset( $posts[0] ) ? $posts[0] : null;
	$grid_posts = array_slice( $posts, 1, 5 );

	// Render the section
	?>
	<section id="news_record_headlines_section" class="headlines-section section-divider">
		<div class="site-container-width">

			<?php if ( ! empty( $section_title ) ) : ?>
				<div class="header-title">
					<h3 class="section-title"><?php echo esc_html( $section_title ); ?></h3>
				</div>
			<?php endif; ?>

			<div class="headlines-overlay-grid">
				<?php if ( $featured_post ) : ?>
					<div class="headlines-featured">
						<article class="overlay-card featured-card">
							<a href="<?php echo esc_url( get_permalink( $featured_post->ID ) ); ?>" class="overlay-card-link">
								<?php if ( has_post_thumbnail( $featured_post->ID ) ) : ?>
									<div class="overlay-card-image">
										<?php echo get_the_post_thumbnail( $featured_post->ID, 'large', array( 'class' => 'featured-img' ) ); ?>
									</div>
								<?php endif; ?>
								<div class="overlay-card-content">
									<span class="overlay-card-category"><?php news_record_categories_name( $featured_post->ID ); ?></span>
									<h2 class="overlay-card-title"><?php echo esc_html( get_the_title( $featured_post->ID ) ); ?></h2>
									<span class="overlay-card-date"><?php echo esc_html( get_the_date( '', $featured_post->ID ) ); ?></span>
								</div>
							</a>
						</article>
					</div>
				<?php endif; ?>

				<div class="headlines-grid">
					<?php foreach ( $grid_posts as $post ) : setup_postdata( $post ); ?>
						<article class="overlay-card grid-card">
							<a href="<?php the_permalink(); ?>" class="overlay-card-link">
								<?php if ( has_post_thumbnail() ) : ?>
									<div class="overlay-card-image">
										<?php the_post_thumbnail( 'medium', array( 'class' => 'grid-img' ) ); ?>
									</div>
								<?php endif; ?>
								<div class="overlay-card-content">
									<span class="overlay-card-category"><?php news_record_categories_name(); ?></span>
									<h3 class="overlay-card-title"><?php the_title(); ?></h3>
									<span class="overlay-card-date"><?php echo esc_html( get_the_date() ); ?></span>
								</div>
							</a>
						</article>
					<?php endforeach; wp_reset_postdata(); ?>
				</div>
			</div>

		</div>
	</section>
	<?php
}

// Add more update functions for other sections...

/**
 * Initialize unified section replacements
 */
function news_record_init_unified_sections() {
	// Replace sections.php with unified implementation
	require_once get_template_directory() . '/inc/frontpage-sections/unified-section-engine.php';
	
	// Register sections in Customizer
	require_once get_template_directory() . '/inc/frontpage-sections/customizer-integration.php';
	
	// Enqueue styles and scripts
	require_once get_template_directory() . '/inc/frontpage-sections/sections-styles.php';
}

// Replace the original sections.php with our unified implementation
remove_all_actions( 'after_setup_theme' );
add_action( 'after_setup_theme', 'news_record_init_unified_sections' );
?>