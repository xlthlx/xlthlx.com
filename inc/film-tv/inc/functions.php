<?php

/**
 * Flush rewrite rules.
 *
 * @return void
 */
function xlt_rewrite_flush() {
	xlt_tv_series_init();
	xlt_film_init();
	flush_rewrite_rules();
}

add_action( 'after_switch_theme','xlt_rewrite_flush' );

/**
 * Add custom fields.
 */
function xlt_add_film_metabox() {
	$cmb_post = new_cmb2_box( [
		'id'           => 'group_link',
		'title'        => 'Altro',
		'object_types' => [ 'film','tvseries' ],
		'context'      => 'side',
		'priority'     => 'high',
	] );

	$cmb_post->add_field( [
		'name'         => 'Link',
		'id'           => 'link',
		'type'         => 'text_url',
		'show_in_rest' => WP_REST_Server::ALLMETHODS,
	] );

	$cmb_post->add_field( [
		'name'         => 'English Link',
		'id'           => 'link_en',
		'type'         => 'text_url',
		'show_in_rest' => WP_REST_Server::ALLMETHODS,
	] );

	$cmb_post->add_field( [
		'name'         => 'Recensione',
		'id'           => 'internal',
		'type'         => 'text_url',
		'show_in_rest' => WP_REST_Server::ALLMETHODS,
	] );
}

add_action( 'cmb2_init','xlt_add_film_metabox' );
