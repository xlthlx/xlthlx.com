<?php
/**
 * Custom login.
 *
 * @package  xlthlx
 */

add_action( 'wp_head', 'ob_start', 1, 0 );
$wp_login_php = false;
$wt_login     = 'entra';

/**
 * Check if an url uses trailing slashes.
 *
 * @return bool
 */
function wt_use_trailing_slashes() {
	return '/' === substr( get_option( 'permalink_structure' ), - 1, 1 );
}

/**
 * Adds trailing slashes to url.
 *
 * @param string $string The url.
 *
 * @return string
 */
function wt_user_trailingslashit( $string ) {
	return wt_use_trailing_slashes() ? trailingslashit( $string ) : untrailingslashit( $string );
}

/**
 * No idea.
 *
 * @return void
 */
function wt_plugins_loaded() {
	global $pagenow,$wt_login,$wp_login_php;

	$request = parse_url( $_SERVER['REQUEST_URI'] );

	if ( ! is_admin() && ( strpos( $_SERVER['REQUEST_URI'], 'wp-login.php' ) !== false || ( isset( $request['path'] ) && untrailingslashit( $request['path'] ) === site_url( 'wp-login', 'relative' ) ) ) ) {
		$wp_login_php           = true;
		$_SERVER['REQUEST_URI'] = wt_user_trailingslashit(
			'/' . str_repeat(
				'-/',
				10
			)
		);
		// @codingStandardsIgnoreStart
		$pagenow = 'index.php';
		// @codingStandardsIgnoreEnd

	} elseif ( ( ! get_option( 'permalink_structure' ) && isset( $_GET['wt_login'] ) && empty( $_GET['wt_login'] ) ) || ( isset( $request['path'] ) && untrailingslashit( $request['path'] ) === home_url( $wt_login, 'relative' ) ) ) {

		// @codingStandardsIgnoreStart
		$pagenow = 'wp-login.php';
		// @codingStandardsIgnoreEnd
	}
}

add_action( 'after_setup_theme', 'wt_plugins_loaded', 1 );

/**
 * Redirects to 404 the wp-admin folder if user is not logged in.
 *
 * @return void
 */
function wt_wp_loaded() {
	global $pagenow,$wp_login_php;

	if ( ! defined( 'DOING_AJAX' ) && is_admin() && ! is_user_logged_in() ) {
		global $wp_query;
		$wp_query->set_404();
		status_header( 404 );
		get_template_part( 404 );
		exit();
	}

	$request = parse_url( $_SERVER['REQUEST_URI'] );

	if ( 'wp-login.php' === $pagenow && wt_user_trailingslashit( $request['path'] ) !== $request['path'] && get_option( 'permalink_structure' ) ) {
		wp_safe_redirect( wt_user_trailingslashit( wt_new_login_url() ) . ( ! empty( $_SERVER['QUERY_STRING'] ) ? '?' . $_SERVER['QUERY_STRING'] : '' ) );
		die;
	}

	if ( $wp_login_php ) {
		$referer   = wp_get_referer();
		$i_referer = parse_url( $referer );
		if ( false !== strpos( $referer, 'wp-activate.php' ) && ! empty( $i_referer['query'] )
		) {
			parse_str( $referer['query'], $referer );

			$result = wpmu_activate_signup( $referer['key'] );
			if ( ! empty( $referer['key'] ) && is_wp_error( $result ) && (
					$result->get_error_code() === 'already_active' ||
					$result->get_error_code() === 'blog_taken'
				) ) {
				wp_safe_redirect( wt_new_login_url() . ( ! empty( $_SERVER['QUERY_STRING'] ) ? '?' . $_SERVER['QUERY_STRING'] : '' ) );
				die;
			}
		}

		wt_wp_template_loader();
	} elseif ( 'wp-login.php' === $pagenow ) {

		require ABSPATH . 'wp-login.php';
		die;
	}
}

add_action( 'wp_loaded', 'wt_wp_loaded' );

