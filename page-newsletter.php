<?php
/**
 * Template Name: Newsletter
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
$context['scrivi']           = false;

$lan = get_query_var( 'lan', false );
if ( $lan ) {
	$act = get_query_var( 'act' );
	$cod = get_query_var( 'cod' );

	$context['lang']   = $lan;
	$context['act']    = $act;
	$context['cod']    = $cod;
	$context['scrivi'] = true;

	$args = array(
		'numberposts' => - 1,
		'post_type'   => 'flamingo_contact',
		'meta_key'    => '_code',
		'meta_value'  => $cod,
	);

	$context['query'] = get_posts( $args );
	wp_reset_postdata();

	switch ( $act ) {
		case 'confirm':
			$context['post']->title      = 'Email verificata';
			$context['post']->content    = 'Grazie per aver verificato il tuo indirizzo email.';
			$context['post']->title_en   = 'Email verified';
			$context['post']->content_en = 'Thank you for verifying your email address.';
			break;
		case 'unsubscribe':
			$context['post']->title      = 'Email cancellata.';
			$context['post']->content    = 'Arrivederci!';
			$context['post']->title_en   = 'Email deleted.';
			$context['post']->content_en = 'See ya!';
			break;
		case 'error':
			$context['post']->title      = 'Oh-oh';
			$context['post']->content    = "C'è stato un problema, i criceti che gestiscono il sito sono perplessi.";
			$context['post']->title_en   = 'Uh-oh';
			$context['post']->content_en = 'There was a problem, the hamsters who run the site are perplexed.';
	}
}

Timber::render( 'page-newsletter.twig', $context );
