<?php
/**
 * Frontpage Categories Section.
 * Displays a visual grid of post categories with featured images and post counts.
 *
 * @package News Record
 */

// Check if the section is enabled via Customizer.
$categories_section = get_theme_mod( 'news_record_categories_section_enable', false );

if ( false === $categories_section ) {
	return;
}

// Get the section title from Customizer.
$section_title = get_theme_mod( 'news_record_categories_section_title', __( 'Categories', 'news-record' ) );

// Get the selected category IDs from Customizer (up to 6 categories).
$selected_cat_ids = array();
for ( $i = 1; $i <= 6; $i++ ) {
	$cat_id = get_theme_mod( 'news_record_categories_section_cat_' . $i );
	if ( ! empty( $cat_id ) ) {
		$selected_cat_ids[] = absint( $cat_id );
	}
}

// If no categories manually selected, fall back to most-used categories.
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

// Only render if categories exist.
if ( empty( $all_cats ) ) {
	return;
}
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

				// Get category link.
				$cat_link  = get_category_link( $category->term_id );
				$cat_name  = $category->name;
				$cat_count = $category->count;

				// Try to get a featured image from the latest post in this category.
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

				// Get per-category custom color if set.
				$cat_color = get_term_meta( $category->term_id, 'news_record_custom_category_hue', true );
				if ( ! $cat_color ) {
					$cat_color = 'var(--theme-primary-hue)';
				}
				?>

				<div class="category-card">
					<a href="<?php echo esc_url( $cat_link ); ?>" class="category-card-link">
						<!-- Background image layer -->
						<div class="category-card-bg"<?php echo $bg_image; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>></div>
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
