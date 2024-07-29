<?php
/**
 * AVIF support.
 *
 * @package  xlthlx
 */

/**
 * Output AVIFs for uploaded JPEGs.
 *
 * @param array $formats Images formats.
 *
 * @return array
 */
function xlt_filter_image_editor_output_format( $formats ) {
	$formats['image/jpeg'] = 'image/avif';
	return $formats;
}

add_filter( 'image_editor_output_format', 'xlt_filter_image_editor_output_format' );

/**
 * Allow AVIF.
 *
 * @param array $mime_types Allowed mime types.
 *
 * @return array
 */
function xlt_filter_allowed_mimes_for_avif( $mime_types ) {
	$mime_types['avif'] = 'image/avif';
	return $mime_types;
}

add_filter( 'upload_mimes', 'xlt_filter_allowed_mimes_for_avif', 1000 );

/**
 * Manage AVIF metadata.
 *
 * @param array  $metadata An array of attachment meta data.
 * @param int    $attachment_id Current attachment ID.
 * @param string $context Additional context.
 *
 * @return array
 */
function xlt_fix_avif_images( $metadata, $attachment_id, $context ) {
	if ( empty( $metadata ) ) {
		return $metadata;
	}

	$attachment_post = get_post( $attachment_id );
	if ( ! $attachment_post || is_wp_error( $attachment_post ) ) {
		return $metadata;
	}

	if ( 'image/avif' !== $attachment_post->post_mime_type ) {
		return $metadata;
	}

	if ( ( ! empty( $metadata['width'] ) && ( 0 !== $metadata['width'] ) ) && ( ! empty( $metadata['height'] ) && 0 !== $metadata['height'] ) ) {
		return $metadata;
	}

	$file = get_attached_file( $attachment_id );
	if ( ! $file ) {
		return $metadata;
	}

	if ( empty( $metadata['width'] ) ) {
		$metadata['width'] = 0;
	}

	if ( empty( $metadata['height'] ) ) {
		$metadata['height'] = 0;
	}

	if ( empty( $metadata['file'] ) ) {
		$metadata['file'] = _wp_relative_upload_path( $file );
	}

	if ( empty( $metadata['sizes'] ) ) {
		$metadata['sizes'] = array();
	}

	try {
		$imagick  = new Imagick( $file );
		$img_dim = $imagick->getImageGeometry();
		$imagick->clear();
		$metadata['width']  = $img_dim['width'];
		$metadata['height'] = $img_dim['height'];
	} catch ( Exception $e ) {
		error_log( $e->getMessage() );
	}

	return $metadata;

}

add_filter( 'wp_generate_attachment_metadata', 'xlt_fix_avif_images', 1, 3 );

/**
 * Set AVIF extension.
 *
 * @param array $mime_to_exsts Mime and extensions.
 *
 * @return array
 */
function xlt_filter_mime_to_exts( $mime_to_exsts ) {
	$mime_to_exsts['image/avif'] = 'avif';
	return $mime_to_exsts;
}

add_filter( 'getimagesize_mimes_to_exts', 'xlt_filter_mime_to_exts', 1000 );

/**
 * Filters mime types.
 *
 * @param array $mimes Mime types.
 *
 * @return array
 */
function xlt_filter_mime_types( $mimes ) {
	$mimes['avif'] = 'image/avif';
	return $mimes;
}

add_filter( 'mime_types', 'xlt_filter_mime_types', 1000 );

/**
 * Fix display of AVIF.
 *
 * @param bool   $result Is file displayable.
 * @param string $path File path.
 *
 * @return true
 */
function xlt_fix_avif_displayable( $result, $path ) {
	if ( str_ends_with( $path, '.avif' ) ) {
		return true;
	}

	return $result;
}

add_filter( 'file_is_displayable_image', 'xlt_fix_avif_displayable', 1000, 2 );

