<?php
/**
 * Functions to manage the newsletter.
 *
 * @package  WordPress
 * @subpackage  Xlthlx
 */

function xlt_send_confirmation( $lang, $to ) {

	if ( $lang === 'it' ) {
		$subject = "Conferma l'iscrizione a xlthlx.com";
		ob_start();
		$code = "aaaaaaaaaa";
		include __DIR__ . '/email/confirm-it.php';
		$body = ob_get_clean();
	}

	$headers = array( 'Content-Type: text/html; charset=UTF-8', 'From: xlthlx.com <noreply@xlthlx.com>' );
	wp_mail( $to, $subject, $body, $headers );
}

function xlt_post_published_notification( $post_id, $post ) {

	global $lang, $to;

	if ( $lang === 'en' ) {
		$subject = 'New post on xlthlx.com';
		ob_start();
		$title     = $post->post_title;
		$permalink = get_permalink( $post_id );
		$excerpt   = '';
		$code      = "aaaaaaaaaa";
		include __DIR__ . '/email/post-en.php';
		$body = ob_get_clean();
	} else {
		$subject = 'Nuovo post su xlthlx.com';
		ob_start();
		$title     = $post->post_title;
		$permalink = get_permalink( $post_id );
		$excerpt   = $post->post_content;
		$code      = "aaaaaaaaaa";
		include __DIR__ . '/email/post-it.php';
		$body = ob_get_clean();
	}

	$headers = array( 'Content-Type: text/html; charset=UTF-8', 'From: xlthlx.com <noreply@xlthlx.com>' );
	wp_mail( $to, $subject, $body, $headers );
}

//add_action( 'publish_post', 'xlt_post_published_notification', 10, 2 );
