<?php
/**
 * Attachment pages redirect.
 */
function wt_attachment_pages_redirect() {
	global $post;

	if ( is_attachment() ) {
		if ( isset( $post->post_parent ) && ( $post->post_parent !== 0 ) ) {
			wp_redirect( get_permalink( $post->post_parent ),301 );
		} else {
			wp_redirect( home_url(),301 );
		}
		exit;
	}
}

add_action( 'template_redirect','wt_attachment_pages_redirect' );
