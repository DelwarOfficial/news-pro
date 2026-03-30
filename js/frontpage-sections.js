/*
 * Frontpage Sections JavaScript
 * Provides enhanced functionality for unified sections
 *
 * @package News Record
 */

(function($) {
	'use strict';

	// Document ready
	$(document).ready(function() {
		// Initialize carousel functionality
		initCarousels();
		
		// Initialize hover effects
		hoverEffects();
		
		// Initialize responsive behavior
		responsiveBehavior();
	});

	// Window resize handler
	$(window).on('resize', function() {
		responsiveBehavior();
	});

	/**
	 * Initialize carousel functionality
	 */
	function initCarousels() {
		// Initialize Slick carousels if available
		if (typeof $.fn.slick !== 'undefined') {
			$('.news-record-slick-carousel').each(function() {
				var $carousel = $(this);
				
				$carousel.slick({
					dots: true,
					infinite: true,
					speed: 300,
					slidesToShow: 3,
					slidesToScroll: 1,
					responsive: [
						{
							breakpoint: 1024,
							settings: {
								 slidesToShow: 2,
								 slidesToScroll: 1
							}
						},
						{
							breakpoint: 768,
							settings: {
								 slidesToShow: 1,
								 slidesToScroll: 1
							}
						}
					]
				});
			});
		}
	}

	/**
	 * Initialize hover effects
	 */
	function hoverEffects() {
		// Card hover effects
		$('.card-container, .category-card, .overlay-card, .ec-card').on('mouseenter', function() {
			var $card = $(this);
			
			// Scale image slightly
			$card.find('img').css('transform', 'scale(1.05)');
			
			// Add subtle shadow
			$card.css('box-shadow', '0 8px 25px rgba(0,0,0,0.15)');
		}).on('mouseleave', function() {
			var $card = $(this);
			
			// Reset image scale
			$card.find('img').css('transform', 'scale(1)');
			
			// Reset shadow
			$card.css('box-shadow', '0 2px 8px rgba(0,0,0,0.1)');
		});
	}

	/**
	 * Initialize responsive behavior
	 */
	function responsiveBehavior() {
		// Adjust carousel settings based on viewport
		adjustCarouselSettings();
		
		// Handle mobile menu behavior
		handleMobileMenu();
		
		// Adjust grid layouts
		adjustGridLayouts();
	}

	/**
	 * Adjust carousel settings based on viewport
	 */
	function adjustCarouselSettings() {
		var windowWidth = $(window).width();
		
		if (windowWidth < 768) {
			// Mobile settings
			$('.news-record-slick-carousel').slick('slickSetOption', 'slidesToShow', 1, true);
			$('.news-record-slick-carousel').slick('slickSetOption', 'slidesToScroll', 1, true);
		} else if (windowWidth < 1024) {
			// Tablet settings
			$('.news-record-slick-carousel').slick('slickSetOption', 'slidesToShow', 2, true);
			$('.news-record-slick-carousel').slick('slickSetOption', 'slidesToScroll', 1, true);
		} else {
			// Desktop settings
			$('.news-record-slick-carousel').slick('slickSetOption', 'slidesToShow', 3, true);
			$('.news-record-slick-carousel').slick('slickSetOption', 'slidesToScroll', 1, true);
		}
	}

	/**
	 * Handle mobile menu behavior
	 */
	function handleMobileMenu() {
		// Toggle mobile menu
		$('.mobile-menu-toggle').on('click', function() {
			$('.main-navigation').toggleClass('mobile-open');
			$(this).toggleClass('active');
		});
	}

	/**
	 * Adjust grid layouts
	 */
	function adjustGridLayouts() {
		var windowWidth = $(window).width();
		
		// Adjust card grid columns
		if (windowWidth < 768) {
			// Single column on mobile
			$('.card-grid').css('grid-template-columns', '1fr');
			$('.editor-choice-grid').css('grid-template-columns', '1fr');
			$('.headlines-overlay-grid').css('grid-template-columns', '1fr');
			$('.featured-posts-wrapper').css('grid-template-columns', '1fr');
			$('.videos-grid').css('grid-template-columns', '1fr');
			$('.categories-section .categories-grid').css('grid-template-columns', '1fr');
		} else if (windowWidth < 1024) {
			// Two columns on tablet
			$('.card-grid').css('grid-template-columns', 'repeat(2, 1fr)');
			$('.editor-choice-grid').css('grid-template-columns', 'repeat(2, 1fr)');
			$('.headlines-overlay-grid').css('grid-template-columns', 'repeat(2, 1fr)');
			$('.featured-posts-wrapper').css('grid-template-columns', '1fr 1fr');
			$('.videos-grid').css('grid-template-columns', 'repeat(2, 1fr)');
			$('.categories-section .categories-grid').css('grid-template-columns', 'repeat(2, 1fr)');
		} else {
			// Multi-column on desktop
			$('.card-grid').css('grid-template-columns', 'repeat(3, 1fr)');
			$('.editor-choice-grid').css('grid-template-columns', 'repeat(3, 1fr)');
			$('.headlines-overlay-grid').css('grid-template-columns', '1fr 1fr');
			$('.featured-posts-wrapper').css('grid-template-columns', '1fr 1fr');
			$('.videos-grid').css('grid-template-columns', 'repeat(3, 1fr)');
			$('.categories-section .categories-grid').css('grid-template-columns', 'repeat(3, 1fr)');
		}
	}

	/**
	 * Smooth scroll to sections
	 */
	function smoothScrollToSection(sectionId) {
		var $section = $(sectionId);
		
		if ($section.length) {
			$('html, body').animate({
				scrollTop: $section.offset().top - 80
			}, 500);
		}
	}

	/**
	 * Lazy load images
	 */
	function lazyLoadImages() {
		// Implement lazy loading for better performance
		$('img[data-src]').each(function() {
			var $img = $(this);
			var src = $img.attr('data-src');
			
			if (src) {
				$img.attr('src', src).removeAttr('data-src');
			}
		});
	}

	/**
	 * Initialize lazy loading
	 */
	function initLazyLoading() {
		// Check if Intersection Observer is available
		if ('IntersectionObserver' in window) {
			var imageObserver = new IntersectionObserver(function(entries, observer) {
				entries.forEach(function(entry) {
					if (entry.isIntersecting) {
						var $img = $(entry.target);
						var src = $img.attr('data-src');
						
						if (src) {
							$img.attr('src', src).removeAttr('data-src');
							imageObserver.unobserve(entry.target);
						}
					}
				});
			});

			// Observe all lazy images
			$('img[data-src]').each(function() {
				imageObserver.observe(this);
			});
		} else {
			// Fallback for older browsers
			lazyLoadImages();
		}
	}

	// Initialize lazy loading
	initLazyLoading();

	// Public API
	window.newsRecord = {
		smoothScrollToSection: smoothScrollToSection,
		initLazyLoading: initLazyLoading
	};

})(jQuery);