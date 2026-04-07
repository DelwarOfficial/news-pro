<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package News Record
 */

get_header();
?>

    <main id="primary" class="site-main max-w-7xl mx-auto px-4 py-6">

		<?php
		if ( have_posts() ) :

			if ( is_home() && ! is_front_page() ) :
				?>
                <header class="mb-4">
                    <h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
                </header>
				<?php
				$breadcrumb_enable = get_theme_mod( 'news_record_breadcrumb_enable', true );
				if ( $breadcrumb_enable ) :
					?>
                <div id="breadcrumb-list" class="mb-6 text-sm text-gray-600">
					<?php
					echo news_record_breadcrumb(
						array(
							'show_on_front' => false,
							'show_browse'   => false,
						)
					);
					?>
				</div><!-- #breadcrumb-list -->
				<?php endif; ?>
				<?php
			endif;

			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/*
				 * Include the Post-Type-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
				 */
                echo '<div class="mb-8">';
                get_template_part( 'template-parts/content', get_post_type() );
                echo '</div>';

			endwhile;

			do_action( 'news_record_posts_pagination' );

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

	</main><!-- #main -->

<?php

if ( news_record_is_sidebar_enabled() ) {
	get_sidebar();
}

get_footer();
