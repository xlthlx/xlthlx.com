<?php

/**
 * Class CommentReplyEmailNotification
 */

class CommentReplyEmailNotification {

	/**
	 * Constructor
	 */
	public function __construct() {

		/* Initialize frontend stuff */
		add_action( 'wp_insert_comment', [ $this, 'comment_notification' ], 99, 2 );
		add_action( 'wp_set_comment_status', [ $this, 'comment_status_update' ], 99, 2 );
		add_filter( 'comment_form_default_fields', [ $this, 'comment_fields' ] );
		add_filter( 'comment_form_submit_field', [ $this, 'comment_fields_logged_in' ] );
		add_action( 'comment_post', [ $this, 'persist_subscription_opt_in' ] );
		add_action( 'init', [ $this, 'unsubscribe_route' ] );
	}

	/**
	 * Filter that changes the email content type when the notification is sent.
	 *
	 * @return string
	 */
	function wp_mail_content_type_filter() {
		return 'text/html';
	}

	/**
	 * Generates the unsubscribe link for a comment/user.
	 *
	 * @param StdClass $comment The comment object
	 *
	 * @return string
	 */
	function get_unsubscribe_link( $comment ) {
		$key = $this->secret_key( $comment->comment_ID );

		$params = [
			'comment' => $comment->comment_ID,
			'key'     => $key
		];

		return site_url() . '/cren/unsubscribe?' . http_build_query( $params );
	}

	/**
	 * Generates a secret key to validate the requests
	 *
	 * @param int $commentId The comment ID
	 *
	 * @return string
	 */
	function secret_key( $commentId ) {
		return hash_hmac( 'sha512', $commentId, wp_salt() );
	}

	/**
	 * Processes the unsubscribe request.
	 *
	 * @return void
	 */
	function unsubscribe_route() {
		$requestUri = $_SERVER['REQUEST_URI'];

		if ( preg_match( '/cren\/unsubscribe/', $requestUri ) ) {
			$commentId = filter_input( INPUT_GET, 'comment', FILTER_SANITIZE_NUMBER_INT );
			$comment   = get_comment( $commentId );

			if ( ! $comment ) {
				echo 'Invalid request.';
				exit;
			}

			$userKey = filter_input( INPUT_GET, 'key', FILTER_SANITIZE_STRING );
			$realKey = $this->secret_key( $commentId );

			if ( $userKey !== $realKey ) {
				echo 'Invalid request.';
				exit;
			}

			$uri = get_permalink( $comment->comment_post_ID );

			$this->persist_subscription_opt_out( $commentId );

			echo '<!doctype html><html><head><meta charset="utf-8"><title>' . get_bloginfo( 'name' ) . '</title></head><body>';
			echo '<p>' . __( 'Your subscription for this comment has been cancelled.', 'comment-reply-email-notification' ) . '</p>';
			echo '<script type="text/javascript">setTimeout(function() { window.location.href="' . $uri . '"; }, 3000);</script>';
			echo '</body></html>';
			exit;
		}
	}

	/**
	 * Persists the user subscription removal.
	 *
	 * @param int $commentId The comment ID
	 *
	 * @return boolean
	 */
	function persist_subscription_opt_out( $commentId ) {
		return update_comment_meta( $commentId, 'cren_subscribe_to_comment', 'off' );
	}

	/**
	 * Sends a notification if a comment is approved
	 *
	 * @param int $commentId The comment ID
	 * @param string $commentStatus The new comment status
	 *
	 * @return void
	 */
	function comment_status_update( $commentId, $commentStatus ) {
		$comment = get_comment( $commentId );

		if ( $commentStatus === 'approve' ) {
			$this->comment_notification( $comment->comment_ID, $comment );
		}
	}

