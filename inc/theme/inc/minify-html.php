<?php
/**
 * Minify HTML.
 *
 * @package  xlthlx
 */

function xlt_init_minify_html() {
	ob_start( 'xlt_minify_html_output' );
}

if ( ! ( wp_doing_cron() ) && ! ( defined( 'WP_CLI' ) && WP_CLI ) && ! is_admin() && ! is_user_logged_in() ) {
	add_action( 'init','xlt_init_minify_html',1 );
}

function xlt_minify_html_output( $buffer ) {
	if ( 0 === strpos( ltrim( $buffer ),'<?xml' ) ) {
		return ( $buffer );
	}

	$mod = '/u';

	$buffer = str_replace( [ chr( 13 ),chr( 9 ) ],
		[ chr( 10 ),'' ],$buffer );
	$buffer = str_ireplace( [
		'<script',
		'/script>',
		'<pre',
		'/pre>',
		'<textarea',
		'/textarea>',
		'<style',
		'/style>'
	],[
		'M1N1FY-ST4RT<script',
		'/script>M1N1FY-3ND',
		'M1N1FY-ST4RT<pre',
		'/pre>M1N1FY-3ND',
		'M1N1FY-ST4RT<textarea',
		'/textarea>M1N1FY-3ND',
		'M1N1FY-ST4RT<style',
		'/style>M1N1FY-3ND'
	],$buffer );
	$split  = explode( 'M1N1FY-3ND',$buffer );
	$buffer = '';
	foreach ( $split as $iValue ) {
		$ii = strpos( $iValue,'M1N1FY-ST4RT' );
		if ( $ii !== false ) {
			$process = substr( $iValue,0,$ii );
			$asis    = substr( $iValue,$ii + 12 );
			if ( 0 === strpos( $asis,'<script' ) ) {
				$split2 = explode( chr( 10 ),$asis );
				$asis   = '';
				foreach ( $split2 as $iiiValue ) {
					if ( $iiiValue ) {
						$asis .= trim( $iiiValue );
					}
					if ( strpos( $iiiValue,
							'//' ) !== false && substr( trim( $iiiValue ),
							- 1 ) === ';' ) {
						$asis .= chr( 10 );
					}
				}
				if ( $asis ) {
					$asis = substr( $asis,0,- 1 );
				}
				$asis = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!','',
					$asis );

				$asis = str_replace( [
					';' . chr( 10 ),
					'>' . chr( 10 ),
					'{' . chr( 10 ),
					'}' . chr( 10 ),
					',' . chr( 10 )
				],[ ';','>','{','}',',' ],$asis );

			} elseif ( 0 === strpos( $asis,'<style' ) ) {
				$asis = preg_replace( [
					'/\>[^\S ]+' . $mod,
					'/[^\S ]+\<' . $mod,
					'/(\s)+' . $mod
				],[ '>','<','\\1' ],$asis );

				$asis = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!','',
					$asis );

				$asis = str_replace( [
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
				],[
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
				],$asis );
			}
		} else {
			$process = $iValue;
			$asis    = '';
		}
		$process = preg_replace( [
			'/\>[^\S ]+' . $mod,
			'/[^\S ]+\<' . $mod,
			'/(\s)+' . $mod
		],[ '>','<','\\1' ],$process );

		$process = preg_replace( '/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->' . $mod,
			'',$process );

		$buffer .= $process . $asis;
	}
	$buffer = str_replace( [
		chr( 10 ) . '<script',
		chr( 10 ) . '<style',
		'*/' . chr( 10 ),
		'M1N1FY-ST4RT'
	],[ '<script','<style','*/','' ],$buffer );

	if ( 0 === stripos( ltrim( $buffer ),
			'<!doctype html>' ) ) {
		$buffer = str_replace( ' />','>',$buffer );
	}

	return ( $buffer );
}
