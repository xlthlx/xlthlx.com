<?php
/**
 * Template Name: Links
 *
 * @package  WordPress
 * @subpackage  Xlthlx
 */

$context = Timber::context();

$timber_post       = new Timber\Post();
$context['post']   = $timber_post;

$context['post']->title_en   = get_title_en();
$context['post']->content_en = get_content_en();

$context['first']  = wp_list_bookmarks( 'title_li=&categorize=0&category=664&echo=0' );
$context['second'] = wp_list_bookmarks( 'title_li=&categorize=0&category=665&echo=0' );
$context['third']  = wp_list_bookmarks( 'title_li=&categorize=0&category=666&echo=0' );
$context['fourth'] = wp_list_bookmarks( 'title_li=&categorize=0&category=667&echo=0' );

Timber::render( array( 'page-links.twig' ), $context );
