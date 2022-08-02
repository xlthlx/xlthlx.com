<?php
/**
 * Manage WebP conversion.
 */

use WebPConvert\Convert\Exceptions\ConversionFailedException;
use WebPConvert\WebPConvert;

/**
 * Get the mime type for an image.
 *
 * @param $filename
 *
 * @return string
 */
function xlt_get_mime_type( $filename ) {

	if ( function_exists( 'wp_get_image_mime' ) ) {

		$mimeType = wp_get_image_mime( $filename );
		if ( $mimeType !== false ) {
			return $mimeType;
		}
	}

	return 'unknown';
}

/**
 * Check if the mime type is permitted.
 *
 * @param $filename
 *
 * @return void
 * @throws ConversionFailedException
 */
function xlt_check_mime_type( $filename ) {
	$allowedMimeTypes   = [];
	$allowedMimeTypes[] = 'image/jpeg';
	$allowedMimeTypes[] = 'image/jpg';
	$allowedMimeTypes[] = 'image/png';

	if ( ! in_array( xlt_get_mime_type( $filename ),$allowedMimeTypes ) ) {
		return;
	}

	xlt_convert_to_webp( $filename );
}

/**
 * Convert to WebP.
 *
 * @param $source
 *
 * @return void
 * @throws ConversionFailedException
 */
function xlt_convert_to_webp( $source ) {
	$destination = preg_replace( '/(?:jpg|png|jpeg)$/i','webp',$source );

	WebPConvert::convert( $source,$destination,[
		'fail'        => 'original',
		'show-report' => false
	] );
}

/**
 * Convert to WebP the other sizes.
 *
 * @param $filename
 *
 * @return string
 * @throws ConversionFailedException
 */
function xlt_convert_other_sizes( $filename ) {

	if ( ! is_null( $filename ) ) {
		xlt_check_mime_type( $filename );
	}

	return $filename;
}

/**
 * Convert the main file on upload.
 *
 * @param $file_array
 * @param $context
 *
 * @return array
 * @throws ConversionFailedException
 */
function xlt_convert_on_upload( $file_array,$context ) {

	if ( isset( $file_array['file'] ) ) {
		xlt_check_mime_type( $file_array['file'] );
	}

	return $file_array;
}

function xlt_delete_webp( $filename ) {
	$allowedMimeTypes   = [];
	$allowedMimeTypes[] = 'image/jpeg';
	$allowedMimeTypes[] = 'image/jpg';
	$allowedMimeTypes[] = 'image/png';

	if ( ! in_array( xlt_get_mime_type( $filename ),$allowedMimeTypes ) ) {
		return $filename;
	}


	$destination = preg_replace( '/(?:jpg|png|jpeg)$/i','webp',$filename );
	if ( @file_exists( $destination ) ) {
		if ( @unlink( $destination ) ) {
			return $filename;
		} else {
			error_log( 'WebP Express failed deleting webp:' . $destination );
		}
	}

	return $filename;
}

add_filter( 'wp_handle_upload','xlt_convert_on_upload',10,2 );
add_filter( 'image_make_intermediate_size','xlt_convert_other_sizes',10,1 );
add_filter( 'wp_delete_file','xlt_delete_webp',10,1 );
