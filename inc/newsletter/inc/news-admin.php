<?php
/**
 * Admin functions to manage the newsletter.
 * Requires Flamingo and Contact Form 7 plugins.
 *
 * @package  xlthlx
 */

/**
 * Additional columns.
 *
 * @param array $columns Contacts columns.
 *
 * @return array
 */
function xlt_flamingo_contact_columns( $columns ) {
	$columns['code']   = 'Codice';
	$columns['lang']   = 'Lingua';
	$columns['active'] = 'Conferma';

	unset( $columns['subscribe-reloaded'] );

	return $columns;
}

add_action( 'manage_flamingo_contact_posts_columns', 'xlt_flamingo_contact_columns' );

/**
 * Set values for additional columns.
 *
 * @param string $column_name Column name.
 * @param int    $post_id Post ID.
 */
function xlt_print_flamingo_contact_columns( $column_name, $post_id ) {

	if ( 'code' === $column_name ) {
		echo get_post_meta( $post_id, '_code', true );
	}

	if ( 'lang' === $column_name ) {
		$_lang = get_post_meta( $post_id, '_lang', true );
		echo ( 'en' === $_lang ) ? 'English' : 'Italiano';
	}

	if ( 'active' === $column_name ) {
		echo ucfirst( get_post_meta( $post_id, '_active', true ) );
	}
}

add_action( 'manage_flamingo_contact_posts_custom_column', 'xlt_print_flamingo_contact_columns', 10, 2 );

/**
 * Changes some attributes for the post type 'flamingo_contact'.
 *
 * @param array  $args Post type args.
 * @param string $post_type Post type.
 *
 * @return array
 */
function xlt_change_post_type_args( $args, $post_type ) {

	if ( 'flamingo_contact' === $post_type ) {
		$args['query_var']               = true;
		$args['show_ui']                 = true;
		$args['labels']['name']          = 'Rubrica';
		$args['labels']['singular_name'] = 'Contatto';
		$args['exclude_from_search']     = true;
		$args['publicly_queryable']      = false;
		$args['menu_position']           = 27;
		$args['menu_icon']               = 'dashicons-phone';
		$args['supports']                = array( 'title', 'editor', 'revisions' );
	}

	return $args;
}

add_filter( 'register_post_type_args', 'xlt_change_post_type_args', 10, 2 );

/**
 * Changes some attributes for the taxonomy 'flamingo_contact_tag'.
 *
 * @param array  $args Taxonomy args.
 * @param string $taxonomy Taxonomy.
 *
 * @return array
 */
function xlt_change_taxonomy_args( $args, $taxonomy ) {

	if ( 'flamingo_contact_tag' === $taxonomy ) {
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

/**
 * Changes the flamingo menu.
 *
 * @return void
 */
function xlt_change_admin() {
	remove_submenu_page( 'flamingo', 'flamingo_inbound' );
	remove_submenu_page( 'flamingo', 'flamingo' );
	remove_menu_page( 'flamingo' );

	// @codingStandardsIgnoreStart
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
		10,
		0
	);

	global $menu;
	$menu[30][0] = 'Form';
	$menu[30][6] = 'dashicons-forms';
	// @codingStandardsIgnoreEnd

}

add_action( 'admin_menu', 'xlt_change_admin' );

/**
 * Adds some fields for the post type 'flamingo_contact'.
 *
 * @return void
 */
function xlt_add_flamingo_metabox() {

	$cmb = new_cmb2_box(
		array(
			'id'           => 'group_contacts',
			'title'        => __( 'Contatti', 'xlthlx' ),
			'object_types' => array( 'flamingo_contact' ),
			'context'      => 'normal',
			'priority'     => 'high',
		)
	);

	$cmb->add_field(
		array(
			'name'    => __( 'Nome', 'xlthlx' ),
			'id'      => '_name',
			'type'    => 'text_medium',
			'classes' => array( 'half-width' ),
		)
	);

	$cmb->add_field(
		array(
			'name'    => __( 'Email', 'xlthlx' ),
			'id'      => '_email',
			'type'    => 'text_email',
			'classes' => array( 'half-width' ),
		)
	);

	$cmb->add_field(
		array(
			'name'             => __( 'Conferma', 'xlthlx' ),
			'id'               => '_active',
			'type'             => 'select',
			'show_option_none' => false,
			'default'          => 'no',
			'options'          => array(
				'no' => __( 'No', 'xlthlx' ),
				'si' => __( 'Si', 'xlthlx' ),
			),
			'classes'          => array( 'half-width' ),
		)
	);

	$cmb->add_field(
		array(
			'name'             => __( 'Lingua', 'xlthlx' ),
			'id'               => '_lang',
			'type'             => 'select',
			'show_option_none' => false,
			'default'          => 'it',
			'options'          => array(
				'it' => __( 'Italiano', 'xlthlx' ),
				'en' => __( 'English', 'xlthlx' ),
			),
			'classes'          => array( 'half-width' ),
		)
	);

	$cmb->add_field(
		array(
			'name'    => __( 'Codice', 'xlthlx' ),
			'id'      => '_code',
			'type'    => 'text_medium',
			'classes' => 'half-width',
		)
	);

	$cmb->add_field(
		array(
			'name'       => __( 'Ultima modifica', 'xlthlx' ),
			'id'         => '_last_contacted',
			'type'       => 'text_medium',
			'attributes' => array(
				'readonly' => 'readonly',
			),
			'classes'    => array( 'half-width' ),
		)
	);

}

add_action( 'cmb2_init', 'xlt_add_flamingo_metabox' );
