<?php
/**
 * Homepage template.
 *
 * @package  WordPress
 * @subpackage  Xlthlx
 */

$context = Timber::context();

global $paged;
if ( ! isset( $paged ) || ! $paged ) {
	$paged = 1;
}
$context['posts'] = new Timber\PostQuery( array( 'paged' => $paged ) );

$context['category'] = Timber::get_terms( [
	'taxonomy'   => 'category',
	'hide_empty' => 1,
] );

Timber::render( array( 'home.twig' ), $context );
