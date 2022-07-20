<?php
/**
 * Registers the `film` post type.
 */

function xlt_film_init() {

	$film = 'data:image/svg+xml;base64,' . base64_encode( '<svg xmlns="http://www.w3.org/2000/svg" version="1.0" viewBox="0 0 512 512">
	<path fill="#FFFFFF"
		  d="M80 35.4C41.4 43.6 12.4 71.5 2.7 110c-3.1 12.2-3 33.9.1 46.4 4.6 18.2 14.2 34.7 28 47.7 28.5 27 69.7 34.8 106.1 20 31-12.6 53.4-40.8 59.7-75.2l1.8-9.4 1.2 8c1.5 10.3 2.7 14.8 6.9 24.4 20.6 48.3 77.1 72 126.4 53.1 29.1-11.2 51.7-36.6 60.3-67.8 1.8-6.3 2.2-10.6 2.2-24.2.1-14.3-.2-17.6-2.2-25-9.4-34.3-35-60.5-68.8-70.5-12.1-3.7-33-4.6-45.4-2.1-24 4.9-44.1 16.8-58.5 34.8-12.3 15.5-21.2 36.8-21.6 52.3-.1 2.9-.7 1-2.4-7-2.8-13.3-5.4-20.7-10.1-29.4C173.1 61.7 151.8 44.7 125 37c-9.6-2.8-35-3.7-45-1.6zm28.5 58c20.2 4.8 33.8 25 30.5 45.3-1.1 6.3-5.7 16.5-9.3 20.5-10.7 11.6-27.3 16.5-41.7 12.2-13.2-3.9-24.6-15.5-28-28.3-1.5-5.9-1.3-17.5.4-23.2 3.9-12.6 14.4-22.5 27.6-26.1 8-2.1 12.8-2.2 20.5-.4zm196.6-.4c25.7 4.9 40.1 34.3 28.2 57.7-3.4 6.8-11 14.6-17.1 17.7-27.3 13.7-59.2-5.7-59.2-35.8 0-12 4.2-21.8 12.4-29.4 9.9-9.1 22.4-12.7 35.7-10.2z"/>
	<path fill="#FFFFFF"
		  d="M157.1 234.6c-7.4 4.6-18.5 9.1-30 12.2-8.4 2.2-11.7 2.5-26.6 2.6-10.6.1-19.2-.4-23-1.2-8.8-1.9-21.2-6-26.6-8.7l-4.7-2.4-3.8 2.8c-10.2 7.4-17.3 18.8-19.4 30.9-.7 4.7-1 31.3-.8 87.2.3 79.7.3 80.6 2.5 86.2 6 15.7 17.1 26.4 33.2 31.9 5.2 1.8 11 1.9 140.6 1.9s135.4-.1 140.6-1.9c9.3-3.1 14.1-6.1 20.4-12.5 7.4-7.4 11.1-13.8 13.6-23.5 1.8-7 1.9-11.9 1.9-84.5 0-49-.4-79.5-1.1-83.6-1.9-12.2-10.3-25.5-20.4-32.7l-3.1-2.1-6.7 2.9c-31.3 13.3-65.2 13.1-95.2-.6-4-1.8-9-4.5-11.1-5.9l-3.9-2.6-35.5.1-35.5.1-5.4 3.4zM479.4 256.3C476 258 455 270.1 432.7 283l-40.6 23.5-.1 48.7v48.7l11.8 7c6.4 3.8 27 15.8 45.7 26.7l34 19.8 7.2.1c6.3 0 7.6-.3 11.4-3 2.3-1.7 5.2-4.8 6.4-7.1 2.2-4.1 2.2-4.5 2.9-90.7.8-95.1 1-90.5-5.2-97-7.1-7.5-16.7-8.8-26.8-3.4z"/>
</svg>' );


	$labels = [
		'name'                  => 'Film',
		'singular_name'         => 'Film',
		'all_items'             => 'Tutti i Film',
		'archives'              => 'Archivio dei Film',
		'attributes'            => 'Attributi dei Film',
		'insert_into_item'      => 'Inserisci in Film',
		'uploaded_to_this_item' => 'Caricato in questo Film',
		'featured_image'        => 'Locandina',
		'set_featured_image'    => 'Imposta locandina',
		'remove_featured_image' => 'Rimuovi locandina',
		'use_featured_image'    => 'Usa come locandine',
		'filter_items_list'     => 'Filtra la lista dei Film',
		'items_list_navigation' => 'Navigaziona lista Film',
		'items_list'            => 'Lista Film',
		'new_item'              => 'Nuovo Film',
		'add_new'               => 'Aggiungi Nuovo',
		'add_new_item'          => 'Aggiungi Nuovo Film',
		'edit_item'             => 'Modifica Film',
		'view_item'             => 'Visualizza Film',
		'view_items'            => 'Visualizza Film',
		'search_items'          => 'Cerca Film',
		'not_found'             => 'Nessun Film trovato',
		'not_found_in_trash'    => 'Nessun Film trovato nel cestino',
		'parent_item_colon'     => 'Film Genitore:',
		'menu_name'             => 'Film',
	];


	register_extended_post_type( 'film',[
		'publicly_queryable' => false,
		'menu_position'      => 55,
		'menu_icon'          => $film,
		'rewrite'            => false,
		'labels'             => $labels,
		'capability_type'    => 'page',
		'has_archive'        => false,
		'hierarchical'       => false,
		'show_in_rest'       => true,
		'block_editor'       => true,
		'supports'           => [ 'title','editor','thumbnail','revisions','convert-to-blocks' ],
		'admin_cols'         => [
			'title'    => [
				'title'   => 'Film',
				'default' => 'ASC',
			],
			'year'     => [
				'title'    => 'Anno',
				'taxonomy' => 'year'
			],
			'director' => [
				'title'    => 'Regista',
				'taxonomy' => 'director'
			],
			'actor'    => [
				'title'    => 'Attori',
				'taxonomy' => 'actor'
			],
			'date'     => [
				'title' => 'Data',
			],
		],
		'admin_filters'      => [
			'year'     => [
				'title'    => 'Anno',
				'taxonomy' => 'year'
			],
			'director' => [
				'title'    => 'Regista',
				'taxonomy' => 'director'
			],
			'actor'    => [
				'title'    => 'Attori',
				'taxonomy' => 'actor'
			],
		],
	],[

		'singular' => 'Film',
		'plural'   => 'Film',
		'slug'     => 'film'

	] );

}

add_action( 'init','xlt_film_init' );

/**
 * Sets the post updated messages for the `film` post type.
 *
 * @param array $messages Post updated messages.
 *
 * @return array Messages for the `film` post type.
 */
function xlt_film_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['film'] = [
		0  => '',
		1  => sprintf( 'Film updated. <a target="_blank" href="%s">View Film</a>',esc_url( $permalink ) ),
		2  => 'Custom field updated.',
		3  => 'Custom field deleted.',
		4  => 'Film updated.',
		5  => isset( $_GET['revision'] ) ? sprintf( 'Film restored to revision from %s',wp_post_revision_title( (int) $_GET['revision'],false ) ) : false,
		6  => sprintf( 'Film published. <a href="%s">View Film</a>',esc_url( $permalink ) ),
		7  => 'Film saved.',
		8  => sprintf( 'Film submitted. <a target="_blank" href="%s">Preview Film</a>',esc_url( add_query_arg( 'preview','true',$permalink ) ) ),
		9  => sprintf( 'Film scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Film</a>',
			date_i18n( 'M j, Y @ G:i',strtotime( $post->post_date ) ),esc_url( $permalink ) ),
		10 => sprintf( 'Film draft updated. <a target="_blank" href="%s">Preview Film</a>',esc_url( add_query_arg( 'preview','true',$permalink ) ) ),
	];

	return $messages;
}

