<?php
/**
 * Toolkit.
 *
 * @package  xlthlx
 */

require_once get_home_path() . WPINC . '/file.php';

$folder = get_template_directory() . '/inc/toolkit/inc/';
$files  = list_files( $folder,2 );
foreach ( $files as $file ) {
	if ( is_file( $file ) ) {
		require_once $file;
	}
}
