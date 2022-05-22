<?php
/**
 * Search results page
 *
 * @package  WordPress
 * @subpackage  Xlthlx
 */

$templates = array( 'search.twig', 'archive.twig', 'index.twig' );

$context          = Timber::context();

$url = get_abs_url();

if ( 'en' === $context['lang'] ) {
	$url = str_replace( get_home_url() . '/search/en/', '', $url );
}
else {
	$url = str_replace( get_home_url() . '/search/', '', $url );
}

$page = explode( "/", $url );

if ( isset( $page[0] ) ) {
	$s = $page[0];
	set_query_var( 's', $page[0] );
}

if ( isset( $page[1], $page[2] ) && 'page' === $page[1] ) {
	$paged = (int) $page[2];
	set_query_var( 'paged', (int) $page[2] );
}

$context['title'] = 'Risultati della ricerca per: ' . get_query_var( 's' );
if ( 'en' === $context['lang'] ) {
	$context['title'] = 'Search results for: ' . get_query_var( 's' );
}

$paged = ( get_query_var( 'paged' ) ) ?: 1;

$context['posts'] = new Timber\PostQuery( array(
	'paged' => $paged,
	's'     => $s
) );

foreach ( $context['posts'] as $context['post'] ) {
	$context['post']->title_en   = get_title_en();
	$context['post']->date_en    = get_date_en();
	$context['post']->preview_en = xlt_get_excerpt( get_content_en() );
}

Timber::render( $templates, $context );