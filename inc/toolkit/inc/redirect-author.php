<?php
/**
 * Redirect archives author.
 */
function wt_redirect_archives_author() {
	if ( is_author() ) {
		wp_redirect( home_url(),301 );

		die();
	}
}

add_action( 'template_redirect','wt_redirect_archives_author' );
