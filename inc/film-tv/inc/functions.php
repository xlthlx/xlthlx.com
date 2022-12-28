<?php
/**
 * Custom functions for film/tv.
 *
 * @package  xlthlx
 */

/**
 * Init.
 *
 * @return void
 */
function xlt_init_all() {
	xlt_tv_series_init();
	xlt_film_init();
}

add_action( 'after_switch_theme', 'xlt_init_all' );

/**
 * Add custom fields.
 */
function xlt_add_film_metabox() {
	$cmb_post = new_cmb2_box(
		array(
			'id'           => 'group_link',
			'title'        => 'Links',
			'object_types' => array( 'film', 'tvseries' ),
			'context'      => 'side',
			'priority'     => 'high',
		)
	);

	$cmb_post->add_field(
		array(
			'name'         => 'Link',
			'id'           => 'link',
			'type'         => 'text_url',
			'show_in_rest' => WP_REST_Server::ALLMETHODS,
		)
	);

	$cmb_post->add_field(
		array(
			'name'         => 'English Link',
			'id'           => 'link_en',
			'type'         => 'text_url',
			'show_in_rest' => WP_REST_Server::ALLMETHODS,
		)
	);

	$cmb_post->add_field(
		array(
			'name'         => 'Recensione',
			'id'           => 'internal',
			'type'         => 'text_url',
			'show_in_rest' => WP_REST_Server::ALLMETHODS,
		)
	);

	$cmb_year = new_cmb2_box(
		array(
			'id'           => 'group_year',
			'title'        => 'Anno',
			'object_types' => array( 'film', 'tvseries' ),
			'context'      => 'side',
			'priority'     => 'high',
		)
	);

	$cmb_year->add_field(
		array(
			'name'         => 'Anno',
			'id'           => 'year',
			'type'         => 'text',
			'show_in_rest' => WP_REST_Server::ALLMETHODS,
		)
	);
}

add_action( 'cmb2_init', 'xlt_add_film_metabox' );
