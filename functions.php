<?php
/**
 * News Record functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package News Record
 */

if ( ! defined( 'NEWS_RECORD_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'NEWS_RECORD_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function news_record_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on News Record, use a find and replace
		* to change 'news-record' to the name of your theme in all the template files.
		*/
		load_theme_textdomain( 'news-record', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		add_theme_support( 'register_block_style' );

		add_theme_support( 'register_block_pattern' );

		add_theme_support( 'responsive-embeds' );

		add_theme_support( 'align-wide' );

		add_theme_support( 'editor-styles' );

		add_theme_support( 'wp-block-styles' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
		add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
		add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'primary' => esc_html__( 'Primary Menu', 'news-record' ),
				'social'  => esc_html__( 'Social Menu', 'news-record' ),
			)
		);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

	// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'news_record_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	add_theme_support( 'woocommerce' );
	if ( class_exists( 'WooCommerce' ) ) {
		global $woocommerce;

		if ( version_compare( $woocommerce->version, '3.0.0', '>=' ) ) {
			add_theme_support( 'wc-product-gallery-zoom' );
			add_theme_support( 'wc-product-gallery-lightbox' );
			add_theme_support( 'wc-product-gallery-slider' );
		}
	}

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	add_theme_support(
		'editor-font-sizes',
		array(
			array(
				'name'      => esc_html__( 'small', 'news-record' ),
				'shortName' => esc_html__( 'S', 'news-record' ),
				'size'      => 12,
				'slug'      => 'small',
			),
			array(
				'name'      => esc_html__( 'regular', 'news-record' ),
				'shortName' => esc_html__( 'M', 'news-record' ),
				'size'      => 16,
				'slug'      => 'regular',
			),
			array(
				'name'      => esc_html__( 'larger', 'news-record' ),
				'shortName' => esc_html__( 'L', 'news-record' ),
				'size'      => 36,
				'slug'      => 'larger',
			),
			array(
				'name'      => esc_html__( 'huge', 'news-record' ),
				'shortName' => esc_html__( 'XL', 'news-record' ),
				'size'      => 48,
				'slug'      => 'huge',
			),
		)
	);

}
add_action( 'after_setup_theme', 'news_record_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function news_record_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'news_record_content_width', 640 );
}
add_action( 'after_setup_theme', 'news_record_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function news_record_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'news-record' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'news-record' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Primary Widgets Area', 'news-record' ),
			'id'            => 'primary-widgets-area',
			'description'   => esc_html__( 'Add primary widgets here.', 'news-record' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Secondary Widgets Area', 'news-record' ),
			'id'            => 'secondary-widgets-area',
			'description'   => esc_html__( 'Add secondary widgets here.', 'news-record' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Two-Column Left Sidebar', 'news-record' ),
			'id'            => 'two-col-left-sidebar',
			'description'   => esc_html__( 'Widgets for the left sidebar in Default Layout 2 Column with Sidebar section.', 'news-record' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Two-Column Right Sidebar', 'news-record' ),
			'id'            => 'two-col-right-sidebar',
			'description'   => esc_html__( 'Widgets for the right sidebar in Default Layout 2 Column with Sidebar section.', 'news-record' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Above Footer Widgets Area', 'news-record' ),
			'id'            => 'above-footer-widgets-area',
			'description'   => esc_html__( 'Add above footer widgets here.', 'news-record' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	for ( $i = 1; $i <= 4; $i++ ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Footer Widget Area ', 'news-record' ) . $i,
				'id'            => 'footer-' . $i,
				'description'   => esc_html__( 'Add widgets here.', 'news-record' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			)
		);
	}
}
add_action( 'widgets_init', 'news_record_widgets_init' );

// Fonts Register
require get_template_directory() . '/inc/custom-fonts.php';

/**
 * Enqueue scripts and styles.
 */
function news_record_scripts() {

	require get_template_directory() . '/inc/enqueue.php';
}
add_action( 'wp_enqueue_scripts', 'news_record_scripts' );


/**
 * Inject Tailwind-friendly classes into core-generated nav, body, post, and widget markup.
 */

// Navigation: simple walker to add utility classes to li/a.
class News_Record_Tailwind_Walker extends Walker_Nav_Menu {
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "\n$indent<ul class=\"sub-menu space-y-2\">\n";
	}

	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'tw-nav-item';

		$class_names = join( ' ', array_filter( $classes ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$output .= '<li' . $class_names . '>';

		$atts           = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target ) ? $item->target : '';
		$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
		$atts['href']   = ! empty( $item->url ) ? $item->url : '';

		$atts       = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$title      = apply_filters( 'the_title', $item->title, $item->ID );
		$item_output  = $args->before;
		$item_output .= '<a class="inline-flex items-center gap-2 py-2 px-3 rounded hover:bg-gray-100"' . $attributes . '>';
		$item_output .= $args->link_before . $title . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}

function news_record_tailwind_primary_menu_args( $args ) {
	if ( isset( $args['theme_location'] ) && 'primary' === $args['theme_location'] ) {
		$args['walker']     = new News_Record_Tailwind_Walker();
		$args['menu_class'] = 'flex flex-wrap items-center gap-2 text-base font-medium';
	}
	return $args;
}
add_filter( 'wp_nav_menu_args', 'news_record_tailwind_primary_menu_args' );


// Body class: add a utility-friendly baseline.
function news_record_tailwind_body_class( $classes ) {
	$classes[] = 'min-h-screen';
	$classes[] = 'bg-white';
	return $classes;
}
add_filter( 'body_class', 'news_record_tailwind_body_class' );

// Post class: ensure spacing and full-width cards where applicable.
function news_record_tailwind_post_class( $classes ) {
	$classes[] = 'space-y-3';
	return $classes;
}
add_filter( 'post_class', 'news_record_tailwind_post_class' );

// Widget class: apply consistent padding/spacing.
function news_record_tailwind_widget_params( $params ) {
	$params[0]['before_widget'] = '<section id="' . $params[0]['widget_id'] . '" class="widget ' . implode( ' ', $params[0]['widget_name'] ? array( sanitize_title( $params[0]['widget_name'] ) ) : array() ) . ' bg-white rounded-lg shadow-sm p-4 mb-6">';
	$params[0]['before_title']  = '<h2 class="widget-title text-lg font-semibold mb-3">';
	$params[0]['after_title']   = '</h2>';
	return $params;
}
add_filter( 'dynamic_sidebar_params', 'news_record_tailwind_widget_params' );

/**
 * Add social icons to the social menu based on link URL.
 */
function news_record_social_menu_icons( $item_output, $item, $depth, $args ) {
	if ( isset( $args->theme_location ) && 'social' === $args->theme_location ) {
		$url = $item->url;
		$icon_class = 'fas fa-link'; // Default icon
		
		$networks = array(
			'facebook.com'  => 'fab fa-facebook-f',
			'twitter.com'   => 'fab fa-x-twitter',
			'x.com'         => 'fab fa-x-twitter',
			'instagram.com' => 'fab fa-instagram',
			'linkedin.com'  => 'fab fa-linkedin-in',
			'youtube.com'   => 'fab fa-youtube',
			'pinterest.com' => 'fab fa-pinterest-p',
			'github.com'    => 'fab fa-github',
			'tiktok.com'    => 'fab fa-tiktok',
			'twitch.tv'     => 'fab fa-twitch',
			'whatsapp.com'  => 'fab fa-whatsapp',
			'telegram.org'  => 'fab fa-telegram',
			'discord.com'   => 'fab fa-discord',
		);
		
		foreach ( $networks as $domain => $class ) {
			if ( strpos( $url, $domain ) !== false ) {
				$icon_class = $class;
				break;
			}
		}
		
		$icon = '<i class="' . esc_attr( $icon_class ) . '"></i>';
		
		if ( ! empty( $args->link_before ) ) {
			$item_output = str_replace( $args->link_before, $icon . $args->link_before, $item_output );
		} else {
			$item_output = preg_replace( '/(<a[^>]*>)/', '$1' . $icon, $item_output );
		}
	}
	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'news_record_social_menu_icons', 10, 4 );

require get_template_directory() . '/inc/require.php';
