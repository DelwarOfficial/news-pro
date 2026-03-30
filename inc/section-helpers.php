<?php

/**
 * Section and widget helper functions.
 *
 * @package News Record
 */

if ( ! function_exists( 'news_record_build_section_query_args' ) ) {
	/**
	 * Normalize WP_Query args for sections/widgets.
	 *
	 * @param array $args Input options.
	 * @return array
	 */
	function news_record_build_section_query_args( $args = array() ) {
		$defaults = array(
			'type'        => 'recent',
			'posts_per_page' => 6,
			'post_ids'    => array(),
			'category'    => 0,
			'orderby'     => 'date',
		);

		$args = wp_parse_args( $args, $defaults );

		$query_args = array(
			'post_type'           => 'post',
			'ignore_sticky_posts' => true,
			'posts_per_page'      => absint( $args['posts_per_page'] ),
		);

		switch ( $args['type'] ) {
			case 'post':
				if ( ! empty( $args['post_ids'] ) ) {
					$query_args['post__in'] = array_map( 'absint', (array) $args['post_ids'] );
					$query_args['orderby']  = 'post__in';
				}
				break;

			case 'category':
				$query_args['cat']     = absint( $args['category'] );
				$query_args['orderby'] = $args['orderby'];
				break;

			case 'popular':
				$query_args['orderby'] = 'comment_count';
				break;

			case 'recent':
			default:
				$query_args['orderby'] = 'date';
				break;
		}

		return $query_args;
	}
}

if ( ! function_exists( 'news_record_get_section_query' ) ) {
	/**
	 * Build a WP_Query instance using normalized args.
	 *
	 * @param array $args Options for the query.
	 * @return WP_Query
	 */
	function news_record_get_section_query( $args = array() ) {
		return new WP_Query( news_record_build_section_query_args( $args ) );
	}
}
