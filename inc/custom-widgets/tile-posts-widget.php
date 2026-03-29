<?php
if ( ! class_exists( 'News_Record_Tile_Posts_Widget' ) ) {
	/**
	 * Adds News Record Tile Widget.
	 */
	class News_Record_Tile_Posts_Widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		public function __construct() {
			$tile_posts_widget = array(
				'classname'   => 'news-record-widget tile-posts-widget',
				'description' => __( 'Retrive Tile Widgets', 'news-record' ),
			);
			parent::__construct(
				'news_record_tile_posts_widget',
				__( 'Artify Widget: Tile Widget', 'news-record' ),
				$tile_posts_widget
			);
		}

		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 *
		 * @param array $args     Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		public function widget( $args, $instance ) {
			if ( ! isset( $args['widget_id'] ) ) {
				$args['widget_id'] = $this->id;
			}
			$tile_posts_title       = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
			$tile_posts_title       = apply_filters( 'widget_title', $tile_posts_title, $instance, $this->id_base );
			$tile_posts_post_offset = isset( $instance['offset'] ) ? absint( $instance['offset'] ) : '';
			$tile_posts_category    = isset( $instance['category'] ) ? absint( $instance['category'] ) : '';

			echo $args['before_widget'];

			if ( ! empty( $tile_posts_title ) ) {
				?>
				<div class="header-title">
					<?php echo $args['before_title'] . esc_html( $tile_posts_title ) . $args['after_title']; ?>
				</div>
			<?php } ?>
			<div class="widget-content-area">

				<?php
				$tile_posts_widgets_args = array(
					'post_type'      => 'post',
					'posts_per_page' => absint( 4 ),
					'offset'         => absint( $tile_posts_post_offset ),
					'cat'            => absint( $tile_posts_category ),
				);

				$query = new WP_Query( $tile_posts_widgets_args );
				if ( $query->have_posts() ) :
					while ( $query->have_posts() ) :
						$query->the_post();
						?>
						<div class="single-card-container tile-card">
							<div class="single-card-image">
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail(); ?>							
								</a>
							</div>
							<div class="single-card-detail">
								<?php news_record_categories_list(); ?>							
								<h3 class="card-title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h3>  
								<div class="card-meta">
									<?php
										news_record_posted_by();
										news_record_posted_on();
									?>
								</div>
							</div>
						</div>
						<?php
					endwhile;
					wp_reset_postdata();
				endif;
				?>

			</div>
			<?php
			echo $args['after_widget'];
		}

		/**
		 * Back-end widget form.
		 *
		 * @see WP_Widget::form()
		 *
		 * @param array $instance Previously saved values from database.
		 */
		public function form( $instance ) {
			$tile_posts_title       = isset( $instance['title'] ) ? $instance['title'] : '';
			$tile_posts_post_offset = isset( $instance['offset'] ) ? absint( $instance['offset'] ) : '';
			$tile_posts_category    = isset( $instance['category'] ) ? absint( $instance['category'] ) : '';
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Section Title:', 'news-record' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $tile_posts_title ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>"><?php esc_html_e( 'Number of posts to displace or pass over:', 'news-record' ); ?></label>
				<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'offset' ) ); ?>" type="number" step="1" min="0" value="<?php echo absint( $tile_posts_post_offset ); ?>" size="3" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"><?php esc_html_e( 'Select the category to show posts:', 'news-record' ); ?></label>
				<select id="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>" class="widefat" style="width:100%;">
					<?php
					$categories = news_record_get_post_cat_choices();
					foreach ( $categories as $category => $value ) {
						?>
						<option value="<?php echo absint( $category ); ?>" <?php selected( $tile_posts_category, $category ); ?>><?php echo esc_html( $value ); ?></option>
					<?php } ?>      
				</select>
			</p>
			<?php
		}

		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @see WP_Widget::update()
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 *
		 * @return array Updated safe values to be saved.
		 */
		public function update( $new_instance, $old_instance ) {
			$instance             = $old_instance;
			$instance['title']    = sanitize_text_field( $new_instance['title'] );
			$instance['offset']   = (int) $new_instance['offset'];
			$instance['category'] = (int) $new_instance['category'];
			return $instance;
		}
	}
}
