<?php
/**
 * Frontend functions for English translation
 *
 * @package  WordPress
 * @subpackage  Xlthlx
 */

use simplehtmldom\HtmlDocument;
use Highlight\Highlighter;

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
		$trans_content = $trc::translate( 'it', 'en', $element );

	} catch ( Exception $ex ) {
		error_log( $ex );
	}

	return $trans_content;
}

/**
 * Translate the month of the date.
 *
 * @param int $post_id
 *
 * @return mixed
 */
function get_date_en( $post_id = 0 ) {
	if ( $post_id === 0 ) {
		global $post;
		$post_id = $post->ID;
	}

	$post_type = get_post_type( $post_id );

	if ( 'post' === $post_type ) {
		if ( ! is_home() || ! is_archive() ) {
			if ( ! get_post_meta( $post_id, 'date_en',
					true ) || get_post_meta( $post_id, 'date_en',
					true ) === '' ) {
				$month = xlt_translate( get_the_time( 'F', $post_id ) );
				$date  = get_the_time( 'd',
						$post_id ) . ' ' . ucfirst( $month ) . ' ' . get_the_time( 'Y',
						$post_id );
				update_post_meta( $post_id, 'date_en', $date );
			}
		}
	}

	return get_post_meta( $post_id, 'date_en', true );
}

/**
 * Translate the title.
 *
 * @param int $post_id
 *
 * @return string
 */
function get_title_en( $post_id = 0 ) {
	if ( $post_id === 0 ) {
		global $post;
		$post_id = $post->ID;
	}

	$post_type = get_post_type( $post_id );

	if ( 'post' === $post_type || 'page' === $post_type ) {
		if ( ! get_post_meta( $post_id, 'title_en', true )
		     || get_post_meta( $post_id, 'title_en', true ) === '' ) {

			$title = xlt_translate( get_the_title( $post_id ) );
			update_post_meta( $post_id, 'title_en', $title );
		}
	}

	return get_post_meta( $post_id, 'title_en', true );
}

/**
 * Translate the content.
 *
 * @param int $post_id
 *
 * @return string
 * @throws Exception
 */
function get_content_en( $post_id = 0 ) {

	if ( $post_id === 0 ) {
		global $post;
		$post_id = $post->ID;
	}

	$post_type = get_post_type( $post_id );

	if ( 'post' === $post_type || 'page' === $post_type ) {

		if ( ! get_post_meta( $post_id, 'content_en', true )
		     || get_post_meta( $post_id, 'content_en', true ) === '' ) {

			global $post;
			$blocks = parse_blocks( $post->post_content );
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
					'core/text-columns',
					'core/code'
				);

				if ( isset( $block['blockName'] ) && $block['blockName'] !== '' && in_array( $block['blockName'],
						$block_types, true ) ) {

					if ( $block['blockName'] === 'core/code' ) {
						$code = $doc->load( $block['innerHTML'] );

						if ( $code ) {

							$hl = new Highlighter();
							$hl->setAutodetectLanguages( array(
								'php',
								'javascript',
								'html'
							) );

							$code = str_replace( array(
								'<pre class="wp-block-code">',
								'<code>',
								'</code>',
								'</pre>'
							), '', html_entity_decode( $code ) );

							$highlighted = $hl->highlightAuto( $code );

							$code            = '<pre class="wp-block-code"><code class="hljs ' . $highlighted->language . '">' . $highlighted->value . '</code></pre>';
							$code->outertext = apply_filters( 'the_content',
								$code );

						}

						$output .= $code;
					} else {
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
									$plain_p = str_replace( $remove,
										'{' . $i . '}', $plain_p );
									$i ++;
								}


								$plain_p = str_replace( array(
									'<p>',
									'</p>'
								), '', $plain_p );

								$trans_p = xlt_translate( $plain_p );

								$i = 0;
								foreach ( $to_remove as $remove ) {
									$trans_p = str_replace( '{' . $i . '}',
										$remove, $trans_p );
									$i ++;
								}

								$pg->outertext = '<p>' . $trans_p . '</p>';
							}
						}

						$output .= $html;
					}

				} else {
					$output .= $block['innerHTML'];
				}
			}

			$output .= '<!-- GT -->';

			update_post_meta( $post_id, 'content_en', $output );
		}
	}

	return apply_filters( 'the_content',
		get_post_meta( $post_id, 'content_en', true ) );
}

/**
 * Gets absolute url.
 *
 * @return string
 */
function get_abs_url() {
	return ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ? "https" : "http" ) . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

/**
 * Get language var.
 *
 * @return string
 */
function get_lang() {
	$link = get_abs_url();

	$lang = 'it';
	$pos  = strpos( $link, '/en/' );

	if ( $pos !== false ) {
		$lang = 'en';
	}

	return $lang;
}

/**
 * Get url for language switcher.
 *
 * @return string
 */
function get_url_trans() {

	$link = get_abs_url();
	$pos  = strpos( $link, '/en/' );


	if ( is_category() ) {
		if ( $pos === false ) {
			$link = str_replace( '/cat/', '/cat/en/', $link );
		} else {
			$link = str_replace( 'en/', '', $link );
		}

		return $link;
	}

	if ( is_paged() ) {
		if ( $pos === false ) {
			$link = str_replace( '/page/', '/en/page/', $link );
		} else {
			$link = str_replace( '/en/page/', '/page/', $link );
		}

		return $link;
	}

	if ( $pos === false ) {
		$link .= 'en/';
	} else {
		$link = str_replace( 'en/', '', $link );
	}

	return $link;
}

