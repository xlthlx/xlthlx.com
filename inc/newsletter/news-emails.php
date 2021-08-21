<?php
/**
 * Functions to manage the newsletter emails.
 * Requires Flamingo and Contact Form 7 plugins.
 *
 * @package  WordPress
 * @subpackage  Xlthlx
 */

/**
 * Send confirmation email.
 *
 * @param $lang
 * @param $to
 * @param $_code
 */
function xlt_send_confirmation( $lang, $to, $_code ) {

	if ( $lang === 'en' ) {
		$subject = "Confirm your subscription to xlthlx.com";
	} else {
		$subject = "Conferma la tua iscrizione a xlthlx.com";
	}

	ob_start();
	$email = $to;
	$code  = $_code;
	$file  = 'email/confirm-' . $lang . '.php';
	include __DIR__ . $file;
	$body = ob_get_clean();

	xlt_send_email( $to, $subject, $body );
}

/**
 * @throws Exception
 */
function xlt_post_published_notification( $post_id, $post ) {

	global $lang, $to;

	if ( $lang === 'en' ) {
		$subject = 'New post on xlthlx.com';
		ob_start();
		$title     = get_title_en();
		$permalink = get_permalink( $post_id ) . 'en/';
		$excerpt   = wp_trim_excerpt( get_content_en() );
		$code      = "aaaaaaaaaa";
		include __DIR__ . '/email/post-en.php';
		$body = ob_get_clean();
	} else {
		$subject = 'Nuovo post su xlthlx.com';
		ob_start();
		$title     = $post->post_title;
		$permalink = get_permalink( $post_id );
		$excerpt   = wp_trim_excerpt( $post->post_content );
		$code      = "aaaaaaaaaa";
		include __DIR__ . '/email/post-it.php';
		$body = ob_get_clean();
	}

	xlt_send_email( $to, $subject, $body );
}

//add_action( 'publish_post', 'xlt_post_published_notification', 10, 2 );

/**
 * Send HTML email.
 *
 * @param $to
 * @param $subject
 * @param $body
 */
function xlt_send_email( $to, $subject, $body ) {
	$headers = array( 'Content-Type: text/html; charset=UTF-8', 'From: xlthlx.com <noreply@xlthlx.com>' );
	wp_mail( $to, $subject, $body, $headers );
}
