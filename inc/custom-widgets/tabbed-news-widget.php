<?php
if ( ! class_exists( 'News_Record_Tabbed_News_Widget' ) ) {
	/**
	 * Adds News Record Tabbed News Widget.
	 */
	class News_Record_Tabbed_News_Widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		public function __construct() {
			$news_record_tabbed_news_widget = array(
				'classname'   => 'news-record-widget tabbed-news-widget',
				'description' => __( 'Display tabbed news sections', 'news-record' ),
			);
			parent::__construct(
				'news_record_tabbed_news_widget',
				__( 'Artify Widget: Tabbed News', 'news-record' ),
				$news_record_tabbed_news_widget
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
				<div class="tabbed-news-container">
					<div class="tabbed-news-tabs">
						<button class="tab-button active" data-tab="recent"><?php esc_html_e( 'Recent', 'news-record' ); ?></button>
						<button class="tab-button" data-tab="popular"><?php esc_html_e( 'Popular', 'news-record' ); ?></button>
						<button class="tab-button" data-tab="trending"><?php esc_html_e( 'Trending', 'news-record' ); ?></button>
					</div>
					<div class="tabbed-news-content">
						<div class="tab-panel active" id="recent">
							<?php $this->display_posts( 'date', 4 ); ?>
						</div>
						<div class="tab-panel" id="popular">
							<?php $this->display_posts( 'comment_count', 4 ); ?>
						</div>
						<div class="tab-panel" id="trending">
							<?php $this->display_posts( 'rand', 4 ); ?>
						</div>
					</div>
				</div>
			</div>

			<?php echo $args['after_widget']; ?>
		}

		/**
		 * Display posts for a tab.
		 *
		 * @param string $orderby Order by parameter.
		 * @param int    $number  Number of posts.
		 */
		private function display_posts( $orderby, $number ) {
			$query = new WP_Query( array(
				'post_type'      => 'post',
				'posts_per_page' => $number,
				'orderby'        => $orderby,
				'order'          => 'DESC',
			) );

			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();
					echo '<div class="tabbed-news-item">';
					echo '<a href="' . esc_url( get_permalink() ) . '" class="tabbed-news-link">';
					if ( has_post_thumbnail() ) {
						echo '<div class="tabbed-news-thumb">';
						the_post_thumbnail( 'thumbnail' );
						echo '</div>';
					}
					echo '<div class="tabbed-news-detail">';
					echo '<h4 class="tabbed-news-title">' . get_the_title() . '</h4>';
					echo '<span class="tabbed-news-date">' . get_the_date() . '</span>';
					echo '</div>';
					echo '</a>';
					echo '</div>';
				}
				wp_reset_postdata();
			}
		}

		/**
		 * Back-end widget form.
		 *
		 * @param array $instance Previously saved values from database.
		 */
		public function form( $instance ) {
			$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Tabbed News', 'news-record' );
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