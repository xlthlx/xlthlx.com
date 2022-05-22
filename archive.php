<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package  WordPress
 * @subpackage  Xlthlx
 */

$templates = array( 'archive.twig', 'index.twig' );

$context          = Timber::context();
$context['title'] = 'Archivio';

if ( 'en' === $context['lang'] ) {
	$context['title'] = 'Archive';
}

if ( is_day() ) {
	$context['title'] = get_the_date( 'D M Y' );
} elseif ( is_month() ) {
	$context['title'] = get_the_date( 'M Y' );
} elseif ( is_year() ) {
	$context['title'] = get_the_date( 'Y' );
} elseif ( is_tag() ) {
	$context['title'] = single_tag_title( '', false );
} elseif ( is_category() ) {
	$context['title'] = single_cat_title( '', false );
	array_unshift( $templates, 'archive-' . get_query_var( 'cat' ) . '.twig' );
} elseif ( is_post_type_archive() ) {
	$context['title'] = post_type_archive_title( '', false );
	array_unshift( $templates, 'archive-' . get_post_type() . '.twig' );
}

$context['posts'] = new Timber\PostQuery();

foreach ( $context['posts'] as $context['post'] ) {
	$context['post']->title_en   = get_title_en();
	$context['post']->date_en    = get_date_en();
	$context['post']->preview_en = xlt_get_excerpt( get_content_en() );
}

Timber::render( $templates, $context );
