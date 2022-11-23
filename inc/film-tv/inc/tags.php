<?php
/**
 * Custom tags form film/tv.
 *
 * @package  xlthlx
 */

if ( ! function_exists( 'xlt_get_thumb_img' ) ) {
	/**
	 * Returns the HTML for the film and tv series image.
	 *
	 * @param int    $id
	 * @param string $alt
	 *
	 * @return string
	 */
	function xlt_get_thumb_img( $id, $alt ) {
		return wp_get_attachment_image(
			$id,
			array( '250', '370' ),
			false,
			array(
				'class'   => 'img-fluid float-start me-4',
				'alt'     => $alt,
				'loading' => false,
			)
		);
	}
}

if ( ! function_exists( 'xlt_get_all_film_tv' ) ) {
	/**
	 * Returns an array with years and objects.
	 *
	 * @param $post_type
	 * @param $lang
	 *
	 * @return array
	 * @throws Exception
	 */
	function xlt_get_all_film_tv( $post_type, $lang ) {

		$output = array();
		$i      = 0;

		$years = get_terms(
			array(
				'taxonomy' => 'year',
				'orderby'  => 'name',
				'order'    => 'DESC',
			)
		);

		if ( ! empty( $years ) && ! is_wp_error( $years ) ) {
			foreach ( $years as $year ) {
				$args = array(
					'post_type' => $post_type,
					'tax_query' => array(
						array(
							'taxonomy' => 'year',
							'field'    => 'slug',
							'terms'    => array( $year->slug ),
							'operator' => 'IN',
						),
					),
				);

				$the_query = new WP_Query( $args );

				if ( $the_query->have_posts() ) {

					while ( $the_query->have_posts() ) {
						$the_query->the_post();

						$output[ $i ]['image'] = false;

						if ( get_post_thumbnail_id( get_the_ID() ) ) {
							$output[ $i ]['image'] = xlt_get_thumb_img( get_post_thumbnail_id( get_the_ID() ), get_the_title() );
						}

						$output[ $i ]['title']    = get_the_title();
						$output[ $i ]['link']     = ( 'en' === $lang ) ? get_post_meta( get_the_ID(), 'link_en', true ) : get_post_meta( get_the_ID(), 'link', true );
						$output[ $i ]['year']     = $year->name;
						$output[ $i ]['internal'] = get_post_meta( get_the_ID(), 'internal', true );

						$directors                 = get_the_terms( get_the_ID(), 'director' );
						$output[ $i ]['directors'] = false;

						if ( ! empty( $directors ) && ! is_wp_error( $directors ) ) {
							$directors                 = wp_list_pluck( $directors, 'name' );
							$output[ $i ]['directors'] = implode( ', ', $directors );
						}

						$starring                 = get_the_terms( get_the_ID(), 'actor' );
						$output[ $i ]['starring'] = false;

						if ( ! empty( $starring ) && ! is_wp_error( $starring ) ) {
							$starring                 = wp_list_pluck( $starring, 'name' );
							$output[ $i ]['starring'] = implode( ', ', $starring );
						}

						$output[ $i ]['content'] = ( 'en' === $lang ) ? get_content_en() : apply_filters( 'the_content', get_the_content() );

						$i ++;
					}
				}

				wp_reset_postdata();
			}
		}

		return $output;
	}
}
