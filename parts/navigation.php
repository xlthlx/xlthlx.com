<?php
/**
 * Template part for post navigation.
 *
 * @package  xlthlx
 */

global $lang;
$prev = ( 'en' === $lang ) ? 'Previous article' : 'Articolo precedente';
$next = ( 'en' === $lang ) ? 'Next article' : 'Articolo successivo';
?>
<div class="xlt-row xlt-post-nav xlt-row_break">


	<div class="xlt-post-nav__item xlt-post-nav__item_prev xlt-spacing">
		<?php if ( '' !== get_previous_post_link( '%link' ) ) { ?>
			<p><?php echo $prev; ?></p>
			<?php echo get_previous_post_link( '%link' ); ?>
			<svg fill="var(--theme-text-color)" aria-label="<?php echo $prev; ?>" role="img" height="31" viewBox="0 0 50 31" width="50" xmlns="http://www.w3.org/2000/svg">
				<path d="m1060.3125 264.84375c-.625-.625003-.625-1.249997 0-1.875l10.46875-11.5625h-44.53125c-.83334 0-1.25-.41666-1.25-1.25s.41666-1.25 1.25-1.25h44.53125l-10.46875-11.5625c-.625-.625-.625-1.25 0-1.875s1.25-.625 1.875 0c8.22921 9.06255 12.39583 13.64583 12.5 13.75.20833.20833.3125.52083.3125.9375s-.10417.72917-.3125.9375l-12.5 13.75c-.20833.208334-.52083.3125-.9375.3125s-.72917-.104166-.9375-.3125z"
					  fill-rule="evenodd" transform="translate(-1025 -235)"/>
			</svg>
		<?php } ?>
	</div>

	<div class="xlt-post-nav__item xlt-post-nav__item_next xlt-spacing">
		<?php if ( '' !== get_next_post_link( '%link' ) ) { ?>
			<p><?php echo $next; ?></p>
			<?php echo get_next_post_link( '%link' ); ?>
			<svg fill="var(--theme-text-color)" aria-label="<?php echo $next; ?>" role="img" height="31" viewBox="0 0 50 31" width="50" xmlns="http://www.w3.org/2000/svg">
				<path d="m1060.3125 264.84375c-.625-.625003-.625-1.249997 0-1.875l10.46875-11.5625h-44.53125c-.83334 0-1.25-.41666-1.25-1.25s.41666-1.25 1.25-1.25h44.53125l-10.46875-11.5625c-.625-.625-.625-1.25 0-1.875s1.25-.625 1.875 0c8.22921 9.06255 12.39583 13.64583 12.5 13.75.20833.20833.3125.52083.3125.9375s-.10417.72917-.3125.9375l-12.5 13.75c-.20833.208334-.52083.3125-.9375.3125s-.72917-.104166-.9375-.3125z"
					  fill-rule="evenodd" transform="translate(-1025 -235)"/>
			</svg>
		<?php } ?>
	</div>

</div>
