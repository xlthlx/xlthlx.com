<?php
/**
 * The template for displaying all pages.
 *
 * @package  WordPress
 * @subpackage  Xlthlx
 */

$context = Timber::context();

$timber_post         = new Timber\Post();
$context['post']     = $timber_post;
$context['lang']     = get_lang();

$context['post']->title_en   = get_title_en();
$context['post']->content_en = get_content_en();

Timber::render( 'page.twig', $context );
