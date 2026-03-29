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
		<div class="site-container-width">
			<div class="upper-footer-container">

				<?php for ( $i = 1; $i <= 4; $i++ ) { ?>
					<div class="footer-widget-block">
						<?php dynamic_sidebar( 'footer-' . $i ); ?>
					</div>
				<?php } ?>

			</div>
		</div>
	</div>
<?php endif; ?>

<?php
$news_record_search = array( '[the-year]', '[site-link]' );
$replace            = array( date( 'Y' ), '<a href="' . esc_url( home_url( '/' ) ) . '">' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '</a>' );
$copyright_default  = sprintf( esc_html_x( 'Copyright &copy; %1$s %2$s', '1: Year, 2: Site Title with home URL', 'news-record' ), '[the-year]', '[site-link]' );
$copyright_text     = get_theme_mod( 'news_record_copyright_txt', $copyright_default );
$copyright_text     = str_replace( $news_record_search, $replace, $copyright_text );
	?>
	<div class="lower-footer">
		<div class="site-container-width">
			<div class="lower-footer-info">
				<?php if ( get_theme_mod( 'news_record_footer_newsletter_enable', true ) ) : ?>
				<div class="footer-newsletter">
					<h4><?php echo esc_html( get_theme_mod( 'news_record_footer_newsletter_title', __( 'Subscribe to Newsletter', 'news-record' ) ) ); ?></h4>
					<p><?php echo esc_html( get_theme_mod( 'news_record_footer_newsletter_desc', __( 'Get the latest news and updates delivered to your inbox.', 'news-record' ) ) ); ?></p>
					<form class="newsletter-form" action="#" method="post">
						<input type="email" name="email" placeholder="<?php esc_attr_e( 'Enter your email', 'news-record' ); ?>" required>
						<button type="submit"><?php echo esc_html( get_theme_mod( 'news_record_footer_newsletter_button', __( 'Subscribe', 'news-record' ) ) ); ?></button>
					</form>
				</div>
				<?php endif; ?>
				<div class="site-info">
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
