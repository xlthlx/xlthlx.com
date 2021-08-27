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
$context['friends'] = wp_list_bookmarks( 'title_li=&categorize=0&category=133&echo=0' );
Timber::render( array( 'page-friends.twig' ), $context );
