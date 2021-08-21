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

$lan = get_query_var( 'lan', false );

if ( $lan ) {
	$act = get_query_var( 'act' );
	$cod = get_query_var( 'cod' );
	$context['lang']   = $lan;

	$args = array(
		'numberposts' => - 1,
		'post_type'   => 'flamingo_contact',
		'meta_key'    => '_code',
		'meta_value'  => $cod,
	);

	$query = new WP_Query( $args );

	if ( $query->have_posts() ) {

		while ( $query->have_posts() ) {
			$query->the_post();

			switch ( $act ) {
				case 'confirm':
					$post_id = get_the_ID();
					update_post_meta( $post_id, '_active', 'si' );
					break;
				case 'unsubscribe':
					$post_id = get_the_ID();
					wp_delete_post( $post_id, true );
					$other_post_id = get_the_ID() + 1;
					wp_delete_post( $other_post_id, true );
					break;
			}

		}

	} else {
		$act = 'error';
	}

	wp_reset_postdata();

	$img = '<p><img class="img-fluid mx-auto d-block" src="' . get_template_directory_uri() . '/assets/img/404.gif" alt="Error"></p>';

	switch ( $act ) {
		case 'confirm':
			$context['post']->title      = 'Email verificata';
			$context['post']->content    = '<p>Grazie per aver verificato il tuo indirizzo email.</p>';
			$context['post']->title_en   = 'Email verified';
			$context['post']->content_en = '<p>Thank you for verifying your email address.</p>';
			break;
		case 'unsubscribe':
			$context['post']->title      = 'Email cancellata';
			$context['post']->content    = '<p>Non riceverai più email da noi.</p><p>Arrivederci!</p>';
			$context['post']->title_en   = 'Email deleted';
			$context['post']->content_en = '<p>You will no longer receive emails from us.</p><p>See you!</p>';
			break;
		case 'error':
			$context['post']->title      = 'Oh-oh';
			$context['post']->content    = "<p>C'è stato un problema, i criceti che gestiscono il sito sono perplessi.</p>" . $img;
			$context['post']->title_en   = 'Uh-oh';
			$context['post']->content_en = '<p>There was a problem, the hamsters who run the site are perplexed.</p>' . $img;
	}
}

Timber::render( 'page-newsletter.twig', $context );
