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
		'name'                  => __( 'Films','xlthlx' ),
		'singular_name'         => __( 'Film','xlthlx' ),
		'all_items'             => __( 'All Films','xlthlx' ),
		'archives'              => __( 'Film Archives','xlthlx' ),
		'attributes'            => __( 'Film Attributes','xlthlx' ),
		'insert_into_item'      => __( 'Insert in Film','xlthlx' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Film','xlthlx' ),
		'featured_image'        => _x( 'Featured Image','film','xlthlx' ),
		'set_featured_image'    => _x( 'Set featured image','film','xlthlx' ),
		'remove_featured_image' => _x( 'Remove featured image','film','xlthlx' ),
		'use_featured_image'    => _x( 'Use as featured image','film','xlthlx' ),
		'filter_items_list'     => __( 'Filter Films list','xlthlx' ),
		'items_list_navigation' => __( 'Films list navigation','xlthlx' ),
		'items_list'            => __( 'Films list','xlthlx' ),
		'new_item'              => __( 'New Film','xlthlx' ),
		'add_new'               => __( 'Add New','xlthlx' ),
		'add_new_item'          => __( 'Add New Film','xlthlx' ),
		'edit_item'             => __( 'Edit Film','xlthlx' ),
		'view_item'             => __( 'View Film','xlthlx' ),
		'view_items'            => __( 'View Films','xlthlx' ),
		'search_items'          => __( 'Search Films','xlthlx' ),
		'not_found'             => __( 'No Films found','xlthlx' ),
		'not_found_in_trash'    => __( 'No Films found in trash','xlthlx' ),
		'parent_item_colon'     => __( 'Parent Film:','xlthlx' ),
		'menu_name'             => __( 'Films','xlthlx' ),
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
		'supports'           => [ 'title','editor','thumbnail','revisions' ],
		'admin_cols'         => [
			'title' => [
				'title'   => 'Film',
				'default' => 'ASC',
			],
			'date'  => [
				'title' => 'Data',
			],
		],
		'admin_filters'      => [
		],
	],[

		'singular' => __( 'Film','xlthlx' ),
		'plural'   => __( 'Films','xlthlx' ),
		'slug'     => __( 'film','xlthlx' )

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
		1  => sprintf( __( 'Film updated. <a target="_blank" href="%s">View Film</a>','xlthlx' ),esc_url( $permalink ) ),
		2  => __( 'Custom field updated.','xlthlx' ),
		3  => __( 'Custom field deleted.','xlthlx' ),
		4  => __( 'Film updated.','xlthlx' ),
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Film restored to revision from %s','xlthlx' ),wp_post_revision_title( (int) $_GET['revision'],false ) ) : false,
		6  => sprintf( __( 'Film published. <a href="%s">View Film</a>','xlthlx' ),esc_url( $permalink ) ),
		7  => __( 'Film saved.','xlthlx' ),
		8  => sprintf( __( 'Film submitted. <a target="_blank" href="%s">Preview Film</a>','xlthlx' ),esc_url( add_query_arg( 'preview','true',$permalink ) ) ),
		9  => sprintf( __( 'Film scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Film</a>','xlthlx' ),
			date_i18n( __( 'M j, Y @ G:i','xlthlx' ),strtotime( $post->post_date ) ),esc_url( $permalink ) ),
		10 => sprintf( __( 'Film draft updated. <a target="_blank" href="%s">Preview Film</a>','xlthlx' ),esc_url( add_query_arg( 'preview','true',$permalink ) ) ),
	];

	return $messages;
}

add_filter( 'post_updated_messages','xlt_film_updated_messages' );
