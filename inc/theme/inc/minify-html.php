<?php
/**
 * Minify HTML.
 *
 * @package  WordPress
 * @subpackage  Xlthlx
 */

function xlt_init_minify_html() {
	ob_start( 'xlt_minify_html_output' );
}

if ( ! ( defined( 'WP_CLI' ) && WP_CLI ) && ! is_admin() && ! is_user_logged_in() ) {
	add_action( 'init', 'xlt_init_minify_html', 1 );
}

function xlt_minify_html_output( $buffer ) {
	if ( 0 === strpos( ltrim( $buffer ), '<?xml' ) ) {
		return ( $buffer );
	}

	$mod = '/u';

	$buffer = str_replace( array( chr( 13 ) . chr( 10 ), chr( 9 ) ),
		array( chr( 10 ), '' ), $buffer );
	$buffer = str_ireplace( array(
		'<script',
		'/script>',
		'<pre',
		'/pre>',
		'<textarea',
		'/textarea>',
		'<style',
		'/style>'
	), array(
		'M1N1FY-ST4RT<script',
		'/script>M1N1FY-3ND',
		'M1N1FY-ST4RT<pre',
		'/pre>M1N1FY-3ND',
		'M1N1FY-ST4RT<textarea',
		'/textarea>M1N1FY-3ND',
		'M1N1FY-ST4RT<style',
		'/style>M1N1FY-3ND'
	), $buffer );
	$split  = explode( 'M1N1FY-3ND', $buffer );
	$buffer = '';
	foreach ( $split as $iValue ) {
		$ii = strpos( $iValue, 'M1N1FY-ST4RT' );
		if ( $ii !== false ) {
			$process = substr( $iValue, 0, $ii );
			$asis    = substr( $iValue, $ii + 12 );
			if ( 0 === strpos( $asis, '<script' ) ) {
				$split2 = explode( chr( 10 ), $asis );
				$asis   = '';
				foreach ( $split2 as $iiiValue ) {
					if ( $iiiValue ) {
						$asis .= trim( $iiiValue ) . chr( 10 );
					}
					if ( strpos( $iiiValue,
							'//' ) !== false && substr( trim( $iiiValue ),
							- 1 ) === ';' ) {
						$asis .= chr( 10 );
					}
				}
				if ( $asis ) {
					$asis = substr( $asis, 0, - 1 );
				}
				$asis = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '',
					$asis );

				$asis = str_replace( array(
					';' . chr( 10 ),
					'>' . chr( 10 ),
					'{' . chr( 10 ),
					'}' . chr( 10 ),
					',' . chr( 10 )
				), array( ';', '>', '{', '}', ',' ), $asis );

			} elseif ( 0 === strpos( $asis, '<style' ) ) {
				$asis = preg_replace( array(
					'/\>[^\S ]+' . $mod,
					'/[^\S ]+\<' . $mod,
					'/(\s)+' . $mod
				), array( '>', '<', '\\1' ), $asis );

				$asis = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '',
					$asis );

				$asis = str_replace( array(
					chr( 10 ),
					' {',
					'{ ',
					' }',
					'} ',
					'( ',
					' )',
					' :',
					': ',
					' ;',
					'; ',
					' ,',
					', ',
					';}'
				), array(
					'',
					'{',
					'{',
					'}',
					'}',
					'(',
					')',
					':',
					':',
					';',
					';',
					',',
					',',
					'}'
				), $asis );
			}
		} else {
			$process = $iValue;
			$asis    = '';
		}
		$process = preg_replace( array(
			'/\>[^\S ]+' . $mod,
			'/[^\S ]+\<' . $mod,
			'/(\s)+' . $mod
		), array( '>', '<', '\\1' ), $process );

		$process = preg_replace( '/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->' . $mod,
			'', $process );

		$buffer .= $process . $asis;
	}
	$buffer = str_replace( array(
		chr( 10 ) . '<script',
		chr( 10 ) . '<style',
		'*/' . chr( 10 ),
		'M1N1FY-ST4RT'
	), array( '<script', '<style', '*/', '' ), $buffer );

	if ( 0 === stripos( ltrim( $buffer ),
			'<!doctype html>' ) ) {
		$buffer = str_replace( ' />', '>', $buffer );
	}

	$buffer = str_replace( array(
		'https://' . $_SERVER['HTTP_HOST'] . '/',
		'http://' . $_SERVER['HTTP_HOST'] . '/',
		'//' . $_SERVER['HTTP_HOST'] . '/'
	), array( '/', '/', '/' ), $buffer );

	return ( $buffer );
}
