<?php
/**
 * Template Name: Unsubscribe
 *
 * @package  WordPress
 * @subpackage  Xlthlx
 */

$comment_id = filter_input( INPUT_GET, 'comment', FILTER_SANITIZE_NUMBER_INT );
$comment    = get_comment( $comment_id );

if ( ! $comment ) {
	$title   = 'Something went wrong';
	$message = 'Invalid request.';
} else {

	$user_key = filter_input( INPUT_GET, 'key', FILTER_SANITIZE_STRING );
	$real_key = xlt_secret_key( $comment_id );

	if ( $user_key != $real_key ) {
		$title   = 'Something went wrong';
		$message = 'Invalid request.';
	} else {

		delete_comment_meta( $comment_id, 'subscribe_to_comment' );
		$comment_lang = get_comment_meta( $comment_id, 'comment_lang', true );

		$title   = 'Iscrizione cancellata';
		$message = 'La tua iscrizione a questo commento è stata cancellata.';

		if ( $comment_lang == 'en' ) {
			$title   = 'Unsubscribed';
			$message = 'Your subscription for this comment has been cancelled.';
		}
	}
}

$context         = Timber::context();
$timber_post     = new Timber\Post();
$context['post'] = $timber_post;
$context['u_title']   = $title;
$context['u_message'] = $message;
Timber::render( 'page-unsubscribe.twig', $context );
