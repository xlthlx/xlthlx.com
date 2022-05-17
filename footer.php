<?php
/**
 * Footer.
 *
 * @package  WordPress
 * @subpackage  Xlthlx
 */

$context = $GLOBALS['timberContext'];
if ( ! isset( $timberContext ) ) {
	throw new Exception( 'Timber context not set in footer.' );
}
$context['content'] = ob_get_contents();
ob_end_clean();

$context['lang'] = get_lang();

$templates = array( 'footer.twig' );
Timber::render( $templates, $context );
