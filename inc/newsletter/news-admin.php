<?php
/**
 * Functions to manage the newsletter.
 *
 * @package  WordPress
 * @subpackage  Xlthlx
 */

/**
 * Additional columns.
 *
 * @param $columns
 *
 * @return mixed
 */
function xlt_flamingo_contact_columns( $columns ) {
	$columns['code']   = "Codice";
	$columns['lang']   = "Lingua";
	$columns['active'] = "Conferma";

	unset( $columns['subscribe-reloaded'] );

	return $columns;
}

add_action( 'manage_flamingo_contact_posts_columns', 'xlt_flamingo_contact_columns' );

/**
 * Set values for additional columns.
 *
 * @param $column_name
 * @param $post_id
 */
function xlt_print_flamingo_contact_columns( $column_name, $post_id ) {

	if ( $column_name === 'code' ) {
		echo get_post_meta( $post_id, '_code', true );
	}

	if ( $column_name === 'lang' ) {
		$_lang = get_post_meta( $post_id, '_lang', true );
		echo ( $_lang === 'en' ) ? 'English' : 'Italiano';
	}

	if ( $column_name === 'active' ) {
		echo ucfirst( get_post_meta( $post_id, '_active', true ) );
	}
}

add_action( 'manage_flamingo_contact_posts_custom_column', 'xlt_print_flamingo_contact_columns', 10, 2 );

/**
 * @param $args
 * @param $post_type
 *
 * @return mixed
 */
function xlt_change_post_type_args( $args, $post_type ) {

	if ( $post_type === 'flamingo_contact' ) {
		$args['query_var']               = true;
		$args['show_ui']                 = true;
		$args['labels']['name']          = 'Rubrica';
		$args['labels']['singular_name'] = 'Contatto';
		$args['exclude_from_search']     = true;
		$args['publicly_queryable']      = false;
		$args['menu_position']           = 27;
		$args['menu_icon']               = 'dashicons-phone';
		$args['supports']                = [ 'title', 'editor', 'revisions' ];
	}

	return $args;
}

add_filter( 'register_post_type_args', 'xlt_change_post_type_args', 10, 2 );

/**
 * @param $args
 * @param $taxonomy
 *
 * @return mixed
 */
function xlt_change_taxonomy_args( $args, $taxonomy ) {

	if ( $taxonomy === 'flamingo_contact_tag' ) {
		$args['query_var']               = true;
		$args['show_ui']                 = true;
		$args['labels']['name']          = 'Canali';
		$args['labels']['singular_name'] = 'Canale';
		$args['exclude_from_search']     = true;
		$args['publicly_queryable']      = false;
		$args['hierarchical']            = true;
		$args['show_admin_column']       = true;
	}

	return $args;
}

add_filter( 'register_taxonomy_args', 'xlt_change_taxonomy_args', 10, 2 );

function xlt_change_admin() {
	remove_submenu_page( 'flamingo', 'flamingo_inbound' );
	remove_submenu_page( 'flamingo', 'flamingo' );
	remove_menu_page( 'flamingo' );

	add_menu_page(
		'Messaggi in arrivo',
		'Messaggi',
		'flamingo_edit_inbound_messages',
		'flamingo',
		'flamingo_inbound_admin_page',
		'dashicons-email-alt',
		28
	);

	$inbound_admin = add_submenu_page(
		'flamingo',
		'Messaggi in arrivo',
		'Messaggi in arrivo',
		'flamingo_edit_inbound_messages',
		'flamingo_inbound',
		'flamingo_inbound_admin_page'
	);

	add_action(
		'load-' . $inbound_admin,
		'flamingo_load_inbound_admin',
		10, 0
	);

	global $menu;
	$menu[30][0] = 'Form';
	$menu[30][6] = 'dashicons-forms';

}

add_action( 'admin_menu', 'xlt_change_admin' );

/**
 * Adds the English fields.
 */
function xlt_add_flamingo_metabox() {

	$cmb = new_cmb2_box( array(
		'id'           => 'group_contacts',
		'title'        => __( 'Contatti', 'xlthlx' ),
		'object_types' => array( 'flamingo_contact' ),
		'context'      => 'normal',
		'priority'     => 'high',
	) );

	$cmb->add_field( array(
		'name'    => __( 'Nome', 'xlthlx' ),
		'id'      => '_name',
		'type'    => 'text_medium',
		'classes'      => ['half-width'],
	) );

	$cmb->add_field( array(
		'name'    => __( 'Email', 'xlthlx' ),
		'id'      => '_email',
		'type'    => 'text_email',
		'classes'      => ['half-width'],
	) );

	$cmb->add_field( array(
		'name'             => __( 'Conferma', 'xlthlx' ),
		'id'               => '_active',
		'type'             => 'select',
		'show_option_none' => false,
		'default'          => 'no',
		'options'          => array(
			'no' => __( 'No', 'xlthlx' ),
			'si' => __( 'Si', 'xlthlx' ),
		),
		'classes'      => ['half-width'],
	) );

	$cmb->add_field( array(
		'name'             => __( 'Lingua', 'xlthlx' ),
		'id'               => '_lang',
		'type'             => 'select',
		'show_option_none' => false,
		'default'          => 'it',
		'options'          => array(
			'it' => __( 'Italiano', 'xlthlx' ),
			'en' => __( 'English', 'xlthlx' ),
		),
		'classes'      => ['half-width'],
	) );

	$cmb->add_field( array(
		'name'       => __( 'Codice', 'xlthlx' ),
		'id'         => '_code',
		'type'       => 'text_medium',
/*		'attributes' => array(
			'readonly' => 'readonly',
		),*/
		'classes'    => 'half-width',
	) );

	$cmb->add_field( array(
		'name'       => __( 'Ultima modifica', 'xlthlx' ),
		'id'         => '_last_contacted',
		'type'       => 'text_medium',
		'attributes' => array(
			'readonly' => 'readonly',
		),
		'classes'      => ['half-width'],
	) );

}

add_action( 'cmb2_init', 'xlt_add_flamingo_metabox' );