/**
 * No idea.
 *
 * @return void
 */
function wt_wp_template_loader() {
	global $pagenow;

	// @codingStandardsIgnoreStart
	$pagenow = 'index.php';
	// @codingStandardsIgnoreEnd

	if ( ! defined( 'WP_USE_THEMES' ) ) {
		define( 'WP_USE_THEMES', true );
	}

	wp();

	if ( wt_user_trailingslashit( str_repeat( '-/', 10 ) ) === $_SERVER['REQUEST_URI'] ) {
		$_SERVER['REQUEST_URI'] = wt_user_trailingslashit( '/wp-login-php/' );
	}

	require_once ABSPATH . WPINC . '/template-loader.php';

	die;
}

/**
 * Filter login.
 *
 * @param string      $url The complete site URL including scheme and path.
 * @param string|null $scheme Scheme to give the site URL context. Accepts 'http', 'https', 'login', 'login_post', 'admin', 'relative' or null.
 *
 * @return string
 */
function wt_filter_wp_login_php( $url, $scheme = null ) {
	if ( strpos( $url, 'wp-login.php' ) !== false ) {
		if ( is_ssl() ) {
			$scheme = 'https';
		}

		$args = explode( '?', $url );

		if ( isset( $args[1] ) ) {
			parse_str( $args[1], $args );
			$url = add_query_arg( $args, wt_new_login_url( $scheme ) );
		} else {
			$url = wt_new_login_url( $scheme );
		}
	}

	return $url;
}

/**
 * Filters the site URL.
 *
 * @param string      $url The complete site URL including scheme and path.
 * @param string      $path Path relative to the site URL. Blank string if no path is specified.
 * @param string|null $scheme Scheme to give the site URL context. Accepts 'http', 'https', 'login', 'login_post', 'admin', 'relative' or null.
 *
 * @return string
 */
function wt_site_url( $url, $path, $scheme ) {
	return wt_filter_wp_login_php( $url, $scheme );
}

add_filter( 'site_url', 'wt_site_url', 10, 4 );

/**
 * Redirects to the login.
 *
 * @param string $location The path or URL to redirect to.
 *
 * @return string
 */
function wt_wp_redirect( $location ) {
	return wt_filter_wp_login_php( $location );
}

add_filter( 'wp_redirect', 'wt_wp_redirect' );

/**
 * Sets new login url.
 *
 * @param string|null $scheme Scheme to give the site URL context.
 *
 * @return string
 */
function wt_new_login_url( $scheme = null ) {
	global $wt_login;
	if ( get_option( 'permalink_structure' ) ) {
		return wt_user_trailingslashit(
			home_url(
				'/',
				$scheme
			) . $wt_login
		);
	}

	return home_url( '/', $scheme ) . '?' . $_GET['wt_login'];
}

/**
 * Replace the url into the welcome email.
 *
 * @param string $value Value of network option.
 *
 * @return string|string[]
 */
function wt_welcome_email( $value ) {
	global $wt_login;

	return str_replace(
		'wp-login.php',
		trailingslashit( $wt_login['wt_login'] ),
		$value
	);
}

add_filter( 'site_option_welcome_email', 'wt_welcome_email' );

/**
 * Removes the 'admin-bar' class from body.
 *
 * @param string[] $wp_classes An array of body class names.
 * @param string[] $extra_classes An array of additional class names added to the body.
 *
 * @return array
 */
function wt_admin_bar_body_class( $wp_classes, $extra_classes ) {

	if ( ( is_404() ) && ( ! is_user_logged_in() ) ) {
		$wp_nobar_classes = array_diff( $wp_classes, array( 'admin-bar' ) );

		// Add the extra classes back untouched.
		return array_merge( $wp_nobar_classes, (array) $extra_classes );
	}

	return $wp_classes;

}

add_filter( 'body_class', 'wt_admin_bar_body_class', 10, 2 );

remove_action( 'template_redirect', 'wp_redirect_admin_locations', 1000 );
