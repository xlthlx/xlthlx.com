<?php
/**
 * Manage WebP conversion.
 *
 * @package  xlthlx
 */

// @codingStandardsIgnoreStart
use WebPConvert\WebPConvert;
use WebPConvert\Convert\Exceptions\ConversionFailedException;
// @codingStandardsIgnoreEnd

/**
 * Get the mime type for an image.
 *
 * @param string $filename File name.
 *
 * @return string
 */
function xlt_get_mime_type( $filename ) {

	if ( function_exists( 'wp_get_image_mime' ) ) {

		$mime_type = wp_get_image_mime( $filename );
		if ( false !== $mime_type ) {
			return $mime_type;
		}
	}

	return 'unknown';
}

/**
 * Check if the mime type is permitted.
 *
 * @param string $filename File name.
 *
 * @return void
 * @throws ConversionFailedException Exception.
 */
function xlt_check_mime_type( $filename ) {
	$allowed_mime_types   = array();
	$allowed_mime_types[] = 'image/jpeg';
	$allowed_mime_types[] = 'image/jpg';
	$allowed_mime_types[] = 'image/png';

	if ( ! in_array( xlt_get_mime_type( $filename ), $allowed_mime_types, true ) ) {
		return;
	}

	xlt_convert_to_webp( $filename );
}

/**
 * Convert to WebP.
 *
 * @param string $source Source file.
 *
 * @return void
 * @throws ConversionFailedException Exception.
 */
function xlt_convert_to_webp( $source ) {
	$destination = preg_replace( '/(?:jpg|png|jpeg)$/i', 'webp', $source );

	WebPConvert::convert(
		$source,
		$destination,
		array(
			'fail'        => 'original',
			'show-report' => false,
		)
	);
}

/**
 * Convert to WebP the other sizes.
 *
 * @param string $filename File name.
 *
 * @return string
 * @throws ConversionFailedException Exception.
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
 * @param array  $upload Array of upload data.
 * @param string $context The type of upload action. Values include 'upload' or 'sideload'.
 *
 * @return array
 * @throws ConversionFailedException Exception.
 */
function xlt_convert_on_upload( $upload, $context ) {

	if ( isset( $upload['file'] ) ) {
		xlt_check_mime_type( $upload['file'] );
	}

	return $upload;
}

/**
 * Delete the webp on delete media file.
 *
 * @param string $file Path to the file to delete.
 *
 * @return string
 */
function xlt_delete_webp( $file ) {
	$allowed_mime_types   = array();
	$allowed_mime_types[] = 'image/jpeg';
	$allowed_mime_types[] = 'image/jpg';
	$allowed_mime_types[] = 'image/png';

	if ( ! in_array( xlt_get_mime_type( $file ), $allowed_mime_types, true ) ) {
		return $file;
	}


	$destination = preg_replace( '/(?:jpg|png|jpeg)$/i', 'webp', $file );
	if ( file_exists( $destination ) ) {
		if ( unlink( $destination ) ) {
			return $file;
		}

		error_log( 'WebP Express failed deleting webp:' . $destination );
	}

	return $file;
}

add_filter( 'wp_handle_upload', 'xlt_convert_on_upload', 10, 2 );
add_filter( 'image_make_intermediate_size', 'xlt_convert_other_sizes', 10, 1 );
add_filter( 'wp_delete_file', 'xlt_delete_webp', 10, 1 );
