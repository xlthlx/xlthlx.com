<?php
/**
 * Template part for displaying the single post in a list.
 *
 * @package  xlthlx
 */

global $lang, $post;
$text_more = ( 'en' === $lang ) ? "Keep reading: '" : "Continua a leggere: '";
?>
<article id="<?php echo $post->post_type; ?>-<?php echo $post->ID; ?>" <?php post_class( array( 'xlt-entry', 'tease' ) ); ?>>

	<div class="xlt-entry__content xlt-spacing-min">
		<div class="xlt-entry__header">
			<header>
				<p class="xlt-entry__before-title">
					<time class="entry-date published" datetime="
					<?php
					if ( function_exists( 'xlt_atom_date' ) ) {
						echo xlt_atom_date( $post->post_date );
					}
					?>
					">
						<?php echo get_the_date(); ?></time>
					<time class="updated screen-reader-text" datetime="
					<?php
					if ( function_exists( 'xlt_atom_date' ) ) {
						echo xlt_atom_date( $post->post_modified );
					}
					?>
					">
						<?php echo get_the_date(); ?></time>
				</p>

				<h2 class="xlt-entry__title">
					<a title="<?php echo $text_more . get_the_title(); ?>"
					   aria-label="<?php echo $text_more . get_the_title(); ?>"
					   href="<?php echo get_the_permalink(); ?>">
						<?php echo get_the_title(); ?>
					</a>
				</h2>
			</header>
		</div>
	</div>

</article>
