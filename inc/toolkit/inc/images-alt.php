<?php
/**
 * Add image alt attribute.
 * It search into the content for images, and add the alt tag
 * with the alt content, or with the title content, or it just add it empty.
 *
 * @param string $content The post content.
 *
 * @return string The post content filtered.
 */
function xlt_add_image_alt( string $content ): string {
	global $post;

	if ( $post === null ) {
		return $content;
	}

	$old_content = $content;
	preg_match_all( '/<img[^>]+>/', $content, $images );

	if ( $images !== null ) {
		foreach ( $images[0] as $index => $value ) {
			if ( ! preg_match( '/alt=/', $value ) ) {
				global $wpdb;

				preg_match_all( '/<img [^>]*src="([^"]+)"[^>]*>/m', $value, $urls, PREG_SET_ORDER );

				$attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE guid='%s';",
					$urls[0][1] ) );
				$attachment = get_post( $attachment[0] );
				$alt        = get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true );
				$title      = $attachment->post_title;

				$new_img = str_replace( '<img', '<img alt=""', $images[0][ $index ] );

				if ( '' !== $alt ) {
					$new_img = str_replace(
						'<img',
						'<img alt="' . $alt . '"',
						$images[0][ $index ]
					);
				}

				if ( '' === $alt && '' !== $title ) {
					$new_img = str_replace(
						'<img',
						'<img alt="' . $title . '"',
						$images[0][ $index ]
					);
				}

				$content = str_replace( $images[0][ $index ], $new_img, $content );
			}
		}
	}

	if ( empty( $content ) ) {
		return $old_content;
	}

	return $content;
}

add_filter( 'the_content', 'xlt_add_image_alt', 9999 );

/**
 * Setting attributes for post thumbnails.
 *
 * @param $attr
 * @param $attachment
 *
 * @return mixed
 */
function wt_change_image_attr( $attr, $attachment ) {

	$parent = get_post_field( 'post_parent', $attachment );

	$title = get_post_field( 'post_title', $parent );
	if ( '' === $attr['alt'] ) {
		$attr['alt'] = $title;
	}
	$attr['title'] = $title;

	return $attr;
}

add_filter( 'the_content', 'wt_add_image_alt', 9999 );
add_filter( 'wp_get_attachment_image_attributes', 'wt_change_image_attr', 20, 2 );
