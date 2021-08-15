<?php
/**
 * Functions which enhance the theme by hooking into WordPress.
 *
 * @package  WordPress
 * @subpackage  Xlthlx
 */

use Highlight\Highlighter;

add_action( 'admin_menu', 'xlt_remove_menu_pages', 999 );

/**
 * Removes annoying submenus.
 */
function xlt_remove_menu_pages() {
	remove_submenu_page( 'aioseo', 'https://aioseo.com/lite-upgrade/?utm_source=WordPress&#038;utm_campaign=liteplugin&#038;utm_medium=admin-menu' );
}

add_action( 'wp_before_admin_bar_render', 'xlt_remove_admin_bar_wp_logo', 20 );

/**
 * Removes WP Logo, comments and SEO in the admin bar.
 */
function xlt_remove_admin_bar_wp_logo() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_node( 'wp-logo' );
	$wp_admin_bar->remove_node( 'comments' );
	$wp_admin_bar->remove_node( 'aioseo-main' );
}

add_filter( 'pre_option_link_manager_enabled', '__return_true' );
add_filter( 'wpcf7_load_js', '__return_false' );
add_filter( 'wpcf7_load_css', '__return_false' );
add_filter( 'render_block', 'xlt_render_code_block', 10, 2 );

/**
 * Modify the rendering of code Gutenberg block.
 *
 * @param $block_content
 * @param $block
 *
 * @return string
 * @throws Exception
 */
function xlt_render_code_block( $block_content, $block ) {
	if ( 'core/code' !== $block['blockName'] ) {
		return $block_content;
	}

	return xlt_render_code( $block_content );
}

/**
 * Renders the block type output for given attributes.
 *
 * @param string $content Optional. Block content. Default empty string.
 *
 * @return string Rendered block type output.
 * @throws Exception
 * @since 5.0.0
 */
function xlt_render_code( string $content ) {

	$hl = new Highlighter();
	$hl->setAutodetectLanguages( array( 'php', 'javascript', 'html' ) );

	$content = str_replace( array(
		'<pre class="wp-block-code">',
		'<code>',
		'</code>',
		'</pre>'
	), '', html_entity_decode( $content ) );

	$highlighted = $hl->highlightAuto( trim( $content ) );

	if ( $highlighted ) {
		$content = '<pre class="wp-block-code"><code class="hljs ' . $highlighted->language . '">' . $highlighted->value . '</code></pre>';
		$content = apply_filters( 'the_content', $content );
	}

	return $content;
}

add_action( 'init', 'xlt_remove_comment_reply' );

/**
 * Removes the comment-reply script.
 */
function xlt_remove_comment_reply() {
	wp_deregister_script( 'comment-reply' );
}

add_action( 'init', 'xlt_remove_jquery_migrate_notice', 5 );

/**
 * Remove the very annoying jQuery Migrate notice.
 */
function xlt_remove_jquery_migrate_notice() {
	$m                    = $GLOBALS['wp_scripts']->registered['jquery-migrate'];
	$m->extra['before'][] = 'temp_jm_logconsole = window.console.log; window.console.log=null;';
	$m->extra['after'][]  = 'window.console.log=temp_jm_logconsole;';
}

/**
 * Comment Field Order.
 *
 * @param $fields
 *
 * @return array
 */
function xlt_comment_fields_custom_order( $fields ) {

	$comment_field = $fields['comment'];
	$author_field  = $fields['author'];
	$email_field   = $fields['email'];
	$url_field     = $fields['url'];

	unset( $fields['comment'], $fields['author'], $fields['email'], $fields['url'], $fields['cookies'] );

	$fields['author']  = $author_field;
	$fields['email']   = $email_field;
	$fields['url']     = $url_field;
	$fields['comment'] = $comment_field;

	return $fields;
}

add_filter( 'comment_form_fields', 'xlt_comment_fields_custom_order' );

/**
 * Redirect en comments to the correct url.
 *
 * @param $location
 * @param $comment_data
 *
 * @return mixed
 */
