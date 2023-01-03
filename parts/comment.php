<?php
/**
 * Template part for comment.
 *
 * @package  xlthlx
 */

global $lang;
$parent_id = get_the_ID();
?>
<section class="blog-comment <?php echo $args['comment']->comment_type . '-' . $lang; ?>"
	id="comment-<?php echo $args['comment']->comment_ID; ?>">
	<hr class="mb-4"/>
	<div class="card mb-3 rounded-0 border-0">
		<div class="row g-0">
			<div class="col-md-1">
				<?php echo xlt_get_avatar( $args['comment'], $args['comment']->comment_author ); ?>
			</div>
			<div class="col-md-11">
				<div class="card-body py-0">
					<div class="card-text comment-date pb-2">
						<time datetime="<?php echo $args['comment']->comment_date_gmt; ?>">
							<small class="text-muted">
								<?php echo date( 'd/m/Y', strtotime( $args['comment']->comment_date ) ); ?>
							</small>
						</time>
					</div>
					<h5 class="card-title comment-author"><?php echo xlt_get_author( $args['comment'] ); ?></h5>
					<div class="card-text comment-content">
						<?php echo wpautop( $args['comment']->comment_content ); ?>
					</div>
					<p class="card-text">
						<?php if ( is_user_logged_in() ) { ?>
							<small class="pe-3">
								<a href="<?php echo esc_url( get_edit_comment_link( $args['comment'] ) ); ?>">
									<?php echo ( 'en' === $lang ) ? 'Edit &raquo;' : 'Modifica &raquo;'; ?>
								</a>
							</small>
						<?php } ?>
						<?php
						$default = array(
							'add_below'  => 'comment',
							'respond_id' => 'respond',
							'reply_text' => ( 'en' === $lang ) ? 'Reply &raquo;' : 'Rispondi &raquo;',
							'depth'      => 1,
							'max_depth'  => get_option( 'thread_comments_depth' ),
						);
						?>
						<small><?php comment_reply_link( $default, $args['comment']->comment_ID, $parent_id ); ?></small>
					</p>
				</div>
			</div>
		</div>
	</div>
</section>

<?php if ( null !== $args['comment']->get_children() ) { ?>
	<?php $all_comments = $args['comment']->get_children(); ?>
	<?php foreach ( $all_comments as $single_comment ) { ?>
		<div class="comments ml-5 children">
			<?php get_template_part( 'parts/comment', null, array( 'comment' => $single_comment ) ); ?>
		</div>
	<?php } ?>
<?php } ?>
