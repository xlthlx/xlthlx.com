<?php
/**
 * Return Last-Modified Header.
 */
function wt_last_mod_header() {
	if ( is_singular() ) {
		$post_id = get_queried_object_id();
		if ( $post_id ) {
			header( 'Last-Modified: ' . get_the_modified_time( 'D, d M Y H:i:s',$post_id ) );
		}
	}
}

add_action( 'wp_headers','wt_last_mod_header' );
