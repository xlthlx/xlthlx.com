<?php
/**
 * Template Name: Makeup
 *
 * @package  WordPress
 * @subpackage  Xlthlx
 */

$context = Timber::context();

$timber_post     = new Timber\Post();
$context['post'] = $timber_post;

$bookmarks = get_bookmarks( array(
	'orderby'       => 'name',
	'order'         => 'ASC',
	'category_name' => 'Makeup'
) );

$makeup = '';

foreach ( $bookmarks as $bookmark ) {
	$makeup .= '<p>';
	$makeup .= '<a title="' . $bookmark->link_name . '" target="_blank" href="' . $bookmark->link_url . '">' . $bookmark->link_name . '</a>';
	if ( '' !== $bookmark->link_description ) {
		$makeup .= '<br />' . $bookmark->link_description;
	}
	$makeup .= '</p>';
}

$context['makeup'] = $makeup;
Timber::render( array( 'page-makeup.twig' ), $context );
