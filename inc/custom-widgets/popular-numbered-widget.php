<?php
/**
 * Popular / Latest numbered posts widget.
 *
 * @package News Record
 */

if ( ! class_exists( 'News_Record_Popular_Numbered_Widget' ) ) {
	class News_Record_Popular_Numbered_Widget extends WP_Widget {
		public function __construct() {
			parent::__construct(
				'news_record_popular_numbered_widget',
				esc_html__( 'NR: Popular Numbered Posts', 'news-record' ),
				array( 'description' => esc_html__( 'Shows posts in a numbered list (popular/latest/category/manual).', 'news-record' ) )
			);
		}

		public function widget( $args, $instance ) {
			echo wp_kses_post( $args['before_widget'] );

			$title    = isset( $instance['title'] ) ? $instance['title'] : esc_html__( 'Popular News', 'news-record' );
			$type     = isset( $instance['type'] ) ? $instance['type'] : 'popular';
			$category = isset( $instance['category'] ) ? absint( $instance['category'] ) : 0;
			$count    = isset( $instance['count'] ) ? absint( $instance['count'] ) : 5;
			$post_ids = isset( $instance['post_ids'] ) ? $instance['post_ids'] : '';

			if ( ! empty( $title ) ) {
				echo wp_kses_post( $args['before_title'] . esc_html( $title ) . $args['after_title'] );
			}

			$ids = array();
			if ( 'post' === $type && ! empty( $post_ids ) ) {
				$ids = array_map( 'absint', array_filter( array_map( 'trim', explode( ',', $post_ids ) ) ) );
			}

			$query = news_record_get_section_query(
				array(
					'type'           => $type,
					'posts_per_page' => $count,
					'category'       => $category,
					'post_ids'       => $ids,
				)
			);

			if ( $query->have_posts() ) {
				echo '<ul class="nr-numbered-list">';
				$index = 0;
				foreach ( $query->posts as $post ) {
					news_record_render_numbered_item( $post, $index );
					$index++;
				}
				echo '</ul>';
			}

			wp_reset_postdata();

			echo wp_kses_post( $args['after_widget'] );
		}

		public function form( $instance ) {
			$title    = isset( $instance['title'] ) ? $instance['title'] : esc_html__( 'Popular News', 'news-record' );
			$type     = isset( $instance['type'] ) ? $instance['type'] : 'popular';
			$category = isset( $instance['category'] ) ? absint( $instance['category'] ) : 0;
			$count    = isset( $instance['count'] ) ? absint( $instance['count'] ) : 5;
			$post_ids = isset( $instance['post_ids'] ) ? $instance['post_ids'] : '';
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'news-record' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>"><?php esc_html_e( 'Source:', 'news-record' ); ?></label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'type' ) ); ?>">
					<option value="popular" <?php selected( $type, 'popular' ); ?>><?php esc_html_e( 'Popular (by comments)', 'news-record' ); ?></option>
					<option value="recent" <?php selected( $type, 'recent' ); ?>><?php esc_html_e( 'Latest', 'news-record' ); ?></option>
					<option value="category" <?php selected( $type, 'category' ); ?>><?php esc_html_e( 'By Category', 'news-record' ); ?></option>
					<option value="post" <?php selected( $type, 'post' ); ?>><?php esc_html_e( 'Manual IDs', 'news-record' ); ?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"><?php esc_html_e( 'Category (for By Category):', 'news-record' ); ?></label>
				<?php
				wp_dropdown_categories(
					array(
						'name'             => $this->get_field_name( 'category' ),
						'id'               => $this->get_field_id( 'category' ),
						'class'            => 'widefat',
						'hide_empty'       => false,
						'show_option_all'  => esc_html__( 'All', 'news-record' ),
						'selected'        => $category,
					)
				);
				?>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'post_ids' ) ); ?>"><?php esc_html_e( 'Manual Post IDs (comma separated):', 'news-record' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'post_ids' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'post_ids' ) ); ?>" type="text" value="<?php echo esc_attr( $post_ids ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Number of posts:', 'news-record' ); ?></label>
				<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" step="1" min="1" value="<?php echo esc_attr( $count ); ?>" />
			</p>
			<?php
		}

		public function update( $new_instance, $old_instance ) {
			$instance              = array();
			$instance['title']     = sanitize_text_field( $new_instance['title'] );
			$instance['type']      = sanitize_text_field( $new_instance['type'] );
			$instance['category']  = absint( $new_instance['category'] );
			$instance['count']     = absint( $new_instance['count'] );
			$instance['post_ids']  = sanitize_text_field( $new_instance['post_ids'] );

			return $instance;
		}
	}
}
