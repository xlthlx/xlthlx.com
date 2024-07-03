<?php
/**
 * Auto Remove Media.
 *
 * @package  xlthlx
 */

/**
 * Find where the media is used.
 *
 * Find where the media is used and return an array with all the IDs of
 * posts, pages and custom post types that use it either as a Featured Image,
 * or inline, in the main content.
 *
 * @param int $attachment_id ID of the current attachment.
 */
function xlt_media_used_in( $attachment_id ) {
	$results            = array();
	$attachment_used_in = array();
	$attachment_urls    = array(
		wp_get_original_image_url( $attachment_id ),
		wp_get_attachment_url( $attachment_id ),
	);
	$attachment_urls    = array_filter( $attachment_urls );

	// If the attachment is an image, find where it's used as a Featured Image.
	if ( wp_attachment_is_image( $attachment_id ) ) {
		$args = array(
			'post_type'              => 'any',
			'post_status'            => array( 'any', 'publish', 'private', 'pending', 'future', 'draft', 'trash' ),
			'meta_key'               => '_thumbnail_id',    // phpcs:ignore
			'meta_value'             => $attachment_id,     // phpcs:ignore
			'posts_per_page'         => - 1,
			'nopaging'               => true,
			'fields'                 => 'ids',
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		);

		$query     = new WP_Query( $args );
		$results[] = $query->posts;
	}

	$results            = array_merge( [], ...$results );
	$attachment_used_in = array_merge( $attachment_used_in, $results );

	// If the attachment is an image, find the URLs for all intermediate sizes.
	if ( wp_attachment_is_image( $attachment_id ) ) {
		foreach ( get_intermediate_image_sizes() as $size ) {
			$intermediate_size = image_get_intermediate_size( $attachment_id, $size );

			if ( $intermediate_size ) {
				$attachment_urls[] = $intermediate_size['url'];
			}
		}
	}

	// Find where the attachment URLs are used.
	foreach ( $attachment_urls as $attachment_url ) {
		$args = array(
			'post_type'              => 'any',
			'post_status'            => array( 'any', 'publish', 'private', 'pending', 'future', 'draft', 'trash' ),
			's'                      => $attachment_url,
			'posts_per_page'         => - 1,
			'nopaging'               => true,
			'fields'                 => 'ids',
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		);

		$query     = new WP_Query( $args );
		$results[] = $query->posts;
	}

	$results            = array_merge( [], ...$results );
	$attachment_used_in = array_merge( $attachment_used_in, $results );
	$attachment_used_in = array_unique( $attachment_used_in );
	$attachment_used_in = array_filter( $attachment_used_in );

	return array_values( $attachment_used_in );
}

/**
 * Remove media.
 *
 * Get the list of media for the post we are about to delete and if the media
 * are not reused, remove them.
 *
 * @param int $post_id ID of the current post.
 *
 * @since 1.0.0
 */
function xlt_remove_media( $post_id ) {
	$post_id = (int) $post_id;

	if ( $post_id ) {
		$additional_checks = 'enabled';

		$args  = array(
			'post_type'              => 'attachment',
			'post_parent'            => $post_id,
			'post_status'            => 'any',
			'posts_per_page'         => - 1,
			'nopaging'               => true,
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		);

		$query = new WP_Query( $args );

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();

				switch ( $additional_checks ) {
					case 'enabled':
						$attachment_used_in = xlt_media_used_in( $query->post->ID );

						// Remove current parent ID and normalize array.
						if ( in_array( $post_id, $attachment_used_in, true ) ) {
							unset( $attachment_used_in[ array_search( $post_id, $attachment_used_in, true ) ] );
							$attachment_used_in = array_values( $attachment_used_in );    // Make consecutive keys.
						}

						// Change the parent ID if the attachment is reused. Delete otherwise.
						if ( ! empty( $attachment_used_in ) ) {
							$args = array(
								'ID'          => $query->post->ID,
								'post_parent' => $attachment_used_in[0],
							);
							wp_update_post( $args );
						} else {
							wp_delete_attachment( $query->post->ID, true );
						}
						break;


					default:
						wp_delete_attachment( $query->post->ID, true );
						break;
				}
			}
		}

		wp_reset_postdata();
	}
}

add_action( 'before_delete_post', 'xlt_remove_media' );
