<?php
/**
 * Template Name: Subscribe to Comments
 *
 * @package  WordPress
 * @subpackage  Xlthlx
 */

$context = Timber::context();

$timber_post     = new Timber\Post();
$context['post'] = $timber_post;
$context['lang'] = get_lang();

$context['post']->title_en   = get_title_en();
$context['post']->content_en = get_content_en();

if ( isset( $wp_subscribe_reloaded ) ) {
	$sub_post                      = $wp_subscribe_reloaded->stcr->subscribe_reloaded_manage();
	$context['post']->post_content = $sub_post[0]->post_content;
	$context['post']->content_en   = $sub_post[0]->post_content;
}

Timber::render( 'page.twig', $context );

