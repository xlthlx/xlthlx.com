<?php
/**
 * Search results page
 *
 * @package  WordPress
 * @subpackage  Xlthlx
 */

$templates = array( 'search.twig', 'archive.twig', 'index.twig' );

$context          = Timber::context();
$context['title'] = sprintf( __( 'Search results for: "%s"' ), get_search_query() );
$context['posts'] = new Timber\PostQuery();

Timber::render( $templates, $context );
