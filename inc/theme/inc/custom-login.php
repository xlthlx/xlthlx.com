<?php
/**
 * Custom login.
 *
 * @package  xlthlx
 */

remove_filter( 'authenticate', 'wp_authenticate_username_password', 20 );

/**
 * Enqueue login CSS.
 */
function xlt_enqueue_login() {
	wp_dequeue_style( 'login' );
	wp_deregister_style( 'login' );

	wp_enqueue_style( 'custom-login', get_template_directory_uri() . '/assets/css/admin/login.min.css', array(), filemtime( get_template_directory() . '/assets/css/admin/login.min.css' ) );
	wp_enqueue_script( 'custom-login', get_template_directory_uri() . '/assets/js/admin/login.min.js', array(), filemtime( get_template_directory() . '/assets/js/admin/login.min.js' ), true );
}

add_action( 'login_enqueue_scripts', 'xlt_enqueue_login', 10 );

/**
 * Change the header url into login.
 *
 * @return string
 */
function xlt_login_url() {
	return get_home_url();
}

add_filter( 'login_headerurl', 'xlt_login_url' );

/**
 * Change the header title into login.
 *
 * @return string
 */
function xlt_login_title() {
	return get_bloginfo( 'name' ) . '</a></h1><p class="desc"><em>' . get_bloginfo( 'description' ) . '</em></p><h1 style="display:none"><a>';
}

add_filter( 'login_headertext', 'xlt_login_title' );

/**
 * Change some text strings into login.
 *
 * @param $translation
 * @param $login_texts
 * @param $domain
 *
 * @return string
 */
function xlt_gettext( $translation, $login_texts, $domain ) {

	// Login Main Page
	if ( 'Username or Email Address' === $login_texts ) {
		return 'Email';
	} // Username Label
	if ( 'Log In' === $login_texts ) {
		return 'Entra';
	} // Login Button
	if ( 'Lost your password?' === $login_texts ) {
		return 'Ho dimenticato la password';
	} // Lost Password Link
	if ( 'Get New Password' === $login_texts ) {
		return 'Invia';
	} // Button
	if ( 'Reset Password' === $login_texts ) {
		return 'Cambia';
	} // Button

	return $translation;

}

/**
 * Init filter strings and add fonts.
 */
function xlt_login_head() {
	add_filter( 'gettext', 'xlt_gettext', 20, 3 );
	?>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono&family=Shadows+Into+Light&family=Titillium+Web&display=swap" rel="stylesheet">
	<?php
}

add_action( 'login_head', 'xlt_login_head' );



/**
 * Change login title.
 *
 * @return string
 */
function xlt_login_page_title() {

	return 'Login | ' . get_bloginfo( 'name' );

}

add_filter( 'login_title', 'xlt_login_page_title', 99 );

/**
 * Force the login with email.
 *
 * @param $user
 * @param $username
 * @param $password
 *
 * @return bool|WP_Error|WP_User
 */
function xlt_authenticate( $user, $username, $password ) {
	if ( $user instanceof WP_User ) {
		return $user;
	}

	if ( ! empty( $username ) && is_email( $username ) ) {
		$user = get_user_by( 'email', $username );
		if ( isset( $user, $user->user_login, $user->user_status ) ) {
			if ( 0 === (int) $user->user_status ) {
				$username = $user->user_login;

				return wp_authenticate_username_password(
					null,
					$username,
					$password
				);
			}
		}
	}

	if ( ! empty( $username ) || ! empty( $password ) ) {
		return false;
	}

	return wp_authenticate_username_password( null, '', '' );
}

add_filter( 'authenticate', 'xlt_authenticate', 20, 3 );
