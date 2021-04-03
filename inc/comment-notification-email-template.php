<?php
/**
 * Comment reply notification email template.
 *
 * @package  WordPress
 * @subpackage  Xlthlx
 */

$parent  = $args['parent'];
$comment = $args['comment'];

$comment_lang = get_comment_meta( $parent->comment_ID, 'comment_lang', true );

if ( $comment_lang == 'en' ) {
	$hello        = 'Hi';
	$replied      = 'has replied to your comment on';
	$link         = get_permalink( $parent->comment_post_ID ) . 'en/';
	$title        = esc_html( get_title_en( $parent->comment_post_ID ) );
	$reply        = 'To reply:';
	$comment_link = get_permalink( $parent->comment_post_ID ) . 'en/#comment-' . $parent->comment_ID;
	$stop         = 'To stop receiving these messages:';
} else {
	$hello        = 'Ciao';
	$replied      = 'ha risposto al tuo commento su';
	$link         = get_permalink( $parent->comment_post_ID );
	$title        = esc_html( get_the_title( $parent->comment_post_ID ) );
	$reply        = 'Per rispondere:';
	$comment_link = get_comment_link( $parent->comment_ID );
	$stop         = 'Per non ricevere più questi messaggi:';
}
?>
<p>
	<?php echo $hello . ' ' . $parent->comment_author; ?>,
</p>

<p><?php echo $comment->comment_author . ' ' . $replied; ?>
	<a href="<?php echo $link; ?>">
		<?php echo $title; ?>
	</a>
</p>

<p>
<blockquote>
	<em>
		<?php echo esc_html( $comment->comment_content ) ?>
	</em>
</blockquote>
</p>

<p><?php echo $reply; ?><br/>
	<a href="<?php echo $comment_link; ?>">
		<?php echo $comment_link; ?>
	</a>
</p>

<p><?php echo $stop; ?><br/>
	<a href="<?php echo xlt_get_unsubscribe_link( $parent ); ?>">
		<?php echo xlt_get_unsubscribe_link( $parent ); ?>
	</a>
</p>

<p>
	<small>
		<em>--<br/>
			xlthlx's friendly email robot.
		</em>
	</small>
</p>
