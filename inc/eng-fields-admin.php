<?php
/**
 * Backend functions for English translation.
 *
 * @package  WordPress
 * @subpackage  Xlthlx
 */

/**
 * Adds the English fields.
 */
function xlt_add_metabox() {
	$cmb_post = new_cmb2_box( array(
		'id'           => 'group_en',
		'title'        => 'English',
		'object_types' => array( 'post' ),
		'context'      => 'normal',
		'priority'     => 'high',
	) );

	$cmb_post->add_field( array(
		'name'         => 'Data',
		'id'           => 'date_en',
		'type'         => 'text',
		'classes'      => [ 'half-width' ],
		'show_in_rest' => WP_REST_Server::ALLMETHODS,
	) );

	$cmb_post->add_field( array(
		'name'         => 'Titolo',
		'id'           => 'title_en',
		'type'         => 'text',
		'classes'      => [ 'half-width' ],
		'show_in_rest' => WP_REST_Server::ALLMETHODS,
	) );

	$cmb_post->add_field( array(
		'name'         => '',
		'id'           => 'content_en',
		'type'         => 'wysiwyg',
		'options'      => array(
			'media_buttons' => false,
		),
		'show_in_rest' => WP_REST_Server::ALLMETHODS,
	) );

	$cmb_page = new_cmb2_box( array(
		'id'           => 'group_page_en',
		'title'        => 'English',
		'object_types' => array( 'page' ),
		'context'      => 'normal',
		'priority'     => 'high',
	) );

	$cmb_page->add_field( array(
		'name'         => '',
		'id'           => 'title_en',
		'type'         => 'text',
		'show_in_rest' => WP_REST_Server::ALLMETHODS,
	) );

	$cmb_page->add_field( array(
		'name'         => '',
		'id'           => 'content_en',
		'type'         => 'wysiwyg',
		'options'      => array(
			'media_buttons' => false,
		),
		'show_in_rest' => WP_REST_Server::ALLMETHODS,
	) );
}

add_action( 'cmb2_init', 'xlt_add_metabox' );

function xlt_add_category_metabox() {
	$cmb_category = new_cmb2_box( array(
		'id'               => 'category_group_en',
		'title'            => 'English',
		'object_types'     => array( 'term' ),
		'taxonomies'       => array( 'category' ),
		'priority'         => 'high',
		'show_in_rest'     => WP_REST_Server::ALLMETHODS,
		'mb_callback_args' => array( '__block_editor_compatible_meta_box' => true ),
	) );

	$cmb_category->add_field( array(
		'id'           => 'category_en',
		'name'         => 'Name',
		'type'         => 'text',
		'column'       => array(
			'position' => 2,
			'name'     => 'Name',
		),
		'show_in_rest' => WP_REST_Server::ALLMETHODS,
	) );
}

add_action( 'cmb2_init', 'xlt_add_category_metabox' );

/**
 * Add columns in the admin list.
 *
 * @param array $defaults
 *
 * @return array $defaults
 */
function xlt_eng_posts_columns( $defaults ) {
	$post_type = get_post_type();
	if ( ( $post_type === 'post' ) || ( $post_type === 'page' ) ) {
		if ( isset( $defaults['comments'] ) ) {
			unset( $defaults['comments'] );
		}

		$defaults['eng']    = __( 'Eng' );
	}

	return $defaults;
}

add_filter( 'manage_posts_columns', 'xlt_eng_posts_columns', 15 );
add_filter( 'manage_pages_columns', 'xlt_eng_posts_columns', 15 );

/**
 * Sets columns values.
 *
 * @param string $column_name
 * @param int $id
 */
function xlt_eng_posts_custom_columns( $column_name, $id ) {
	if ( $column_name === 'eng' ) {
		$content_en = get_post_meta( $id, 'content_en', true );
		if ( $content_en === '' ) {
			echo 'No';
		}
		if ( $content_en !== '' && strpos( $content_en,
				"<!-- GT -->" ) !== false ) {
			echo 'Check';
		}
		if ( $content_en !== '' && strpos( $content_en,
				"<!-- GT -->" ) === false ) {
			echo '';
		}
	}
}

add_action( 'manage_posts_custom_column', 'xlt_eng_posts_custom_columns', 15, 2 );
add_action( 'manage_pages_custom_column', 'xlt_eng_posts_custom_columns', 15, 2 );

/**
 * Hook in and register a metabox for the admin comment edit page.
 */
function xlt_register_comment_language() {

	$cmb = new_cmb2_box( array(
		'id'           => 'xlt_comment_metabox',
		'title'        => 'Altre opzioni',
		'object_types' => array( 'comment' ),
	) );

	$cmb->add_field( array(
		'name'             => 'Lingua del commento',
		'desc'             => '',
		'id'               => 'comment_lang',
		'type'             => 'select',
		'show_option_none' => false,
		'default'          => 'it',
		'options'          => array(
			'it' => 'Italiano',
			'en' => 'English'
		),
		'column'           => array(
			'position' => 4,
			'name'     => 'Lingua',
		),
	) );
}

add_action( 'cmb2_init', 'xlt_register_comment_language' );