/**
 * Save comment meta lang.
 *
 * @param $comment_id
 */
function xlt_save_comment_lang( $comment_id ) {
	update_comment_meta( $comment_id, 'comment_lang', $_POST['comment_lang'] );
}

add_action( 'comment_post', 'xlt_save_comment_lang' );

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

add_filter( 'query_vars', 'xlt_query_vars_lang' );

/**
 * Template redirect for en.
 */
function xlt_template_redirect() {
	global $wp_query;

	if ( ! isset( $wp_query->query_vars['en'] ) ) {
		return;
	}

	$template = '/index.php';

	$url = get_abs_url();
	$url = str_replace( get_home_url().'/en/', '', $url );

	$page = explode( "/", $url );

	if ( isset( $page[0], $page[1] ) && 'page' === $page[0] ) {
		set_query_var( 'page', (int) $page[1] );
		set_query_var( 'paged', (int) $page[1] );
	}

	$feed = get_feed_link();
	$feed_en = str_replace( '/feed/', '/en/feed/', $feed );
	echo $feed_en;

	if($url === $feed_en ) {
		$template = ABSPATH . WPINC . '/feed-rss2.php';
	}

	if ( is_single() ) {
		$template = '/single.php';
	}

	if ( is_page() && ! is_paged() ) {
		$template = '/page.php';
	}

	if ( is_page_template( 'page-friends.php' ) ) {
		$template = '/page-friends.php';
	}

	if ( is_page_template( 'page-links.php' ) ) {
		$template = '/page-links.php';
	}

	if ( is_page_template( 'page-makeup.php' ) ) {
		$template = '/page-makeup.php';
	}

	if ( is_page_template( 'page-newsletter.php' ) ) {
		$template = '/page-newsletter.php';
	}

	if ( is_page_template( 'page-referral.php' ) ) {
		$template = '/page-referral.php';
	}

	if ( is_archive() ) {
		$template = '/archive.php';
	}

	if ( is_front_page() ) {
		$template = '/home.php';
	}

	set_query_var( 'template', $template );

	include get_template_directory() . $template;
	exit;
}

add_action( 'template_redirect', 'xlt_template_redirect' );

/**
 * Add rewrite endpoint.
 */
function xlt_rewrite_tags_lang() {

	add_rewrite_endpoint( 'en', EP_ALL, 'en' );

}

add_action( 'init', 'xlt_rewrite_tags_lang' );

/**
 * Controls the number of search results.
 *
 * @param $query
 */
function xlt_home_posts_per_page( $query ) {

	if ( ! is_admin() && $query->is_main_query() && is_front_page() ) {
		set_query_var( 'posts_per_page', 5 );
	}
}

add_action( 'pre_get_posts', 'xlt_home_posts_per_page' );

/**
 * Set up an excerpt from $content.
 *
 * @param $content
 * @param int $length
 *
 * @return string
 */
function xlt_get_excerpt( $content, $length = false ) {

	if ( '' !== $content ) {
		$length  = ( ! $length ) ? 50 : $length;
		$content = strip_shortcodes( $content );
		$content = excerpt_remove_blocks( $content );
		$content = apply_filters( 'the_content', $content );
		$content = str_replace( ']]>', ']]&gt;', $content );
		$content = wp_trim_words( $content, $length, '...' );
	}

	return $content;
}

/**
 * Filters a taxonomy term object.
 *
 * @param WP_Term $term Term object.
 * @param string $taxonomy The taxonomy slug.
 *
 * @return WP_Term
 */
function filter_term_name( $term, $taxonomy ) {

	if ( is_admin() ) {
		return $term;
	}

	$lang = get_lang();

	if ( 'en' === $lang ) {

		$meta_value = get_term_meta( $term->term_id, 'category_en', true );

		if ( $meta_value ) {
			$term->name = $meta_value;
		}
	}

	return $term;
}

add_filter( 'get_term', 'filter_term_name', 10, 2 );

/**
 * Filters the term link.
 *
 * @param string $termlink Term link URL.
 * @param WP_Term $term Term object.
 * @param string $taxonomy Taxonomy slug.
 *
 * @return string
 */
function term_link_filter( $termlink, $term, $taxonomy ) {

	if ( null === $term ) {
		return $termlink;
	}

	if ( is_admin() ) {
		return $termlink;
	}

	if ( 'en' === get_lang() ) {
		$termlink = str_replace( '/cat/', '/cat/en/', $termlink );
	}

	return $termlink;

}

add_filter( 'term_link', 'term_link_filter', 10, 3 );

/**
 * Filters the retrieved list of pages.
 *
 * @param array $pages Array of page objects.
 * @param array $args Array of get_pages() arguments.
 *
 * @return array
 */
function xlt_set_title_en_pages( $pages, $args ) {

	if ( ! is_admin() && 'en' === get_lang() ) {
		foreach ( $pages as $page ) {
			$page->post_title = get_title_en( $page->ID );
		}
	}

	return $pages;
}

add_filter( 'get_pages', 'xlt_set_title_en_pages', 10, 2 );

/**
 * Filters the permalink for a page.
 *
 * @param string $link The page's permalink.
 * @param int $post_id The ID of the page.
 * @param bool $sample Is it a sample permalink.
 *
 * @return string
 */
function xlt_set_url_en_pages( $link, $post_id, $sample ) {

	if ( empty( $post_id ) ) {
		return $link;
	}

	if ( is_admin() ) {
		return $link;
	}

	if ( 'en' === get_lang() ) {
		return $link . 'en/';
	}

	return $link;
}

add_filter( 'page_link', 'xlt_set_url_en_pages', 10, 3 );