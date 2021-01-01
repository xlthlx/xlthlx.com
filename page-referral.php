<?php
/**
 * Template Name: Referral
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
	'category_name' => 'Referral'
) );

$ref = '';

foreach ( $bookmarks as $bookmark ) {
	$ref .= '<p>';
	$ref .= '<a title="' . $bookmark->link_name . '" target="_blank" href="' . $bookmark->link_url . '">' . $bookmark->link_name . '</a>';
	if ( '' !== $bookmark->link_description ) {
		$ref .= '<br />' . $bookmark->link_description;
	}
	$ref .= '</p>';
}

$context['referral'] = $ref;

$money = get_bookmarks( array(
	'orderby'       => 'name',
	'order'         => 'ASC',
	'category_name' => 'Money'
) );

$coffee = '';

foreach ( $money as $send ) {
	$coffee .= '<p>';
	$coffee .= '<a title="' . $send->link_name . '" target="_blank" href="' . $send->link_url . '">' . $send->link_name . '</a>';
	if ( '' !== $send->link_description ) {
		$coffee .= '<br />' . $send->link_description;
	}
	$coffee .= '</p>';
}

$context['coffee'] = $coffee;
Timber::render( array( 'page-referral.twig' ), $context );
