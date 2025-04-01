<?php
/**
 * The template for displaying comments and comment form.
 *
 * @package  xlthlx
 */

if ( post_password_required() ) {
	return;
}

global $lang;
$single_id = get_the_ID();

$args = array(
	'meta_key'     => 'comment_lang',
	'meta_value'   => $lang,
	'orderby'      => 'comment_date',
	'order'        => 'ASC',
	'post_id'      => $single_id,
	'type'         => 'comment',
	'hierarchical' => 'threaded',
);


$all_comments = get_comments( $args ); ?>
	<div id="post-comments" class="xlt-row xlt-row_break">
		<div class="xlt-spacing"></div>
		<div class="xlt-comments__loop xlt-spacing">
			<h2 class="xlt-comments__title"><?php echo ( 'en' === $lang ) ? 'Thread' : 'Discussione'; ?></h2>
			<?php if ( $all_comments ) { ?>
			<div id="comments">
				<ol class="xlt-comments">
					<?php foreach ( $all_comments as $single_comment ) {
						set_query_var( 'comment', $single_comment ); ?>
						<?php get_template_part( 'parts/comment' ); ?>
					<?php } ?>
				</ol>
			</div>
			<?php } ?>
			<div id="respond" class="comment-respond">
				<?php
				if ( function_exists( 'xlt_comment_form' ) && function_exists( 'xlt_comment_form_en' ) ) {
					( 'en' === $lang ) ? xlt_comment_form_en() : xlt_comment_form();
				}
				?>
			</div>
		</div>
	</div>
