<?php
/**
 * Custom taxonomies for film/tv.
 *
 * @package  xlthlx
 */

/**
 * Custom taxonomy director.
 *
 * @return void
 */
function xlt_director_init() {
	$director_labels = array(
		'name'                       => 'Registi',
		'singular_name'              => 'Regista',
		'search_items'               => 'Cerca Registi',
		'popular_items'              => 'Registi Popolari',
		'all_items'                  => 'Tutti gli Registi',
		'parent_item'                => 'Regista Genitore',
		'parent_item_colon'          => 'Regista Genitore:',
		'edit_item'                  => 'Modifica Regista',
		'update_item'                => 'Aggiorna Regista',
		'view_item'                  => 'Visualizza Regista',
		'add_new_item'               => 'Aggiungi nuovo Regista',
		'new_item_name'              => 'Nuovo Regista',
		'separate_items_with_commas' => 'Separa Registi con virgole',
		'add_or_remove_items'        => 'Aggiungi o rimuovi Registi',
		'choose_from_most_used'      => 'Scegli tra gli Registi piu utilizzati',
		'not_found'                  => 'Nessun Regista trovato.',
		'no_terms'                   => 'Nessun Regista',
		'menu_name'                  => 'Registi',
		'items_list_navigation'      => 'Navigazione Lista Registi',
		'items_list'                 => 'Lista Registi',
		'most_used'                  => 'Piu utilizzati',
		'back_to_items'              => '&larr; Torna a Registi',
	);

	register_extended_taxonomy(
		'director',
		'film',
		array(
			'hierarchical'     => true,
			'labels'           => $director_labels,
			'public'           => false,
			'show_in_rest'     => true,
			'rewrite'          => false,
			'dashboard_glance' => true,

		),
		array(

			'singular' => 'Regista',
			'plural'   => 'Registi',
			'slug'     => 'director',

		)
	);
	// @codingStandardsIgnoreStart
	register_taxonomy_for_object_type( 'director', 'tvseries' );
	// @codingStandardsIgnoreEnd
}

add_action( 'init', 'xlt_director_init' );

/**
 * Custom taxonomy starring.
 *
 * @return void
 */
function xlt_starring_init() {
	$director_labels = array(
		'name'                       => 'Attori',
		'singular_name'              => 'Attore',
		'search_items'               => 'Cerca Attori',
		'popular_items'              => 'Attori Popolari',
		'all_items'                  => 'Tutti gli Attori',
		'parent_item'                => 'Attore Genitore',
		'parent_item_colon'          => 'Attore Genitore:',
		'edit_item'                  => 'Modifica Attore',
		'update_item'                => 'Aggiorna Attore',
		'view_item'                  => 'Visualizza Attore',
		'add_new_item'               => 'Aggiungi nuovo Attore',
		'new_item_name'              => 'Nuovo Attore',
		'separate_items_with_commas' => 'Separa Attori con virgole',
		'add_or_remove_items'        => 'Aggiungi o rimuovi Attori',
		'choose_from_most_used'      => 'Scegli tra gli Attori piu utilizzati',
		'not_found'                  => 'Nessun Attore trovato.',
		'no_terms'                   => 'Nessun Attore',
		'menu_name'                  => 'Attori',
		'items_list_navigation'      => 'Navigazione Lista Attori',
		'items_list'                 => 'Lista Attori',
		'most_used'                  => 'Piu utilizzati',
		'back_to_items'              => '&larr; Torna a Attori',
	);

	register_extended_taxonomy(
		'actor',
		'film',
		array(
			'hierarchical'     => true,
			'labels'           => $director_labels,
			'public'           => false,
			'show_in_rest'     => true,
			'rewrite'          => false,
			'dashboard_glance' => true,

		),
		array(

			'singular' => 'Attore',
			'plural'   => 'Attori',
			'slug'     => 'actor',

		)
	);
	// @codingStandardsIgnoreStart
	register_taxonomy_for_object_type( 'actor', 'tvseries' );
	// @codingStandardsIgnoreEnd
}

add_action( 'init', 'xlt_starring_init' );
