<?php

// Add custom fonts, used in the main stylesheet.
wp_enqueue_style( 'news-record-fonts', wptt_get_webfont_url( news_record_fonts_url() ), array(), null );

// Slick style.
wp_enqueue_style( 'slick-style', get_template_directory_uri() . '/assets/css/slick.min.css', array(), '1.8.0' );

// Fontawesome style.
wp_enqueue_style( 'fontawesome-style', get_template_directory_uri() . '/assets/css/all.min.css', array(), '6.7.2' );

// Conveyor Ticker style.
wp_enqueue_style( 'conveyor-ticker-style', get_template_directory_uri() . '/assets/css/jquery.jConveyorTicker.min.css', array(), '1.1.0' );

// blocks.
wp_enqueue_style( 'news-record-blocks-style', get_template_directory_uri() . '/assets/css/blocks.min.css' );

// style.
wp_enqueue_style( 'news-record-style', get_template_directory_uri() . '/style.css', array(), NEWS_RECORD_VERSION );

// navigation.
wp_enqueue_script( 'news-record-navigation', get_template_directory_uri() . '/assets/js/navigation.min.js', array(), NEWS_RECORD_VERSION, true );

// Slick script.
wp_enqueue_script( 'slick-script', get_template_directory_uri() . '/assets/js/slick.min.js', array( 'jquery' ), '1.8.0', true );

// Conveyor Ticker script.
wp_enqueue_script( 'conveyor-ticker-script', get_template_directory_uri() . '/assets/js/jquery.jConveyorTicker.js', array( 'jquery' ), '1.1.0', true );

// Custom script.
wp_enqueue_script( 'news-record-custom-script', get_template_directory_uri() . '/assets/js/custom.min.js', array( 'jquery', 'slick-script' ), NEWS_RECORD_VERSION, true );

if ( is_customize_preview() ) {
	$customizer_safe_script = '(function($){$.fn.jConveyorTicker=$.fn.jConveyorTicker||function(){return this;};$.fn.slick=$.fn.slick||function(){return this;};$("#preloader,#loader").hide();})(jQuery);';
	wp_add_inline_script( 'news-record-custom-script', $customizer_safe_script, 'before' );
}

if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
	wp_enqueue_script( 'comment-reply' );
}
