<?php
/**
 * Disable REST API.
 *
 * @package  xlthlx
 */

/**
 * Disable REST API only for non-logged-in users.
 *
 * @param string $access No idea.
 *
 * @return WP_Error
 */
function xlt_disable_wp_rest_api( $access ) {

	if ( ! is_user_logged_in() ) {
		$message = apply_filters(
			'disable_wp_rest_api_error',
			__( 'REST API restricted to authenticated users.', 'xlthlx' )
		);

		return new WP_Error(
			'rest_login_required',
			$message,
			array( 'status' => rest_authorization_required_code() )
		);
	}

	return $access;
}

/**
 * Disable WordPress REST API.
 *
 * @return void
 */
function xlt_disable_rest_api() {

	remove_action( 'template_redirect', 'rest_output_link_header', 11 );
	remove_action( 'wp_head', 'rest_output_link_wp_head' );
	remove_action( 'xmlrpc_rsd_apis', 'rest_output_rsd' );

	add_filter( 'rest_authentication_errors', 'xlt_disable_wp_rest_api' );
}

if ( ! is_admin() ) {
	add_action( 'init', 'xlt_disable_rest_api' );
}
