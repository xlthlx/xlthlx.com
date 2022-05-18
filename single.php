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

$context['post']->title_en   = get_title_en();
$context['post']->date_en    = get_date_en();
$context['post']->content_en = get_content_en();

if ( post_password_required( $timber_post->ID ) ) {
	Timber::render( 'single-password.twig', $context );
} else {
	Timber::render( 'single.twig', $context );
}
