<?php
/**
 * Frontend functions for English translation.
 *
 * @package  xlthlx
 */

use Highlight\Highlighter;
use simplehtmldom\HtmlDocument;

/**
 * Gets absolute url.
 *
 * @return string
 */
function get_abs_url() {
	if ( isset( $_SERVER['HTTP_HOST'] ) && ! is_admin() ) {
		return ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ? "https" : "http" ) . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	}
}

/**
 * Translate a piece of string.
 *
 * @param $element
 *
 * @return array|string
 */
function get_trans( $element ) {
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

	if ( is_preview() ) {
		$post_id = get_query_var('p');
	}

	$post_type = get_post_type( $post_id );

	if ( 'post' === $post_type ) {
		if ( ! is_home() || ! is_archive() ) {
			if ( ! get_post_meta( $post_id, 'date_en',
					true ) || get_post_meta( $post_id, 'date_en',
					true ) === '' ) {
				$month = get_trans( get_the_time( 'F', $post_id ) );
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

		if ( is_preview() ) {
			$post_id = get_query_var('p');
		}

		$post_type = get_post_type( $post_id );

		if ( 'post' === $post_type || 'page' === $post_type ) {
			if ( ! get_post_meta( $post_id, 'title_en', true )
			     || get_post_meta( $post_id, 'title_en', true ) === '' ) {

				$title = get_trans( get_the_title( $post_id ) );
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

	if ( is_preview() ) {
		$post_id = get_query_var('p');
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
											$trans_tag     = get_trans( $pt->innertext );
											$pt->innertext = $trans_tag;
											$to_remove[]   = $pt->outertext;
										}
									}
								}

								$plain_a = $pg->find( "a" );

								if ( $plain_a ) {
									foreach ( $plain_a as $pa ) {
										$trans_a       = get_trans( $pa->innertext );
										$pa->innertext = $trans_a;
										if ( $pa->title ) {
											$title_a   = get_trans( $pa->title );
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

								$trans_p = get_trans( $plain_p );

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

	$link     = get_abs_url();
	$pos      = strpos( $link, '/en/' );
	$pos_page = strpos( $link, '/page/' );

	if ( is_front_page() ) {
		if ( $pos === false ) {
			if ( $pos_page === false ) {
				$link .= 'en/';
			} else {
				$link = str_replace( '/page/', '/en/page/', $link );
			}

		} else {
			$link = str_replace( 'en/', '', $link );
		}

		return $link;
	}

	if ( is_category() ) {
		if ( $pos === false ) {
			$link = str_replace( '/cat/', '/cat/en/', $link );
		} else {
			$link = str_replace( 'en/', '', $link );
		}

		return $link;
	}

	if ( is_search() ) {
		if ( $pos === false ) {
			if ( $pos_page === false ) {
				$link .= 'en/';
			} else {
				$link = str_replace( '/page/', '/en/page/', $link );
			}

		} else {
			$link = str_replace( 'en/', '', $link );
		}

		return $link;
	}

	if ( $pos === false ) {
		$link .= 'en/';
	} else {
		$link = str_replace( 'en/', '', $link );
	}

	if ( is_preview() ) {
		if ( $pos === false ) {
			$link = get_home_url() . '/en/?p=' . get_query_var( 'p' ) . '&preview=true';
		} else {
			$link = str_replace( '/en/', '/?p=' . get_query_var( 'p' ) . '&preview=true', $link );
		}
	}

	return $link;
}
