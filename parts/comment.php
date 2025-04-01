<?php
/**
 * Template part for comment.
 *
 * @package  xlthlx
 */

global $lang, $args;
$parent_id = get_the_ID();
$args['comment'] = get_query_var('comment');
if ( isset( $args['comment'] ) ) {
	?>
<li id="comment-<?php echo $args['comment']->comment_ID; ?>"
	class="comment even thread-even depth-1 parent <?php echo $args['comment']->comment_type . '-' . $lang; ?>">
	<article id="div-comment-<?php echo $args['comment']->comment_ID; ?>" class="comment-body">
		<footer class="comment-meta">
			<div class="comment-author vcard">
				<?php echo function_exists( 'xlt_get_avatar' ) ? xlt_get_avatar( $args['comment'], $args['comment']->comment_author ) : ''; ?>
				<b class="fn">
					<?php echo function_exists( 'xlt_get_author' ) ? xlt_get_author( $args['comment'] ) : ''; ?>
				</b>
			</div>

			<div class="comment-metadata">
				<a href="<?php echo esc_url( get_comment_link( $args['comment'] ) ); ?>">
					<time datetime="<?php echo function_exists( 'xlt_atom_date' ) ? xlt_atom_date( $args['comment']->comment_date ) : ''; ?>">
						<?php echo function_exists( 'xlt_get_comment_date' ) ? xlt_get_comment_date( $args['comment']->comment_date ) : ''; ?>
					</time>
				</a>
				<?php if ( is_user_logged_in() ) { ?>
					<span class="edit-link">
					<a class="comment-edit-link"
					   href="<?php echo esc_url( get_edit_comment_link( $args['comment'] ) ); ?>">
						<?php echo ( 'en' === $lang ) ? 'Edit' : 'Modifica'; ?>
					</a>
				</span>
				<?php } ?>
			</div>

		</footer>

		<div class="comment-content">
			<?php echo wpautop( $args['comment']->comment_content ); ?>
		</div>

		<div class="reply">
			<?php
			$default = array(
				'add_below'  => 'comment',
				'respond_id' => 'respond-' . $args['comment']->comment_ID,
				'reply_text' => ( 'en' === $lang ) ? 'Reply' : 'Rispondi',
				'depth'      => 1,
				'max_depth'  => get_option( 'thread_comments_depth' ),
			);
			?>
			<?php comment_reply_link( $default, $args['comment']->comment_ID, $parent_id ); ?>
		</div>
	</article>

	<?php if ( null !== $args['comment']->get_children() ) { ?>
		<?php $all_comments = $args['comment']->get_children(); ?>
		<?php foreach ( $all_comments as $single_comment ) { ?>
			<ol class="children">
				<?php get_template_part( 'parts/comment', null, array( 'comment' => $single_comment ) ); ?>
			</ol>
		<?php } ?>
	<?php } ?>
	<?php
}
