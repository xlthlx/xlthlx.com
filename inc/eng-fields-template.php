<?php
/**
 * Frontend functions for English translation
 *
 * @package  WordPress
 * @subpackage  Xlthlx
 */

use simplehtmldom\HtmlDocument;

/**
 * Translate a piece of string.
 *
 * @param $element
 *
 * @return array|string
 */
function xlt_translate( $element ) {
	$trans_content = '';

	$trc = new Dejurin\GoogleTranslateForFree();

	try {
		$trans_content = $trc::translate( 'it', 'en', $element, 5 );

	} catch ( Exception $ex ) {
		error_log( $ex );
	}

	return $trans_content;
}

/**
 * Translate the month of the date.
 *
 * @return mixed
 */
function get_date_en() {
	global $post;
	$post_id = $post->ID;

	if ( ! is_home() || ! is_archive() ) {
		if ( ! get_post_meta( $post_id, 'date_en',
				true ) || get_post_meta( $post_id, 'date_en', true ) === '' ) {
			$month = xlt_translate( get_the_time( 'F', $post_id ) );
			$date  = get_the_time( 'd', $post_id ) . ' ' . ucfirst( $month ) . ' ' . get_the_time( 'Y', $post_id );
			update_post_meta( $post_id, 'date_en', $date );
		}
	}

	return get_post_meta( $post_id, 'date_en', true );
}

/**
 * Translate the title.
 *
 * @return string $title
 */
function get_title_en() {
	global $post;
	$post_id = $post->ID;

	if ( ! get_post_meta( $post_id, 'title_en', true )
	     || get_post_meta( $post_id, 'title_en', true ) === '' ) {

		$title = xlt_translate( get_the_title( $post_id ) );
		update_post_meta( $post_id, 'title_en', $title );
	}

	return apply_filters( 'the_title', get_post_meta( $post_id, 'title_en', true ) );
}

/**
 * Translate the content.
 *
 * @return string $content
 * @throws Exception
 */
function get_content_en() {
	global $post;
	$post_id = $post->ID;

	if ( ! get_post_meta( $post_id, 'content_en', true )
	     || get_post_meta( $post_id, 'content_en', true ) === '' ) {
		$blocks = parse_blocks( get_the_content() );
		$doc    = new HtmlDocument();
		$output = '';

		foreach ( $blocks as $block ) {

			$block_types = array(
				'core/paragraph',
				'core/heading',
				'core/freeform',
				'core/list',
				'core/quote',
				'core/pullquote',
				'core/html',
				'core/table',
				'core/text-columns'
			);

			if ( isset( $block['blockName'] ) && $block['blockName'] !== '' && in_array( $block['blockName'], $block_types, true ) ) {

				$html = $doc->load( $block['innerHTML'] );
				$p    = $html->find( "p" );

				$to_remove = array();

				if ( $p ) {

					foreach ( $p as $pg ) {

						$tags = array(
							"em",
							"strong",
							"h1",
							"h2",
							"h3",
							"h4",
							"h5",
							"h6",
							"li"
						);

						foreach ( $tags as $tag ) {
							$plain_tag = $pg->find( $tag );
							if ( $plain_tag ) {
								foreach ( $plain_tag as $pt ) {
									$trans_tag     = xlt_translate( $pt->innertext );
									$pt->innertext = $trans_tag;
									$to_remove[]   = $pt->outertext;
								}
							}
						}

						$plain_a = $pg->find( "a" );

						if ( $plain_a ) {
							foreach ( $plain_a as $pa ) {
								$trans_a       = xlt_translate( $pa->innertext );
								$pa->innertext = $trans_a;
								if ( $pa->title ) {
									$title_a   = xlt_translate( $pa->title );
									$pa->title = $title_a;
								}
								$to_remove[] = $pa->outertext;
							}
						}

						$plain_p = $pg;

						$i = 0;
						foreach ( $to_remove as $remove ) {
							$plain_p = str_replace( $remove, '{' . $i . '}', $plain_p );
							$i ++;
						}


						$plain_p = str_replace( array(
							'<p>',
							'</p>'
						), '', $plain_p );

						$trans_p = xlt_translate( $plain_p );

						$i = 0;
						foreach ( $to_remove as $remove ) {
							$trans_p = str_replace( '{' . $i . '}', $remove, $trans_p );
							$i ++;
						}

						$pg->outertext = '<p>' . $trans_p . '</p>';
					}
				}

				$output .= $html;

			} else {
				$output .= $block['innerHTML'];
			}
		}

		$output .= '<!-- GT -->';

		update_post_meta( $post_id, 'content_en', $output );
	}

	return apply_filters( 'the_content', get_post_meta( $post_id, 'content_en', true ) );
}

