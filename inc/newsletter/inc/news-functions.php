<?php
/**
 * Functions to manage the newsletter.
 * Requires Flamingo and Contact Form 7 plugins.
 *
 * @package  xlthlx
 */

/**
 * Removes default function and replace it with a custom one.
 */
function xlt_remove_flamingo_save() {
	remove_action( 'wpcf7_submit', 'wpcf7_flamingo_submit' );
	add_action( 'wpcf7_submit', 'xlt_flamingo_submit', 10, 2 );
}

add_action( 'init', 'xlt_remove_flamingo_save' );

/**
 * Save forms submissions.
 *
 * @param $contact_form
 * @param $result
 */
function xlt_flamingo_submit( $contact_form, $result ) {
	if ( ! class_exists( 'Flamingo_Contact' )
		 || ! class_exists( 'Flamingo_Inbound_Message' ) ) {
		return;
	}

	if ( $contact_form->in_demo_mode() ) {
		return;
	}

	$cases = (array) apply_filters(
		'wpcf7_flamingo_submit_if',
		array( 'mail_sent' ) 
	);

	if ( empty( $result['status'] )
		 || ! in_array( $result['status'], $cases, true ) ) {
		return;
	}

	$submission = WPCF7_Submission::get_instance();

	if ( ! $submission
		 || ! $posted_data = $submission->get_posted_data() ) {
		return;
	}

	if ( $submission->get_meta( 'do_not_store' ) ) {
		return;
	}

	$email   = wpcf7_flamingo_get_value( 'email', $contact_form );
	$name    = wpcf7_flamingo_get_value( 'name', $contact_form );
	$subject = wpcf7_flamingo_get_value( 'subject', $contact_form );

	$meta = array();

	$special_mail_tags = array(
		'serial_number',
		'remote_ip',
		'user_agent',
		'url',
		'date',
		'time',
	);

	foreach ( $special_mail_tags as $smt ) {
		$tag_name = sprintf( '_%s', $smt );

		$mail_tag = new WPCF7_MailTag(
			sprintf( '[%s]', $tag_name ),
			$tag_name,
			''
		);

		$meta[ $smt ] = apply_filters(
			'wpcf7_special_mail_tags', 
			null,
			$tag_name, 
			false, 
			$mail_tag
		);
	}

	$akismet = isset( $submission->akismet )
		? (array) $submission->akismet : null;

	$timestamp = $submission->get_meta( 'timestamp' );

	if ( $timestamp && $datetime = date_create( '@' . $timestamp ) ) {
		$datetime->setTimezone( wp_timezone() );
		$last_contacted = $datetime->format( 'Y-m-d H:i:s' );
	} else {
		$last_contacted = '0000-00-00 00:00:00';
	}

	if ( 'mail_sent' == $result['status'] ) {
		$flamingo_contact = Flamingo_Contact::add(
			array(
				'email'          => $email,
				'name'           => $name,
				'last_contacted' => $last_contacted,
			) 
		);
	}

	$post_meta = get_post_meta( $contact_form->id(), '_flamingo', true );

	$channel_id = isset( $post_meta['channel'] )
		? (int) $post_meta['channel']
		: wpcf7_flamingo_add_channel(
			$contact_form->name(), 
			$contact_form->title() 
		);

	if ( $channel_id ) {
		if ( ! isset( $post_meta['channel'] )
			 or $post_meta['channel'] !== $channel_id ) {
			$post_meta = empty( $post_meta ) ? array() : (array) $post_meta;
			$post_meta = array_merge(
				$post_meta, 
				array(
					'channel' => $channel_id,
				) 
			);

			update_post_meta( $contact_form->id(), '_flamingo', $post_meta );
		}

		$channel = get_term(
			$channel_id,
			Flamingo_Inbound_Message::channel_taxonomy 
		);

		if ( ! $channel or is_wp_error( $channel ) ) {
			$channel = 'contact-form-7';
		} else {
			$channel = $channel->slug;
		}
	} else {
		$channel = 'contact-form-7';
	}

	$args = array(
		'channel'          => $channel,
		'status'           => $submission->get_status(),
		'subject'          => $subject,
		'from'             => trim( sprintf( '%s <%s>', $name, $email ) ),
		'from_name'        => $name,
		'from_email'       => $email,
		'fields'           => $posted_data,
		'meta'             => $meta,
		'akismet'          => $akismet,
		'spam'             => ( 'spam' == $result['status'] ),
		'consent'          => $submission->collect_consent(),
		'timestamp'        => $timestamp,
		'posted_data_hash' => $submission->get_posted_data_hash(),
	);

	if ( $args['spam'] ) {
		$args['spam_log'] = $submission->get_spam_log();
	}

	if ( isset( $submission->recaptcha ) ) {
		$args['recaptcha'] = $submission->recaptcha;
	}

	$flamingo_inbound = Flamingo_Inbound_Message::add( $args );

	if ( empty( $flamingo_contact ) ) {
		$flamingo_contact_id = 0;
	} elseif ( method_exists( $flamingo_contact, 'id' ) ) {
		$flamingo_contact_id = $flamingo_contact->id();
	} else {
		$flamingo_contact_id = $flamingo_contact->id;
	}

	if ( null === $flamingo_inbound ) {
		$flamingo_inbound_id = 0;
	} elseif ( method_exists( $flamingo_inbound, 'id' ) ) {
		$flamingo_inbound_id = $flamingo_inbound->id();
	} else {
		$flamingo_inbound_id = $flamingo_inbound->id;
	}

	$result += array(
		'flamingo_contact_id' => absint( $flamingo_contact_id ),
		'flamingo_inbound_id' => absint( $flamingo_inbound_id ),
	);

	do_action( 'wpcf7_after_flamingo', $result );

	/**
	 * Additional fields.
	 */
	$form_id = (string) $contact_form->id();
	if ( ( $form_id === '34396' ) || ( $form_id === '34503' ) ) {
		$_code  = wp_generate_password( 64, false );
		$_lang  = get_post_meta( $flamingo_inbound_id, '_field_lang', true );
		$_name  = explode( '@', get_post_meta( $flamingo_contact_id, '_name', true ) );
		$_email = get_post_meta( $flamingo_contact_id, '_email', true );

		update_post_meta( $flamingo_contact_id, '_code', $_code );
		update_post_meta( $flamingo_contact_id, '_lang', $_lang );
		update_post_meta( $flamingo_contact_id, '_active', 'no' );
		update_post_meta( $flamingo_contact_id, '_name', ucfirst( $_name[0] ) );

		xlt_send_confirmation( $_lang, $_email, $_code );
	}
}

/**
 * Add query vars to manage confirm/unsubscribe.
 *
 * @param $vars
 *
 * @return mixed
 */
function xlt_newsletter_query_vars( $vars ) {
	$vars[] .= 'act';
	$vars[] .= 'cod';

	return $vars;
}

add_filter( 'query_vars', 'xlt_newsletter_query_vars' );
