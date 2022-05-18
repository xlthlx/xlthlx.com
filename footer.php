<?php
/**
 * Footer.
 *
 * @package  WordPress
 * @subpackage  Xlthlx
 */

use Timber\Timber;

$context = $GLOBALS['timberContext'];
if ( ! isset( $timberContext ) ) {
	throw new RuntimeException( 'Timber context not set in footer.' );
}
$context['content'] = ob_get_clean();

$templates = array( 'footer.twig' );
Timber::render( $templates, $context );
