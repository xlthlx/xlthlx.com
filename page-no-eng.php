<?php
/**
 * Template Name: No Eng
 *
 * @package  WordPress
 * @subpackage  Xlthlx
 */

$context = Timber::context();

$timber_post     = new Timber\Post();
$context['post'] = $timber_post;

Timber::render( 'page-no-eng.twig', $context );
