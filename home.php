<?php
/**
 * Homepage template.
 *
 * @package  WordPress
 * @subpackage  Xlthlx
 */

$context = Timber::context();

$paged = ( get_query_var( 'paged' ) ) ?: 1;
if ( 'en' === $context['lang'] ) {
	$paged = ( get_query_var( 'page' ) ) ?: 1;
}

$sticky = get_option( 'sticky_posts' );
$first  = array_slice( $sticky, 0, 1 );

$offset = array();

if ( count( $first ) === 1 ) {
	$context['first_posts'] = new Timber\PostQuery( array(
		'post__in'            => $first,
		'ignore_sticky_posts' => 1
	) );

	$offset = $first;
} else {
	$context['first_posts'] = new Timber\PostQuery( array( 'posts_per_page' => 1 ) );
	$offset[0]              = $context['first_posts'][0]->ID;
}

foreach ( $context['first_posts'] as $context['first_post'] ) {
	$context['first_post']->title_en   = get_title_en();
	$context['first_post']->date_en    = get_date_en();
	$context['first_post']->preview_en = xlt_get_excerpt( get_content_en(),
		40 );
}

if ( count( $first ) === 1 ) {
	$offset = array_slice( $sticky, 0, 3 );
}

$context['posts'] = new Timber\PostQuery( array(
	'post__not_in' => $offset,
	'paged'        => $paged
) );

foreach ( $context['posts'] as $context['post'] ) {
	$context['post']->title_en   = get_title_en();
	$context['post']->date_en    = get_date_en();
	$context['post']->preview_en = xlt_get_excerpt( get_content_en() );
}

$context['category'] = Timber::get_terms( [
	'taxonomy'   => 'category',
	'hide_empty' => 1,
] );

Timber::render( array( 'home.twig' ), $context );
