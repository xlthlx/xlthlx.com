<?php
/**
 * Functions to manage the newsletter emails.
 * Requires Flamingo and Contact Form 7 plugins.
 *
 * @package  xlthlx
 */

/**
 * Create an excerpt from any text.
 *
 * @param string $text Text.
 *
 * @return string
 */
function xlt_trim( $text ) {
	$text = strip_shortcodes( $text );
	$text = excerpt_remove_blocks( $text );
	$text = apply_filters( 'the_content', $text );
	$text = str_replace( ']]>', ']]&gt;', $text );

	return wp_trim_words( $text, 30, '...' );
}

/**
 * Send confirmation email.
 *
 * @param string $lang Language.
 * @param string $to Email to.
 * @param string $_code Unique code.
 */
function xlt_send_confirmation( $lang, $to, $_code ) {

	if ( 'en' === $lang ) {
		$subject = 'Confirm your subscription to xlthlx.com';
	} else {
		$subject = 'Conferma la tua iscrizione a xlthlx.com';
	}

	ob_start();
	$email = $to;
	$code  = $_code;
	include sprintf( '%s/inc/newsletter/inc/email/confirm-%s.php', get_template_directory(), $lang );
	$body = ob_get_clean();

	xlt_send_email( $to, $subject, $body );
}

/**
 * Send an email when a post is published.
 *
 * @param string $new_status New post status.
 * @param string $old_status Old post status.
 * @param object $post Post object.
 *
 * @return void
 * @throws Exception Exception.
 */
function xlt_post_published_notification( $new_status, $old_status, $post ) {

	if ( 'publish' === $new_status && 'publish' !== $old_status && 'post' === $post->post_type ) {

		$_title        = $post->post_title;
		$_permalink    = get_permalink( $post->ID );
		$_excerpt      = xlt_trim( $post->post_content );
		$_title_en     = get_title_en( $post->ID );
		$_permalink_en = get_permalink( $post->ID ) . 'en/';
		$_excerpt_en   = xlt_trim( get_content_en( $post->ID ) );

		$args = array(
			'numberposts' => - 1,
			'post_type'   => 'flamingo_contact',
			'meta_key'    => '_active',
			'meta_value'  => 'si',
		);

		$query = new WP_Query( $args );

		if ( $query->have_posts() ) {

			while ( $query->have_posts() ) {
				$query->the_post();

				$contact_id = get_the_ID();
				$to         = get_post_meta( $contact_id, '_email', true );
				$_lang      = get_post_meta( $contact_id, '_lang', true );
				$_code      = get_post_meta( $contact_id, '_code', true );

				ob_start();
				$code = $_code;

				if ( 'en' === $_lang ) {
					$subject   = 'New post on xlthlx.com';
					$title     = $_title_en;
					$permalink = $_permalink_en;
					$excerpt   = $_excerpt_en;
					include get_template_directory() . '/inc/newsletter/inc/email/post-en.php';
				} else {
					$subject   = 'Nuovo post su xlthlx.com';
					$title     = $_title;
					$permalink = $_permalink;
					$excerpt   = $_excerpt;
					include get_template_directory() . '/inc/newsletter/inc/email/post-it.php';
				}
				$body = ob_get_clean();

				xlt_send_email( $to, $subject, $body );

				$contact_id = '';
				$to         = '';
				$_lang      = '';
				$_code      = '';
			}
		}

		wp_reset_postdata();
	}
}

add_action( 'transition_post_status', 'xlt_post_published_notification', 10, 3 );

/**
 * Send HTML email.
 *
 * @param string $to Email to.
 * @param string $subject Email subject.
 * @param string $body Email body.
 */
function xlt_send_email( $to, $subject, $body ) {
	$headers = array( 'Content-Type: text/html; charset=UTF-8', 'From: xlthlx.com <noreply@xlthlx.com>' );
	wp_mail( $to, $subject, $body, $headers );
}

/**
 * Logs the email errors.
 *
 * @param array $wp_error Email error.
 */
function xlt_log_mail_error( $wp_error ) {

	$result = print_r( $wp_error, true );
	error_log( '<pre>' . $result . '</pre>' );
}

add_action( 'wp_mail_failed', 'xlt_log_mail_error', 10, 1 );
