<?php
/**
 * Functions to manage the newsletter.
 *
 * @package  WordPress
 * @subpackage  Xlthlx
 */

function xlt_send_confirmation( $lang, $to ) {

	if ( $lang === 'en' ) {
		$subject = "Confirm your subscription to xlthlx.com";
		ob_start();
		$email = "pippo@pluto.com";
		$code = "aaaaaaaaaa";
		include __DIR__ . '/email/confirm-en.php';
		$body = ob_get_clean();
	}
	else {
		$subject = "Conferma la tua iscrizione a xlthlx.com";
		ob_start();
		$email = "pippo@pluto.com";
		$code = "aaaaaaaaaa";
		include __DIR__ . '/email/confirm-it.php';
		$body = ob_get_clean();
	}

	$headers = array( 'Content-Type: text/html; charset=UTF-8', 'From: xlthlx.com <noreply@xlthlx.com>' );
	wp_mail( $to, $subject, $body, $headers );
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
		$permalink = get_permalink( $post_id ).'en/';
		$excerpt   = wp_trim_excerpt( get_content_en() );
		$code      = "aaaaaaaaaa";
		include __DIR__ . '/email/post-en.php';
		$body = ob_get_clean();
	} else {
		$subject = 'Nuovo post su xlthlx.com';
		ob_start();
		$title     = $post->post_title;
		$permalink = get_permalink( $post_id );
		$excerpt   = wp_trim_excerpt( $post->post_content);
		$code      = "aaaaaaaaaa";
		include __DIR__ . '/email/post-it.php';
		$body = ob_get_clean();
	}

	$headers = array( 'Content-Type: text/html; charset=UTF-8', 'From: xlthlx.com <noreply@xlthlx.com>' );
	wp_mail( $to, $subject, $body, $headers );
}

//add_action( 'publish_post', 'xlt_post_published_notification', 10, 2 );
