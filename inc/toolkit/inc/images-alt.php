<?php
/**
 * Add post title in image alt attribute.
 *
 * @param $content
 *
 * @return mixed
 */
function wt_add_image_alt( $content ) {
	global $post;

	if ( $post === null ) {
		return $content;
	}

	$old_content = $content;

	preg_match_all( '/<img[^>]+>/',$content,$images );

	if ( $images !== null ) {
		foreach ( $images[0] as $index => $value ) {
			if ( ! preg_match( '/alt=/',$value ) ) {
				$new_img = str_replace( '<img','<img alt="' . esc_attr( $post->post_title ) . '"',
					$images[0][ $index ] );
				$content = str_replace( $images[0][ $index ],$new_img,$content );
			} elseif ( preg_match( '/alt=[\s"\']{2,3}/',$value ) ) {
				$new_img = preg_replace( '/alt=[\s"\']{2,3}/','alt="' . esc_attr( $post->post_title ) . '"',
					$images[0][ $index ] );
				$content = str_replace( $images[0][ $index ],$new_img,$content );
			}
		}
	}

	if ( empty( $content ) ) {
		return $old_content;
	}

	return $content;
}

/**
 * Setting attributes for post thumbnails.
 *
 * @param $attr
 * @param $attachment
 *
 * @return mixed
 */
function wt_change_image_attr( $attr,$attachment ) {

	$parent = get_post_field( 'post_parent',$attachment );

	$title = get_post_field( 'post_title',$parent );
	if ( '' === $attr['alt'] ) {
		$attr['alt'] = $title;
	}
	$attr['title'] = $title;

	return $attr;
}

add_filter( 'the_content','wt_add_image_alt',9999 );
add_filter( 'wp_get_attachment_image_attributes','wt_change_image_attr',20,2 );
