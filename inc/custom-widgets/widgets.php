<?php

// Dual Column Widget.
require get_template_directory() . '/inc/custom-widgets/dual-column-widget.php';

// Featured Posts Widget.
require get_template_directory() . '/inc/custom-widgets/mini-list-widget.php';

// Grid List Posts Widget.
require get_template_directory() . '/inc/custom-widgets/grid-list-posts-widget.php';

// Grid Posts Widget.
require get_template_directory() . '/inc/custom-widgets/grid-posts-widget.php';

// List Posts Widget.
require get_template_directory() . '/inc/custom-widgets/list-posts-widget.php';

// Categories Widget.
require get_template_directory() . '/inc/custom-widgets/categories-widget.php';

// Social Links Widget.
require get_template_directory() . '/inc/custom-widgets/social-links-widget.php';

// Tabbed News Widget.
require get_template_directory() . '/inc/custom-widgets/tabbed-news-widget.php';

// Tile Posts Widget.
require get_template_directory() . '/inc/custom-widgets/tile-posts-widget.php';

/**
 * Register Widgets
 */
function news_record_register_widgets() {

	register_widget( 'News_Record_Dual_Column_Posts_Widget' );

	register_widget( 'News_Record_Mini_List_Widget' );

	register_widget( 'News_Record_Grid_List_Posts_Widget' );

	register_widget( 'News_Record_Grid_Posts_Widget' );

	register_widget( 'News_Record_List_Posts_Widget' );

	register_widget( 'News_Record_Categories_Widget' );

	register_widget( 'News_Record_Social_Links_Widget' );

	register_widget( 'News_Record_Tabbed_News_Widget' );

	register_widget( 'News_Record_Tile_Posts_Widget' );

}
add_action( 'widgets_init', 'news_record_register_widgets' );
