<?php
/**
 * Redirect author archive.
 *
 * @package  xlthlx
 */

/**
 * Redirect archives author.
 */
function xlt_redirect_archives_author() {
	if ( is_author() ) {
		wp_redirect( home_url(), 301 );

		die();
	}
}

add_action( 'template_redirect', 'xlt_redirect_archives_author' );
