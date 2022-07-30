<?php
/**
 * Toolkit.
 *
 * @package  xlthlx
 */

$folder = __DIR__ . '/inc/';
$files  = list_files( $folder,2 );
foreach ( $files as $file ) {
	if ( is_file( $file ) ) {
		require_once $file;
	}
}
