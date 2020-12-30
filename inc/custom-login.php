<?php
/**
 * Custom login
 */

add_action( 'login_enqueue_scripts', 'xm_enqueue_login', 10 );
add_filter( 'login_headerurl', 'xm_login_url' );
add_filter( 'login_headertext', 'xm_login_title' );
add_action( 'login_head', 'xm_login_head' );
add_action( 'init', 'xm_login_classes' );
add_filter( 'login_title', 'xm_login_page_title', 99 );
remove_filter( 'authenticate', 'wp_authenticate_username_password', 20 );
add_filter( 'authenticate', 'xm_authenticate', 20, 3 );

/**
 * Enqueue login CSS.
 */
function xm_enqueue_login() {
	$css_path = get_template_directory_uri() . '/assets/css/';

	wp_enqueue_style( 'bootstrap', $css_path . 'bootstrap.min.css', false, '', 'screen,print' );
	wp_enqueue_style( 'mdb', $css_path . 'mdb.min.css', array( 'bootstrap' ), '', 'screen,print' );
	wp_enqueue_style( 'style', get_stylesheet_uri(), false, '', 'screen,print' );
	wp_enqueue_style( 'custom-login', $css_path . 'admin/login.min.css', false, '', 'screen,print' );
	wp_enqueue_script( 'jquery-login', includes_url( '/js/jquery/jquery.js' ), false, '', false );
}

/**
 * Change the header url into login.
 *
 * @return mixed
 */
function xm_login_url() {
	return get_home_url();
}

/**
 * Change the header title into login.
 *
 * @return mixed
 */
function xm_login_title() {
	return get_bloginfo( 'name' ) . '</a></h1><p class="desc"><em>' . get_bloginfo( 'description' ) . '</em></p><h1 style="display:none"><a>';
}

/**
 * Change some text strings into login.
 *
 * @param $translation
 * @param $login_texts
 * @param $domain
 *
 * @return string
 */
function xm_gettext( $translation, $login_texts, $domain ) {

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
 * Init filter strings.
 */
function xm_login_head() {
	add_filter( 'gettext', 'xm_gettext', 20, 3 );
}

/**
 * Add some classes to login fields.
 */
function xm_login_classes_footer() {
	echo "<script>
		        jQuery('#loginform').addClass('md-form');
		        jQuery('#lostpasswordform').addClass('md-form');
		        jQuery('#resetpassform').addClass('md-form');
		        jQuery('#user_login').removeClass('input').addClass('form-control');
		        jQuery('#user_pass').removeClass('input').addClass('form-control');
		        jQuery('#wp-submit').removeClass('button button-primary button-large').addClass('btn btn-outline-primary waves-effect btn-sm');
			</script>";
}

/**
 * Init script for classes.
 */
function xm_login_classes() {
	add_filter( 'login_footer', 'xm_login_classes_footer' );
}

/**
 * Change login title.
 *
 * @return string
 */
function xm_login_page_title() {

	return 'Entra | ' . get_bloginfo( 'name' );

}

/**
 * Force the login with email.
 *
 * @param $user
 * @param $username
 * @param $password
 *
 * @return bool|WP_Error|WP_User
 */
function xm_authenticate( $user, $username, $password ) {
	if ( $user instanceof WP_User ) {
		return $user;
	}

	if ( ! empty( $username ) && is_email( $username ) ) {
		$user = get_user_by( 'email', $username );
		if ( isset( $user, $user->user_login, $user->user_status ) ) {
			if ( 0 === (int) $user->user_status ) {
				$username = $user->user_login;

				return wp_authenticate_username_password( null, $username, $password );
			}
		}
	}

	if ( ! empty( $username ) || ! empty( $password ) ) {
		return false;
	} else {
		return wp_authenticate_username_password( null, "", "" );
	}
}
