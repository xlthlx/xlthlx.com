<?php
/**
 * Template part for displaying all terms.
 *
 * @package  xlthlx
 */

if ( function_exists( 'xlt_get_the_terms' ) ) {
	$cats = xlt_get_the_terms( 'category' );
	if ( '' !== $cats ) { ?>
			<?php echo $cats; ?>
		<?php
	}
}
