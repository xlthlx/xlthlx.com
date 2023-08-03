<?php
/**
 * Template part for displaying all terms.
 *
 * @package  xlthlx
 */

$cats = xlt_get_the_terms( 'category' );
if ( '' !== $cats ) { ?>
		<?php echo $cats; ?>
	<?php
}
