<?php
/**
 * Toolkit.
 *
 * @package  xlthlx
 */

/**
 * Includes all files from inc directory.
 */
require_once ABSPATH . 'wp-admin/includes/file.php';

$folder = get_template_directory() . '/inc/toolkit/inc/';
$files  = list_files( $folder, 2 );
foreach ( $files as $file ) {
	if ( is_file( $file ) ) {
		require_once $file;
	}
}
