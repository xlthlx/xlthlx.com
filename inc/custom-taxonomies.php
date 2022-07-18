<?php

function xlt_year_init() {
	$years_labels = [
		'name'                       => 'Anni',
		'singular_name'              => 'Anno',
		'search_items'               => 'Cerca Anni',
		'popular_items'              => 'Anni Popolari',
		'all_items'                  => 'Tutti gli Anni',
		'parent_item'                => 'Anno Genitore',
		'parent_item_colon'          => 'Anno Genitore:',
		'edit_item'                  => 'Modifica Anno',
		'update_item'                => 'Aggiorna Anno',
		'view_item'                  => 'Visualizza Anno',
		'add_new_item'               => 'Aggiungi nuovo Anno',
		'new_item_name'              => 'Nuovo Anno',
		'separate_items_with_commas' => 'Separa Anni con virgole',
		'add_or_remove_items'        => 'Aggiungi o rimuovi Anni',
		'choose_from_most_used'      => 'Scegli tra gli Anni piu utilizzati',
		'not_found'                  => 'Nessun Anno trovato.',
		'no_terms'                   => 'Nessun Anno',
		'menu_name'                  => 'Anni',
		'items_list_navigation'      => 'Navigazione Lista Anni',
		'items_list'                 => 'Lista Anni',
		'most_used'                  => 'Piu utilizzati',
		'back_to_items'              => '&larr; Torna a Anni'
	];

	register_extended_taxonomy( 'year','film',[
		'hierarchical'     => true,
		'labels'           => $years_labels,
		'public'           => false,
		'show_in_rest'     => true,
		'rewrite'          => false,
		'dashboard_glance' => true,

	],[

		'singular' => 'Anno',
		'plural'   => 'Anni',
		'slug'     => 'Anno'

	] );

	register_taxonomy_for_object_type( 'year','tvseries' );
}

add_action( 'init','xlt_year_init' );