function xlt_en_comment_redirect( $location, $comment_data ) {
	if ( ! isset( $comment_data ) || empty( $comment_data->comment_post_ID ) ) {
		return $location;
	}

	if ( isset( $_POST['en_redirect_to'] ) ) {
		$location = get_permalink( $comment_data->comment_post_ID ) . "en/#comment-" . $comment_data->comment_ID;
	}

	return $location;
}

add_filter( 'comment_post_redirect', 'xlt_en_comment_redirect', 10, 2 );

/**
 * Enqueue js and css into admin.
 */
function xlt_enqueue_admin_css_js() {
	wp_enqueue_style( 'admin', get_template_directory_uri() . '/assets/css/admin/admin.css' );
	wp_enqueue_script( 'admin', get_template_directory_uri() . '/assets/js/admin/admin.js', [], '', true );
}

add_action( 'admin_enqueue_scripts', 'xlt_enqueue_admin_css_js' );

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

	$cases = (array) apply_filters( 'wpcf7_flamingo_submit_if',
		array( 'spam', 'mail_sent', 'mail_failed' ) );

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

		$meta[ $smt ] = apply_filters( 'wpcf7_special_mail_tags', null,
			$tag_name, false, $mail_tag
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
		$flamingo_contact = Flamingo_Contact::add( array(
			'email'          => $email,
			'name'           => $name,
			'last_contacted' => $last_contacted,
		) );
	}

	$post_meta = get_post_meta( $contact_form->id(), '_flamingo', true );

	$channel_id = isset( $post_meta['channel'] )
		? (int) $post_meta['channel']
		: wpcf7_flamingo_add_channel(
			$contact_form->name(), $contact_form->title() );

	if ( $channel_id ) {
		if ( ! isset( $post_meta['channel'] )
		     or $post_meta['channel'] !== $channel_id ) {
			$post_meta = empty( $post_meta ) ? array() : (array) $post_meta;
			$post_meta = array_merge( $post_meta, array(
				'channel' => $channel_id,
			) );

			update_post_meta( $contact_form->id(), '_flamingo', $post_meta );
		}

		$channel = get_term( $channel_id,
			Flamingo_Inbound_Message::channel_taxonomy );

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
		$_code = wp_generate_password( 32 );
		$_lang = get_post_meta( $flamingo_inbound_id, '_field_lang', true );
		$_name = explode( '@', get_post_meta( $flamingo_contact_id, '_name', true ) );

		update_post_meta( $flamingo_contact_id, '_code', $_code );
		update_post_meta( $flamingo_contact_id, '_lang', $_lang );
		update_post_meta( $flamingo_contact_id, '_active', 'no' );
		update_post_meta( $flamingo_contact_id, '_name', ucfirst( $_name[0] ) );
	}
}

/**
 * Additional columns.
 *
 * @param $columns
 *
 * @return mixed
 */
function xlt_flamingo_contact_columns( $columns ) {
	$columns['code']   = "Codice";
	$columns['lang']   = "Lingua";
	$columns['active'] = "Conferma";

	return $columns;
}

add_action( 'manage_flamingo_contact_posts_columns', 'xlt_flamingo_contact_columns' );

/**
 * Set values for additional columns.
 *
 * @param $column_name
 * @param $post_id
 */
function xlt_print_flamingo_contact_columns( $column_name, $post_id ) {

	if ( $column_name === 'code' ) {
		echo get_post_meta( $post_id, '_code', true );
	}

	if ( $column_name === 'lang' ) {
		$_lang = get_post_meta( $post_id, '_lang', true );
		echo ( $_lang === 'en' ) ? 'English' : 'Italiano';
	}

	if ( $column_name === 'active' ) {
		echo ucfirst( get_post_meta( $post_id, '_active', true ) );
	}
}

add_action( 'manage_flamingo_contact_posts_custom_column', 'xlt_print_flamingo_contact_columns', 10, 2 );
