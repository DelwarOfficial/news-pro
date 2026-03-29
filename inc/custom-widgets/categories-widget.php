<?php
if ( ! class_exists( 'News_Record_Categories_Widget' ) ) {
	/**
	 * Adds News Record Categories Widget.
	 */
	class News_Record_Categories_Widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		public function __construct() {
			$news_record_categories_widget = array(
				'classname'   => 'news-record-widget categories-widget',
				'description' => __( 'Display categories with post counts', 'news-record' ),
			);
			parent::__construct(
				'news_record_categories_widget',
				__( 'Artify Widget: Categories', 'news-record' ),
				$news_record_categories_widget
			);
		}

		/**
		 * Front-end display of widget.
		 *
		 * @param array $args     Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		public function widget( $args, $instance ) {
			if ( ! isset( $args['widget_id'] ) ) {
				$args['widget_id'] = $this->id;
			}
			$section_title = ! empty( $instance['title'] ) ? $instance['title'] : '';
			$section_title = apply_filters( 'widget_title', $section_title, $instance, $this->id_base );

			echo $args['before_widget'];
			if ( ! empty( $section_title ) ) {
				?>
				<div class="header-title">
					<?php echo $args['before_title'] . esc_html( $section_title ) . $args['after_title']; ?>
				</div>
			<?php } ?>

			<div class="widget-content-area">
				<ul class="categories-list">
					<?php
					$categories = get_categories( array(
						'orderby'    => 'count',
						'order'      => 'DESC',
						'hide_empty' => true,
						'number'     => 6,
					) );
					foreach ( $categories as $category ) {
						$cat_link  = get_category_link( $category->term_id );
						$cat_name  = $category->name;
						$cat_count = $category->count;
						?>
						<li class="category-item">
							<a href="<?php echo esc_url( $cat_link ); ?>" class="category-link">
								<span class="category-name"><?php echo esc_html( $cat_name ); ?></span>
								<span class="category-count">(<?php echo absint( $cat_count ); ?>)</span>
							</a>
						</li>
						<?php
					}
					?>
				</ul>
			</div>

			<?php echo $args['after_widget']; ?>
		}

		/**
		 * Back-end widget form.
		 *
		 * @param array $instance Previously saved values from database.
		 */
		public function form( $instance ) {
			$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Categories', 'news-record' );
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'news-record' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<?php
		}

		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 *
		 * @return array Updated safe values to be saved.
		 */
		public function update( $new_instance, $old_instance ) {
			$instance          = $old_instance;
			$instance['title'] = sanitize_text_field( $new_instance['title'] );
			return $instance;
		}
	}
}