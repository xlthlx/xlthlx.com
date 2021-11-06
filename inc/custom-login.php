<?php
/**
 * Custom login.
 *
 * @package  WordPress
 * @subpackage  Xlthlx
 */

remove_filter( 'authenticate', 'wp_authenticate_username_password', 20 );

/**
 * Enqueue login CSS.
 */
function xlt_enqueue_login() {
	wp_dequeue_style( 'login' );
	wp_deregister_style( 'login' );
	wp_enqueue_style( 'dashicons' );

	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/vendor/twbs/bootstrap/dist/css/bootstrap.css', [], filemtime( get_template_directory() . '/assets/vendor/twbs/bootstrap/dist/css/bootstrap.css' ) );
	wp_enqueue_style( 'custom-login', get_template_directory_uri() . '/assets/css/admin/login.css', [], filemtime( get_template_directory() . '/assets/css/admin/login.css' ) );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/vendor/twbs/bootstrap/dist/js/bootstrap.bundle.js', [], filemtime( get_template_directory() . '/assets/vendor/twbs/bootstrap/dist/js/bootstrap.bundle.js' ), true );
}

add_action( 'login_enqueue_scripts', 'xlt_enqueue_login', 10 );

/**
 * Change the header url into login.
 *
 * @return mixed
 */
function xlt_login_url() {
	return get_home_url();
}

add_filter( 'login_headerurl', 'xlt_login_url' );

/**
 * Change the header title into login.
 *
 * @return mixed
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
 * Init filter strings.
 */
function xlt_login_head() {
	add_filter( 'gettext', 'xlt_gettext', 20, 3 );
}

add_action( 'login_head', 'xlt_login_head' );

/**
 * Init script for classes.
 */
function xlt_login_classes() {
	add_filter( 'login_footer', 'xlt_login_classes_footer' );
}

add_action( 'init', 'xlt_login_classes' );

/**
 * Add some classes to login fields.
 */
function xlt_login_classes_footer() {
	echo "<script>
		if (document.getElementById('loginform') !==null) {
		    document.getElementById('loginform').classList.add('md-form')
		}

		if (document.getElementById('lostpasswordform') !==null) {
		    document.getElementById('lostpasswordform').classList.add('md-form')
		}

		if (document.getElementById('lostpasswordform') !==null) {
		    document.getElementById('lostpasswordform').classList.add('md-form')
		}

		if (document.getElementById('user_login') !==null) {
	        let user_login = document.getElementById('user_login')
	        user_login.classList.remove('input')
			user_login.classList.add('form-control','rounded-0')
        }

		if (document.getElementById('user_pass') !==null) {
            let user_pass = document.getElementById('user_pass')
			user_pass.classList.remove('input')
			user_pass.classList.add('form-control','rounded-0')
		}

        if (document.getElementById('wp-submit') !==null) {
            let wp_submit = document.getElementById('wp-submit')
            wp_submit.classList.remove('button','button-primary','button-large');
            wp_submit.classList.add('btn','btn-outline-primary','pink-hover','rounded-0')
		}
		</script>";
}

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

				return wp_authenticate_username_password( null, $username, $password );
			}
		}
	}

	if ( ! empty( $username ) || ! empty( $password ) ) {
		return false;
	}

	return wp_authenticate_username_password( null, "", "" );
}

add_filter( 'authenticate', 'xlt_authenticate', 20, 3 );