	/**
	 * Sends an email notification when a comment receives a reply
	 *
	 * @param int $commentId The comment ID
	 * @param object $comment The comment object
	 *
	 * @return boolean
	 */
	function comment_notification( $commentId, $comment ) {
		if ( $comment->comment_approved === 1 && $comment->comment_parent > 0 ) {
			$parent = get_comment( $comment->comment_parent );
			$email  = $parent->comment_author_email;

			// Parent comment author == new comment author
			// In this case, we don't send a notification.
			if ( $email === $comment->comment_author_email ) {
				return false;
			}

			$subscription = get_comment_meta( $parent->comment_ID, 'cren_subscribe_to_comment', true );

			// If we don't find the option, we assume the user is subscribed.
			if ( $subscription && $subscription === 'off' ) {
				return false;
			}

			ob_start();
			require $this->notification_template_path();
			$body = ob_get_clean();

			$title = html_entity_decode( get_option( 'blogname' ), ENT_QUOTES ) . ' - ' . __( 'New reply to your comment', 'comment-reply-email-notification', $body );

			$headers = array('Content-Type: text/html; charset=UTF-8','From: xlthlx &lt;wordpress@xlthlx.com');
			wp_mail( $email, $title, $body, $headers );

		}
	}

	/**
	 * Returns the notification template path. It's either a custom one, located at
	 * wp-content/themes/[THEME]/templates/notification.php or the default one, located
	 * at wp-content/plugins/comment-reply-email-notification/templates/notification.php.
	 *
	 * @return string
	 */
	function notification_template_path() {

		return __DIR__ . '/notification-template.php';
	}

	/**
	 * Adds a checkbox to the comment form which allows the user to not receive
	 * new replies.
	 *
	 * @param array $fields The default form fields
	 *
	 * @return array
	 */
	function comment_fields( $fields ) {

		if ( $this->display_gdpr_notice() ) {
			$fields['cren_gdpr'] = $this->render_gdpr_notice();
		}

		return $fields;
	}

	/**
	 * Returns whether the GDPR checkbox should be shown or not.
	 *
	 * @return bool
	 */
	function display_gdpr_notice() {
		return $this->get_cren_option( 'cren_display_gdpr_notice', false );
	}

	/**
	 * Get a plugin option.
	 *
	 * @param  $option
	 * @param  $default
	 *
	 * @return mixed
	 */
	function get_cren_option( $option, $default ) {
		$options = get_option( 'cren_settings' );

		if ( $options && isset( $options[ $option ] ) ) {
			return $options[ $option ];
		}

		return $default;
	}

	/**
	 * Renders the GDPR checkbox.
	 *
	 * @return string
	 */
	function render_gdpr_notice() {
		$label = apply_filters(
			'cren_gdpr_checkbox_label',
			sprintf( __( 'I consent to %s collecting and storing the data I submit in this form.', 'comment-reply-email-notification' ), get_option( 'blogname' ) )
		);

		$privacyPolicyUrl = $this->get_privacy_policy_url();
		$privacyPolicy    = "<a target='_blank' href='{$privacyPolicyUrl}'>(" . __( 'Privacy Policy', 'comment-reply-email-notification' ) . ")</a>";

		return '<p class="comment-form-comment-subscribe"><label for="cren_gdpr"><input id="cren_gdpr" name="cren_gdpr" type="checkbox" value="yes" required="required">' . $label . ' ' . $privacyPolicy . ' <span class="required">*</span></label></p>';
	}

	/**
	 * Gets the privacy policy URL.
	 *
	 * @return string
	 */
	function get_privacy_policy_url() {
		return $this->get_cren_option( 'cren_privacy_policy_url', '' );
	}

	/**
	 * Adds a checkbox to the logged in comment form which allows the user to not
	 * receive new replies.
	 *
	 * Uses the comment form submit hook as a workaround for logged in users.
	 *
	 * @param string $submitField
	 *
	 * @return string
	 */
	function comment_fields_logged_in( $submitField ) {
		$checkbox = '';

		if ( is_user_logged_in() ) {

			if ( $this->display_gdpr_notice() ) {
				$checkbox = $this->render_gdpr_notice();
			}
		}

		return $checkbox . $submitField;
	}

	/**
	 * Persists the user choice.
	 *
	 * @param int $commentId The comment ID
	 *
	 * @return boolean
	 */
	function persist_subscription_opt_in( $commentId ) {
		$value = ( isset( $_POST['cren_subscribe_to_comment'] ) && $_POST['cren_subscribe_to_comment'] === 'on' ) ? 'on' : 'off';

		return add_comment_meta( $commentId, 'cren_subscribe_to_comment', $value, true );
	}
}

$comment_reply_email_notification = new CommentReplyEmailNotification();

/**
 * Callback for existing email templates
 */
function cren_get_unsubscribe_link( $comment ) {
	global $comment_reply_email_notification;

	return $comment_reply_email_notification->get_unsubscribe_link( $comment );
}
