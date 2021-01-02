<?php
/**
 * The Template for displaying all single posts.
 *
 * @package  WordPress
 * @subpackage  Xlthlx
 */

$context         = Timber::context();
$timber_post     = Timber::query_post();
$context['post'] = $timber_post;
$context['lang'] = get_lang();
$context['class_it'] = get_query_var( 'class_it' );
$context['class_en'] = get_query_var( 'class_en' );

$context['post']->date_en = get_date_en();

if ( post_password_required( $timber_post->ID ) ) {
	Timber::render( 'single-password.twig', $context );
} else {
	Timber::render( array( 'single-' . $timber_post->ID . '.twig', 'single-' . $timber_post->post_type . '.twig', 'single-' . $timber_post->slug . '.twig', 'single.twig' ), $context );
}
