<?php
/**
 * Search results page
 *
 * @package  WordPress
 * @subpackage  Xlthlx
 */

$templates = array( 'search.twig', 'archive.twig', 'index.twig' );

$context          = Timber::context();
$context['title'] = 'Risultati della ricerca per: ' .get_search_query();

if ( 'en' === $context['lang'] ) {
	$context['title'] = 'Search results for: ' .get_search_query();
}
$context['posts'] = new Timber\PostQuery();

foreach ( $context['posts'] as $context['post'] ) {
	$context['post']->title_en   = get_title_en();
	$context['post']->date_en    = get_date_en();
	$context['post']->preview_en = xlt_get_excerpt( get_content_en() );
}

Timber::render( $templates, $context );