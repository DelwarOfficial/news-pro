<?php
/**
 * Ad Slot Widget for custom HTML or image ads.
 *
 * @package News Record
 */

if ( ! class_exists( 'News_Record_Ad_Slot_Widget' ) ) {
	class News_Record_Ad_Slot_Widget extends WP_Widget {
		public function __construct() {
			parent::__construct(
				'news_record_ad_slot_widget',
				esc_html__( 'NR: Ad Slot', 'news-record' ),
				array( 'description' => esc_html__( 'Display a custom ad image or HTML.', 'news-record' ) )
			);
		}

		public function widget( $args, $instance ) {
			echo wp_kses_post( $args['before_widget'] );

            $title      = isset( $instance['title'] ) ? $instance['title'] : '';
            $image      = isset( $instance['image'] ) ? $instance['image'] : '';
            $link       = isset( $instance['link'] ) ? $instance['link'] : '';
            $customhtml = isset( $instance['customhtml'] ) ? $instance['customhtml'] : '';

			if ( ! empty( $title ) ) {
				echo wp_kses_post( $args['before_title'] . esc_html( $title ) . $args['after_title'] );
			}

			if ( ! empty( $customhtml ) ) {
				echo wp_kses_post( $customhtml );
			} elseif ( ! empty( $image ) ) {
				$img  = sprintf( '<img src="%1$s" alt="%2$s" />', esc_url( $image ), esc_attr( $title ) );
				$link = esc_url( $link );
				if ( $link ) {
					echo '<a class="nr-ad-slot" href="' . $link . '" target="_blank" rel="noopener">' . $img . '</a>';
				} else {
					echo '<div class="nr-ad-slot">' . $img . '</div>';
				}
			}

			echo wp_kses_post( $args['after_widget'] );
		}

		public function form( $instance ) {
			$title      = isset( $instance['title'] ) ? $instance['title'] : '';
			$image      = isset( $instance['image'] ) ? $instance['image'] : '';
			$link       = isset( $instance['link'] ) ? $instance['link'] : '';
			$customhtml = isset( $instance['customhtml'] ) ? $instance['customhtml'] : '';
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'news-record' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>"><?php esc_html_e( 'Ad Image URL:', 'news-record' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>" type="text" value="<?php echo esc_attr( $image ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>"><?php esc_html_e( 'Ad Link URL:', 'news-record' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link' ) ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'customhtml' ) ); ?>"><?php esc_html_e( 'Custom HTML (overrides image):', 'news-record' ); ?></label>
				<textarea class="widefat" rows="4" id="<?php echo esc_attr( $this->get_field_id( 'customhtml' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'customhtml' ) ); ?>"><?php echo esc_textarea( $customhtml ); ?></textarea>
			</p>
			<?php
		}

		public function update( $new_instance, $old_instance ) {
			$instance               = array();
			$instance['title']      = sanitize_text_field( $new_instance['title'] );
			$instance['image']      = esc_url_raw( $new_instance['image'] );
			$instance['link']       = esc_url_raw( $new_instance['link'] );
			$instance['customhtml'] = wp_kses_post( $new_instance['customhtml'] );

			return $instance;
		}
	}
}