/**
 * Get language var.
 *
 * @param bool $is_archive
 *
 * @return string|string[]
 */
function get_lang( $is_archive = false ) {
	$link = ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ?
			"https" : "http" ) . "://" . $_SERVER['HTTP_HOST'] .
	        $_SERVER['REQUEST_URI'];

	$lang = 'it';
	$pos  = strpos( $link, '/en/' );

	if ( $pos !== false ) {

		$lang = 'en';

		$link_it = str_replace( 'en/', '', $link );

		if ( $is_archive ) {
			$link_it = str_replace( '/en/', '', $link );
		}

		set_query_var( 'url_it', $link_it );
		set_query_var( 'url_en', $link );
		set_query_var( 'class_it', '' );
		set_query_var( 'class_en', ' active' );


	} else {

		$link_en = $link . 'en/';

		set_query_var( 'url_it', $link );
		set_query_var( 'url_en', $link_en );
		set_query_var( 'class_it', ' active' );
		set_query_var( 'class_en', '' );

	}

	return $lang;
}

/**
 * Sets search page title.
 *
 * @return string
 */
function get_search_title() {
	global $wp_query;
	$title = '<h2 class="h3-responsive text-center white indigo-text p-3 mt-4 mb-4">';
	$title .= $wp_query->found_posts . ' risultati per: ';
	$title .= urldecode( get_query_var( 's' ) ) . '</h2>';

	return $title;
}

/**
 * Sets archive page title.
 *
 * @return string
 */
function get_archive_title() {

	$title = '<h2 class="h3-responsive text-center white indigo-text p-3 mt-4 mb-4">';
	$text  = 'Archivio';

	if ( is_category() ) {
		$text = single_cat_title( '', false );
	}

	if ( is_tag() ) {
		$text = single_cat_title( '', false );
	}

	if ( is_day() ) {
		$text = get_the_time( 'd F Y' );
	}

	if ( is_month() ) {
		$text = get_the_time( 'F Y' );
	}

	if ( is_year() ) {
		$text = get_the_time( 'Y' );
	}

	if ( is_author() ) {
		$author = ( isset( $_GET['author_name'] ) ) ? get_user_by( 'slug', $_GET['author_name'] ) : get_userdata( (int) get_user_by( 'ID', $_GET['author_name'] ) );
		$prefix = 'Tutti gli articoli di ';
		$text   = $prefix . $author->display_name;
	}

	return $title . $text . '</h2>';
}

add_action( 'comment_post', 'xlt_save_comment_lang' );
/**
 * Save comment meta lang.
 *
 * @param $comment_id
 */
function xlt_save_comment_lang( $comment_id ) {
	update_comment_meta( $comment_id, 'comment_lang', $_POST['comment_lang'] );
}

add_filter( 'query_vars', 'xlt_query_vars_lang' );
/**
 * Add query var.
 *
 * @param $vars
 *
 * @return mixed
 */
function xlt_query_vars_lang( $vars ) {
	$vars[] = 'en';

	return $vars;
}

add_action( 'template_redirect', 'xlt_template_redirect' );
/**
 * Template redirect for en.
 */
function xlt_template_redirect() {
	global $wp_query;

	if ( ! isset( $wp_query->query_vars['en'] ) ) {
		return;
	}
	$template = '/index.php';

	if ( is_single() ) {
		$template = '/single.php';
	}

	if ( is_page() && ! is_paged() ) {
		$template = '/page.php';
	}

	if ( is_archive() ) {
		$template = '/archive.php';
	}

	if ( is_search() ) {
		$template = '/search.php';
	}

	set_query_var( 'template', $template );

	include( get_template_directory() . $template );
	exit;
}

add_action( 'init', 'xlt_rewrite_tags_lang' );
/**
 * Add rewrite endpoint.
 */
function xlt_rewrite_tags_lang() {

	add_rewrite_endpoint( 'en', EP_ALL, 'en' );

}

add_action( 'pre_get_posts', 'xlt_home_posts_per_page' );
/**
 * Control the number of search results
 *
 * @param $query
 */
function xlt_home_posts_per_page( $query ) {

	if ( ! is_admin() && $query->is_main_query() && is_front_page() ) {
		set_query_var( 'posts_per_page', 5 );
	}
}