add_filter( 'post_updated_messages','xlt_film_updated_messages' );


/**
 * Registers the `tv_series` post type.
 */
function xlt_tv_series_init() {

	$tv = 'data:image/svg+xml;base64,' . base64_encode( '<svg xmlns="http://www.w3.org/2000/svg" version="1.0" viewBox="0 0 512 512">
	<path fill="#FFFFFF"
		  d="M145 9.2c-5.8 4-7.5 7.2-7.5 14.1v6.2l28.8 47.2c15.8 25.9 28.7 47.4 28.7 47.7 0 .3-37.1.6-82.5.6-81.1 0-82.5 0-88 2.1-7.4 2.8-13.2 7.3-17.7 13.9-7.2 10.6-6.8-.1-6.8 174s-.4 163.4 6.8 174c4.5 6.6 10.3 11.1 17.7 13.9l5.6 2.1h451.8l5.6-2.1c7.4-2.8 13.2-7.3 17.7-13.9 7.2-10.6 6.8.1 6.8-174s.4-163.4-6.8-174c-4.5-6.6-10.3-11.1-17.7-13.9-5.5-2.1-6.9-2.1-88-2.1-45.4 0-82.5-.3-82.5-.6s12.9-21.8 28.8-47.7l28.7-47.2v-6.2c0-6.9-1.7-10.1-7.5-14.1-4.6-3.1-11.9-3-17.4.2-3.7 2.2-7.7 8.3-38.5 59L276.6 125h-41.2l-34.5-56.6c-30.8-50.7-34.8-56.8-38.5-59-5.5-3.2-12.8-3.3-17.4-.2zm203.1 179.6c4.3 2.2 5.9 3.8 8.1 8.1l2.8 5.3v225.6l-2.8 5.3c-2.2 4.3-3.8 5.9-8.1 8.1l-5.3 2.8H209.9c-146.7 0-136.7.4-143.7-6.3C59.8 431.5 60 436 60 315c0-121.1-.2-116.5 6.2-122.7 6.9-6.7-3.2-6.2 143.4-6.3h133.2l5.3 2.8zm100.4 27.5c17.2 8 24.8 28.8 16.8 45.8-3.8 8.1-9.1 13.4-17.2 17.2-17 8-37.7.4-45.8-16.8-2.4-5.2-2.8-7.2-2.8-15 0-10.6 1.9-15.8 8.5-22.9 7.9-8.6 15.4-11.7 27-11.3 5.7.2 8.9.9 13.5 3zm-.5 134.3c7.4 3.3 14.2 10.3 17.6 17.8 3.6 7.9 3.8 18.3.5 26.8-2.9 7.5-9.9 14.9-17.6 18.5-5.2 2.4-7.2 2.8-15 2.8s-9.7-.4-14.6-2.8c-6.7-3.2-14.2-10.9-17.2-17.5-3.3-7.3-3.1-20.7.5-28.4 8.2-17.5 28.4-25 45.8-17.2z"/>
</svg>' );


	$labels = [
		'name'                  => 'Serie TV',
		'singular_name'         => 'Serie TV',
		'all_items'             => 'Tutte le Serie TV',
		'archives'              => 'Archivio delle Serie TV',
		'attributes'            => 'Attributi deelle Serie TV',
		'insert_into_item'      => 'Inserisci in Serie TV',
		'uploaded_to_this_item' => 'Caricato in questa Serie TV',
		'featured_image'        => 'Locandina',
		'set_featured_image'    => 'Imposta locandina',
		'remove_featured_image' => 'Rimuovi locandina',
		'use_featured_image'    => 'Usa come locandine',
		'filter_items_list'     => 'Filtra la lista delle Serie TV',
		'items_list_navigation' => 'Navigaziona lista Serie TV',
		'items_list'            => 'Lista Serie TV',
		'new_item'              => 'Nuovo Serie TV',
		'add_new'               => 'Aggiungi Nuova',
		'add_new_item'          => 'Aggiungi Nuova Serie TV',
		'edit_item'             => 'Modifica Serie TV',
		'view_item'             => 'Visualizza Serie TV',
		'view_items'            => 'Visualizza Serie TV',
		'search_items'          => 'Cerca Serie TV',
		'not_found'             => 'Nessun Serie TV trovata',
		'not_found_in_trash'    => 'Nessun Serie TV trovata nel cestino',
		'parent_item_colon'     => 'Serie TV Genitore:',
		'menu_name'             => 'Serie TV',
	];

	register_extended_post_type( 'tvseries',[
		'publicly_queryable' => false,
		'menu_position'      => 55,
		'menu_icon'          => $tv,
		'rewrite'            => false,
		'labels'             => $labels,
		'capability_type'    => 'page',
		'has_archive'        => false,
		'hierarchical'       => false,
		'show_in_rest'       => true,
		'block_editor'       => true,
		'supports'           => [ 'title','editor','thumbnail','revisions','convert-to-blocks' ],
		'admin_cols'         => [
			'title'    => [
				'title'   => 'TV Series',
				'default' => 'ASC',
			],
			'year'     => [
				'title'    => 'Anno',
				'taxonomy' => 'year'
			],
			'director' => [
				'title'    => 'Regista',
				'taxonomy' => 'director'
			],
			'actor'    => [
				'title'    => 'Attori',
				'taxonomy' => 'actor'
			],
			'date'     => [
				'title' => 'Data',
			],
		],
		'admin_filters'      => [
			'year'     => [
				'title'    => 'Anno',
				'taxonomy' => 'year'
			],
			'director' => [
				'title'    => 'Regista',
				'taxonomy' => 'director'
			],
			'actor'    => [
				'title'    => 'Attori',
				'taxonomy' => 'actor'
			],
		],
	],[

		'singular' => 'TV Series',
		'plural'   => 'TV Series',
		'slug'     => 'tvseries'

	] );
}

add_action( 'init','xlt_tv_series_init' );

/**
 * Sets the post updated messages for the `tv_series` post type.
 *
 * @param array $messages Post updated messages.
 *
 * @return array Messages for the `tv_series` post type.
 */
function xlt_tv_series_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['tv-series'] = [
		0  => '',
		1  => sprintf( 'TV Series updated. <a target="_blank" href="%s">Visualizza Serie TV</a>',esc_url( $permalink ) ),
		2  => 'Custom field updated.',
		3  => 'Custom field deleted.',
		4  => 'Serie TV aggiornata.',
		5  => isset( $_GET['revision'] ) ? sprintf( 'TV Series restored to revision from %s',wp_post_revision_title( (int) $_GET['revision'],false ) ) : false,
		6  => sprintf( 'TV Series published. <a href="%s">View TV Series</a>',esc_url( $permalink ) ),
		7  => 'TV Series saved.',
		8  => sprintf( 'TV Series submitted. <a target="_blank" href="%s">Preview TV Series</a>',esc_url( add_query_arg( 'preview','true',$permalink ) ) ),
		9  => sprintf( 'TV Series scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview TV Series</a>',
			date_i18n( 'M j, Y @ G:i',strtotime( $post->post_date ) ),esc_url( $permalink ) ),
		10 => sprintf( 'TV Series draft updated. <a target="_blank" href="%s">Preview TV Series</a>',esc_url( add_query_arg( 'preview','true',$permalink ) ) ),
	];

	return $messages;
}

add_filter( 'post_updated_messages','xlt_tv_series_updated_messages' );


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
