<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package News Record
 */

?>

</div>

<?php if ( ! is_front_page() || is_home() ) { ?>
</div>
</div><!-- #content -->

<?php

}

?>

<footer id="colophon" class="site-footer">
	<?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) ) : ?>
	<div class="upper-footer">
		<div class="site-container-width max-w-7xl mx-auto px-4">
			<div class="upper-footer-container grid gap-6 md:grid-cols-2 lg:grid-cols-4">

				<?php for ( $i = 1; $i <= 4; $i++ ) { ?>
					<div class="footer-widget-block">
						<?php dynamic_sidebar( 'footer-' . $i ); ?>
					</div>
				<?php } ?>

			</div>
		</div>
	</div>
<?php endif; ?>

	<div class="footer-brand-section">
		<div class="site-container-width max-w-7xl mx-auto px-4">
			<div class="footer-brand-wrapper flex items-center justify-between gap-4 flex-wrap">
				<div class="footer-brand-logo">
					<?php if ( has_custom_logo() ) : ?>
						<?php the_custom_logo(); ?>
					<?php else : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-brand-text">
							<h3><?php bloginfo( 'name' ); ?></h3>
						</a>
					<?php endif; ?>
				</div>
				<div class="footer-brand-desc">
					<p><?php bloginfo( 'description' ); ?></p>
				</div>
			</div>
		</div>
	</div>

<?php
$news_record_search = array( '[the-year]', '[site-link]' );
$replace            = array( date( 'Y' ), '<a href="' . esc_url( home_url( '/' ) ) . '">' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '</a>' );
$copyright_default  = sprintf( esc_html_x( 'Copyright &copy; %1$s %2$s', '1: Year, 2: Site Title with home URL', 'news-record' ), '[the-year]', '[site-link]' );
$copyright_text     = get_theme_mod( 'news_record_copyright_txt', $copyright_default );
$copyright_text     = str_replace( $news_record_search, $replace, $copyright_text );
	?>
	<div class="lower-footer">
		<div class="site-container-width max-w-7xl mx-auto px-4">
			<div class="lower-footer-info flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
				<?php if ( get_theme_mod( 'news_record_footer_newsletter_enable', true ) ) : ?>
				<div class="footer-newsletter max-w-xl">
					<h4><?php echo esc_html( get_theme_mod( 'news_record_footer_newsletter_title', esc_html__( 'Subscribe to Newsletter', 'news-record' ) ) ); ?></h4>
					<p><?php echo esc_html( get_theme_mod( 'news_record_footer_newsletter_desc', esc_html__( 'Get the latest news and updates delivered to your inbox.', 'news-record' ) ) ); ?></p>
					<form class="newsletter-form flex flex-col sm:flex-row gap-3" action="#" method="post">
						<input class="flex-1 px-3 py-2 rounded" type="email" name="email" placeholder="<?php esc_attr_e( 'Enter your email', 'news-record' ); ?>" required>
						<button class="px-4 py-2 rounded bg-primary text-white" type="submit"><?php echo esc_html( get_theme_mod( 'news_record_footer_newsletter_button', esc_html__( 'Subscribe', 'news-record' ) ) ); ?></button>
					</form>
				</div>
				<?php endif; ?>
				<div class="site-info text-sm text-gray-700">
					<span>
						<?php echo wp_kses_post( $copyright_text ); ?>
						<?php echo sprintf( esc_html__( 'Theme: %1$s By %2$s.', 'news-record' ), wp_get_theme()->get( 'Name' ), '<a href="' . wp_get_theme()->get( 'AuthorURI' ) . '">' . wp_get_theme()->get( 'Author' ) . '</a>' ); ?>	
					</span>	
				</div><!-- .site-info -->
			</div>
		</div>
	</div>

</footer><!-- #colophon -->

<a href="#" id="scroll-to-top" class="news-record-scroll-to-top"><i class="fas fa-chevron-up"></i></a>		

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
