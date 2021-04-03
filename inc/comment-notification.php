<?php
/**
 * Comment reply notification.
 *
 * @package  WordPress
 * @subpackage  Xlthlx
 */

add_action( 'cmb2_init', 'xlt_register_comment_subscribe' );

/**
 * Hook in and register a meta box for the admin comment edit page.
 */
function xlt_register_comment_subscribe() {

	$cmb = cmb2_get_metabox( 'xlt_comment_metabox' );

	$cmb->add_field( array(
		'name'       => 'Iscrizione ai commenti',
		'desc'       => '',
		'id'         => 'subscribe_to_comment',
		'type'       => 'checkbox',
		'default_cb' => 'xlt_set_subscribe_default',
		'column'     => array(
			'position' => 5,
			'name'     => 'Iscrizione',
		),
	) );
}

/**
 * Return the default value for the metabox.
 *
 * @return string
 */
function xlt_set_subscribe_default() {
	return isset( $_GET['c'] ) ? '' : 'on';
}

add_action( 'comment_post', 'xlt_save_comment_subscribe' );

/**
 * Save comment meta subscribe_to_comment.
 *
 * @param $comment_id
 */
function xlt_save_comment_subscribe( $comment_id ) {
	update_comment_meta( $comment_id, 'subscribe_to_comment', $_POST['subscribe_to_comment'] );
}

add_action( 'wp_insert_comment', 'xlt_comment_notification', 10, 2 );

/**
 * Sends an email notification when a comment receives a reply.
 *
 * @param int $id The comment ID
 * @param object $comment Comment object
 *
 * @return boolean
 */
function xlt_comment_notification( $id, $comment ) {

	if ( $comment->comment_approved == 1 && $comment->comment_parent > 0 ) {
		$parent = get_comment( $comment->comment_parent );
		$email  = $parent->comment_author_email;

		if ( $email === $comment->comment_author_email ) {
			return false;
		}

		$subscription = get_comment_meta( $parent->comment_ID, 'subscribe_to_comment', true );

		if ( $subscription && $subscription == 'on' ) {

			$lang    = get_comment_meta( $parent->comment_ID, 'comment_lang', true );
			$message = 'Nuova risposta al tuo commento';

			if ( $lang == 'en' ) {
				$message = 'New reply to your comment';
			}

			$title   = 'xlthlx | ' . $message;
			$headers = array( 'Content-Type: text/html; charset=UTF-8' );

			ob_start();
			$args = array(
				'parent'  => $parent,
				'comment' => $comment
			);
			require __DIR__ . '/comment-notification-email-template.php';
			$body = ob_get_clean();

			wp_mail( $email, $title, $body, $headers );
		}

	}
}

/**
 * Generates the unsubscribe link.
 *
 * @param $comment
 *
 * @return string
 */
function xlt_get_unsubscribe_link( $comment ) {
	$key = xlt_secret_key( $comment->comment_ID );

	$params = [
		'comment' => $comment->comment_ID,
		'key'     => $key
	];

	return site_url() . '/unsubscribe?' . http_build_query( $params );
}

/**
 * Generates a secret key to validate the requests.
 *
 * @param $comment_id
 *
 * @return string
 */
function xlt_secret_key( $comment_id ) {
	return hash_hmac( 'sha512', $comment_id, wp_salt() );
}

add_filter( 'wp_mail_from', 'xlt_mail_from' );

/**
 * Change the from email.
 *
 * @return string
 */
function xlt_mail_from() {
	return 'noreply@xlthlx.com';
}

add_filter( 'wp_mail_from_name', 'xlt_mail_from_name' );

/**
 * Change the from name.
 *
 * @return string
 */
function xlt_mail_from_name() {
	return 'xlthlx';
}
