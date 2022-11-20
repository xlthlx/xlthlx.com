<?php
/**
 * Frontend functions for English translation.
 *
 * @package  xlthlx
 */

use Highlight\Highlighter;
use DeepL\DeepLException;
use DeepL\Translator;

/**
 * Gets absolute url.
 *
 * @return string
 */
function get_abs_url() {
	if ( isset( $_SERVER['HTTP_HOST'] ) && ! is_admin() ) {
		return ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http' ) . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	}

	return false;
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
	$authKey       = 'c8fbc4ef-5992-9e4b-09c9-7adc92be34fe:fx';

	try {
		$translator = new Translator( $authKey );
	} catch ( DeepLException $e ) {
		$trans_content = $e->getMessage();
	}

	if ( isset( $translator ) ) {
		try {
			$options       = array(
				'preserve_formatting' => true,
				'tag_handling'        => 'html',
			);
			$trans_content = $translator->translateText( $element, 'it', 'en-GB', $options );
		} catch ( DeepLException $e ) {
			$trans_content = $e->getMessage();
		}
	}

	return $trans_content->text;
}

/**
 * Translate the month of the date.
 *
 * @return string
 */
function get_date_en() {

	$datetime = get_the_time( 'm' ) . '/01/' . get_the_time( 'Y' );

	return get_the_time( 'd' ) . ' ' . date( 'F', strtotime( $datetime ) ) . ' ' . get_the_time( 'Y' );
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
		$post_id = get_query_var( 'p' );
	}

	$post_type = get_post_type( $post_id );

	if ( 'post' === $post_type || 'page' === $post_type ) {
		if ( ! get_post_meta( $post_id, 'title_en', true )
			 || get_post_meta( $post_id, 'title_en', true ) === '' ) {

			$post  = get_post( $post_id );
			$title = get_trans( $post->post_title );
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
		$post_id = get_query_var( 'p' );
	}

	$post_type = get_post_type( $post_id );

	if ( 'post' === $post_type || 'page' === $post_type ) {

		if ( ! get_post_meta( $post_id, 'content_en', true ) || get_post_meta( $post_id, 'content_en', true ) === '' ) {

			global $post;
			$blocks = parse_blocks( $post->post_content );
			$output = '';

			foreach ( $blocks as $block ) {

				$block_types = array(
					'core/code',
					'core/freeform',
					'core/heading',
					'core/html',
					'core/list',
					'core/list-item',
					'core/paragraph',
					'core/pullquote',
					'core/quote',
					'core/shortcode',
					'core/table',
				);

				if ( isset( $block['blockName'] ) && $block['blockName'] !== '' && in_array(
					$block['blockName'],
					$block_types,
					true
				) ) {

					$name = $block['blockName'];

					switch ( $name ) {
						case 'core/code':
							$block['innerHTML']       = xlt_trans_code( $block['innerHTML'] );
							$block['innerContent'][0] = $block['innerHTML'];
							break;
						case 'core/quote':
							$block = xlt_trans_quote( $block );
							break;
						case 'core/list':
							$block['innerHTML'] = xlt_trans_list( $block );
							break;
						default:
							$block['innerHTML']       = get_trans( $block['innerHTML'] );
							$block['innerContent'][0] = $block['innerHTML'];
							break;
					}

					$output .= apply_filters( 'the_content', render_block( $block ) );

				} else {
					$output .= render_block( $block );
				}
			}

			$output .= '<!-- GT -->';
			update_post_meta( $post_id, 'content_en', $output );
		}

		return apply_filters( 'the_content', get_post_meta( $post_id, 'content_en', true ) );
	}
}

function xlt_trans_code( $code ) {

	if ( '' === $code ) {
		$hl = new Highlighter();
		$hl->setAutodetectLanguages(
			array(
				'php',
				'javascript',
				'html',
			)
		);

		$code = str_replace(
			array(
				'<pre class="wp-block-code">',
				'<code>',
				'</code>',
				'</pre>',
			),
			'',
			html_entity_decode( $code )
		);

		$highlighted = $hl->highlightAuto( $code );

		$code            = '<pre class="wp-block-code"><code class="hljs ' . $highlighted->language . '">' . $highlighted->value . '</code></pre>';
		$code->outertext = apply_filters( 'the_content', $code );

	}

	return $code;
}

/**
 * @param $block
 *
 * @return array
 */
function xlt_trans_quote( $block ) {

	if ( isset( $block['innerBlocks'] ) ) {
		$i = 0;
		foreach ( $block['innerBlocks'] as $inner ) {

			if ( $inner['blockName'] === 'core/paragraph' ) {
				$block['innerBlocks'][ $i ]['innerHTML']       = get_trans( $inner['innerHTML'] );
				$block['innerBlocks'][ $i ]['innerContent'][0] = $block['innerBlocks'][ $i ]['innerHTML'];
			}

			$y = 0;
			if ( $inner['blockName'] === 'core/list' ) {
				foreach ( $inner['innerBlocks'] as $sub_inner ) {
					$block['innerBlocks'][ $i ]['innerBlocks'][ $y ]['innerHTML']       = get_trans( $sub_inner['innerHTML'] );
					$block['innerBlocks'][ $i ]['innerBlocks'][ $y ]['innerContent'][0] = $block['innerBlocks'][ $i ]['innerBlocks'][ $y ]['innerHTML'];
					$y ++;
				}
			}
			$i ++;

		}
	} else {
		$block['innerHTML']      .= get_trans( $block['innerHTML'] );
		$block['innerContent'][0] = $block['innerHTML'];
	}

	return $block;
}

/**
 * @param $block
 *
 * @return array
 */
function xlt_trans_list( $block ) {
	if ( isset( $block['innerBlocks'] ) ) {
		$y = 0;
		foreach ( $block['innerBlocks'] as $inner ) {
			$block['innerBlocks'][ $y ]['innerHTML']       = get_trans( $inner['innerHTML'] );
			$block['innerBlocks'][ $y ]['innerContent'][0] = $block['innerBlocks'][ $y ]['innerHTML'];
			$y ++;
		}
	}

	return $block;
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
