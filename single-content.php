<?php
/**
 * The Template for displaying the content of a single post.
 *
 * @package  WordPress
 * @subpackage  Xlthlx
 */

require_once( '../../../wp-load.php' );

$id   = filter_var( $_REQUEST['id'], FILTER_SANITIZE_NUMBER_INT );
$lang = filter_var( $_REQUEST['lang'], FILTER_SANITIZE_STRING );

if ( $id !== '' && $lang !== '' ) {
	$posts   = new Timber\PostQuery( array( 'p' => $id ) );
	$context = Timber::context();

	if ( $lang === 'en' ) {
		$context['class_it'] = ' active';
		$context['class_en'] = '';

	} else {
		$context['class_it'] = '';
		$context['class_en'] = ' active';
	}

	$post = $posts[0];

	$context['post'] = $post;
	$context['lang'] = $lang;

	$context['post']->title_en   = get_title_en();
	$context['post']->date_en    = get_date_en();
	$context['post']->content_en = get_content_en();

	Timber::render( 'single-content.twig', $context );
}
else {
	$context = Timber::context();
	Timber::render( '404.twig', $context );
}

