<?php
/**
 * Functions to manage the newsletter.
 *
 * E.g. https://xlthlx.com/newsletter/en/?act=confirm&cod=Kr%QxyX)F172(4P7VFWPIeGl$b
 *
 * @package  xlthlx
 */

/**
 * Includes all files from inc directory.
 */
require_once ABSPATH . 'wp-admin/includes/file.php';

$folder = get_template_directory() . '/inc/newsletter/inc/';
$files  = list_files( $folder, 1 );
foreach ( $files as $file ) {
	if ( is_file( $file ) ) {
		require_once $file;
	}
}
