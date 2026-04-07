<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package News Record
 */

get_header();
?>

	<main id="primary" class="site-main max-w-5xl mx-auto px-4 py-6">

		<?php
		while ( have_posts() ) :
			the_post();

			echo '<div class="mb-8">';
			get_template_part( 'template-parts/content', 'page' );
			echo '</div>';

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php

if ( news_record_is_sidebar_enabled() ) {
	get_sidebar();
}

get_footer();
