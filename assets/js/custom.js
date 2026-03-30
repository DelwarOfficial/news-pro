jQuery(function ($) {

  /*common RTL variable*/
  var isRTL = $("html").attr("dir") === "rtl";

  /* -----------------------------------------
    Preloader
    ----------------------------------------- */
  $("#preloader").delay(1000).fadeOut();
  $("#loader").delay(1000).fadeOut("slow");

  /* -----------------------------------------
    News Highlights
    ----------------------------------------- */
    jQuery(document).ready(function($){
        if ($('.js-conveyor').length) {
            $('.js-conveyor').jConveyorTicker({
                anim_duration: 200,
                force_loop: true,
            });
        }
    }); 

  /*--------------------------------------------------------------
    # Navigation menu responsive
    --------------------------------------------------------------*/
  $(document).ready(function () {
    var $menuToggle = $(".menu-toggle"),
    $navMenu = $(".main-navigation .nav-menu"),
    $mainNav = $(".main-navigation"),
    $masthead = $("#masthead");
    
      // Toggle navigation menu
    $menuToggle.click(function () {
      $navMenu.slideToggle("slow");
      $(this).toggleClass("open");
    });
    
      // Handle keyboard navigation
    function handleKeyboardNavigation() {
      if ($(window).width() < 992) {
        $mainNav.find("li").last().off("keydown").on("keydown", function (e) {
            if (e.which === 9) { // Tab key
              e.preventDefault();
              $menuToggle.focus();
            }
          });
      } else {
        $mainNav.find("li").off("keydown");
      }
    }
    
      // Bind resize and load event for menu accessibility
    $(window).on("load resize", handleKeyboardNavigation);
    
      // Handle Shift + Tab key to close the menu when navigating backwards
    $menuToggle.on("keydown", function (e) {
      if ($(this).hasClass("open") && e.shiftKey && e.keyCode === 9) {
        e.preventDefault();
          $navMenu.slideUp("slow");  // Close the menu
          $menuToggle.removeClass("open");
          $mainNav.removeClass("toggled");
        }
      });
  });

  /*--------------------------------------------------------------
    # Navigation Search
    --------------------------------------------------------------*/
  var $searchWrap = $(".header-search-wrap");
  var $searchIcon = $(".header-search-icon");
  var $searchInput = $searchWrap.find("input.search-field");
  var $searchSubmit = $searchWrap.find(".search-submit");
  
    // Toggle search bar on icon click
  $searchIcon.on("click", function (e) {
    e.preventDefault();
    $searchWrap.toggleClass("show");
    $searchInput.focus();
  });
  
    // Close search bar when clicking outside
  $(document).on("click", function (e) {
    if (!$searchWrap.is(e.target) && !$searchWrap.has(e.target).length) {
      $searchWrap.removeClass("show");
    }
  });
  
    // Handle tab key navigation
  $searchSubmit.on("keydown", function (e) {
    if (e.key === "Tab") {
      e.preventDefault();
      $searchIcon.focus();
    }
  });
  
  $searchIcon.on("keydown", function (e) {
    if ($searchWrap.hasClass("show") && e.shiftKey && e.key === "Tab") {
      e.preventDefault();
      $searchWrap.removeClass("show");
      $searchIcon.focus();
    }
  });

  /* -----------------------------------------
    Tabbed News Widget — Tab switching
    ----------------------------------------- */
  if ( $('.tabbed-news-widget').length ) {
    $('.tabbed-news-widget .tab-button').on('click', function() {
      var $this = $(this);
      var tabId = $this.data('tab');
      var $container = $this.closest('.tabbed-news-container');

      $container.find('.tab-button').removeClass('active');
      $this.addClass('active');

      $container.find('.tab-panel').removeClass('active');
      $container.find('#' + tabId).addClass('active');
    });
  }
  if ( $('.news-record-slick-carousel').length ) {
    $('.news-record-slick-carousel').slick({
      slidesToShow   : 3,
      slidesToScroll : 1,
      autoplay       : true,
      autoplaySpeed  : 4000,
      speed          : 500,
      dots           : true,
      arrows         : true,
      rtl            : isRTL,
      appendDots     : $('.carousel-dots'),
      responsive: [
        {
          breakpoint: 992,
          settings: { slidesToShow: 2 }
        },
        {
          breakpoint: 576,
          settings: { slidesToShow: 1, arrows: false, dots: true }
        }
      ]
    });
  }

  /* -----------------------------------------
    Scroll Top
    ----------------------------------------- */
  let scrollToTopBtn = $(".news-record-scroll-to-top");

  $(window).on("scroll", function () {
    scrollToTopBtn.toggleClass("visible", $(this).scrollTop() > 400);
  });
  
  scrollToTopBtn.on("click", function (e) {
    e.preventDefault();
    $("html, body").animate({ scrollTop: 0 }, 300);
  });

  /* -----------------------------------------
    Sticky Header
    ----------------------------------------- */
  var $siteHeader = $(".site-header");
  var headerHeight = $siteHeader.outerHeight();
  
  $(window).on("scroll", function () {
    if ($(this).scrollTop() > 100) {
      $siteHeader.addClass("sticky-header");
    } else {
      $siteHeader.removeClass("sticky-header");
    }
  });

});
