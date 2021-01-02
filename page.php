<?php
/**
 * The template for displaying all pages.
 *
 * @package  WordPress
 * @subpackage  Xlthlx
 */

$context = Timber::context();

$timber_post     = new Timber\Post();
$context['post'] = $timber_post;
$context['lang'] = get_lang();
$context['class_it'] = get_query_var( 'class_it' );
$context['class_en'] = get_query_var( 'class_en' );

Timber::render( array( 'page-' . $timber_post->post_name . '.twig', 'page.twig' ), $context );
