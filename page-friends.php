<?php
/**
 * Template Name: Friends
 *
 * @package  WordPress
 * @subpackage  Xlthlx
 */

$context = Timber::context();

$timber_post        = new Timber\Post();
$context['post']    = $timber_post;

$context['post']->title_en   = get_title_en();
$context['post']->content_en = get_content_en();

$context['friends'] = wp_list_bookmarks( 'title_li=&categorize=0&category=133&echo=0' );
Timber::render( array( 'page-friends.twig' ), $context );
