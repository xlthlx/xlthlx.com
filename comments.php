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
$post_id = get_the_ID();

$args = array(
	'meta_key'     => 'comment_lang',
	'meta_value'   => $lang,
	'orderby'      => 'comment_date',
	'order'        => 'ASC',
	'post_id'      => $post_id,
	'type'         => 'comment',
	'hierarchical' => 'threaded',
);

$comments = get_comments( $args );
if ( $comments ) { ?>
	<section id="post-comments" class="comment-box mb-5">
		<h3 class="mb-4"><?php echo ( 'en' === $lang ) ? 'Comments' : 'Commenti'; ?></h3>
		<?php foreach ( $comments as $comment ) { ?>
			<?php get_template_part( 'parts/comment', null, array( 'comment' => $comment ) ); ?>
		<?php } ?>
	</section>
<?php } ?>
<section id="comment-form" class="comment-box mb-5">
	<?php ( 'en' === $lang ) ? xlt_comment_form_en() : xlt_comment_form(); ?>
</section>
