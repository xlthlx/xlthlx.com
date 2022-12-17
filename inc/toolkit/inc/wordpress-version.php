<?php
/**
 * Remove WordPress version.
 *
 * @package  xlthlx
 */

/**
 * Starts.
 *
 * @return void
 */
function xlt_clean_meta_generators() {
	ob_start( 'xlt_replace_meta_generators' );
}

/**
 * Replace <meta .* name="generator"> like tags
 * which may contain version of.
 *
 * @param string $html Meta HTML.
 *
 * @return string
 */
function xlt_replace_meta_generators( $html ) {
	$raw_html = $html;

	$pattern = '/<meta[^>]+name=["\']generator["\'][^>]+>/i';
	$html    = preg_replace( $pattern, '', $html );

	if ( empty( $html ) ) {
		return $raw_html;
	}

	return $html;
}

/**
 * Remove WordPress version.
 *
 * @return void
 */
function xlt_remove_wordpress_version() {

	remove_action( 'wp_head', 'wp_generator' );
	add_filter( 'the_generator', '__return_empty_string' );

	add_action( 'wp_head', 'xlt_clean_meta_generators', 100 );
}

if ( ! is_admin() ) {
	add_action( 'init', 'xlt_remove_wordpress_version' );
}
