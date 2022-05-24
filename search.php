<?php
/**
 * Search results page
 *
 * @package  WordPress
 * @subpackage  Xlthlx
 */

$templates = array( 'search.twig' );
$context   = Timber::context();

$context['title'] = ( 'en' === $context['lang'] ) ? 'Search results for: ' . get_query_var( 's' ) : 'Risultati della ricerca per: ' . get_query_var( 's' );

$paged = ( get_query_var( 'paged' ) ) ?: 1;

$context['posts'] = new Timber\PostQuery( array(
	'paged' => $paged,
	's'     => get_query_var( 's' )
) );

foreach ( $context['posts'] as $context['post'] ) {
	$context['post']->title_en   = get_title_en();
	$context['post']->date_en    = get_date_en();
	$context['post']->preview_en = xlt_get_excerpt( get_content_en() );
}

Timber::render( $templates, $context );
