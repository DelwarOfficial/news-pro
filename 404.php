<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package News Record
 */

get_header();
?>

<main id="primary" class="site-main">

	<section class="error-404 not-found">
		<header class="page-header">
			<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'news-record' ); ?></h1>
		</header><!-- .page-header -->

		<div class="page-content tw-bg-gray-50 tw-p-8 tw-rounded-xl tw-border tw-border-gray-200 tw-text-center tw-mt-8 tw-shadow-sm">

			<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'news-record' ); ?></p>

			<?php

			get_search_form();

			/* translators: %1$s: smiley */
			$news_record_archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'news-record' ), convert_smilies( ':)' ) ) . '</p>';
			the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$news_record_archive_content" );

			?>

		</div><!-- .page-content -->
	</section><!-- .error-404 -->

</main><!-- #main -->

<?php
get_footer();
