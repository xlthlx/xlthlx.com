<?php

/**
 * Registers the `tv_series` post type.
 */
function xlt_tv_series_init() {

	$tv = 'data:image/svg+xml;base64,' . base64_encode( '<svg xmlns="http://www.w3.org/2000/svg" version="1.0" viewBox="0 0 512 512">
	<path fill="#FFFFFF"
		  d="M145 9.2c-5.8 4-7.5 7.2-7.5 14.1v6.2l28.8 47.2c15.8 25.9 28.7 47.4 28.7 47.7 0 .3-37.1.6-82.5.6-81.1 0-82.5 0-88 2.1-7.4 2.8-13.2 7.3-17.7 13.9-7.2 10.6-6.8-.1-6.8 174s-.4 163.4 6.8 174c4.5 6.6 10.3 11.1 17.7 13.9l5.6 2.1h451.8l5.6-2.1c7.4-2.8 13.2-7.3 17.7-13.9 7.2-10.6 6.8.1 6.8-174s.4-163.4-6.8-174c-4.5-6.6-10.3-11.1-17.7-13.9-5.5-2.1-6.9-2.1-88-2.1-45.4 0-82.5-.3-82.5-.6s12.9-21.8 28.8-47.7l28.7-47.2v-6.2c0-6.9-1.7-10.1-7.5-14.1-4.6-3.1-11.9-3-17.4.2-3.7 2.2-7.7 8.3-38.5 59L276.6 125h-41.2l-34.5-56.6c-30.8-50.7-34.8-56.8-38.5-59-5.5-3.2-12.8-3.3-17.4-.2zm203.1 179.6c4.3 2.2 5.9 3.8 8.1 8.1l2.8 5.3v225.6l-2.8 5.3c-2.2 4.3-3.8 5.9-8.1 8.1l-5.3 2.8H209.9c-146.7 0-136.7.4-143.7-6.3C59.8 431.5 60 436 60 315c0-121.1-.2-116.5 6.2-122.7 6.9-6.7-3.2-6.2 143.4-6.3h133.2l5.3 2.8zm100.4 27.5c17.2 8 24.8 28.8 16.8 45.8-3.8 8.1-9.1 13.4-17.2 17.2-17 8-37.7.4-45.8-16.8-2.4-5.2-2.8-7.2-2.8-15 0-10.6 1.9-15.8 8.5-22.9 7.9-8.6 15.4-11.7 27-11.3 5.7.2 8.9.9 13.5 3zm-.5 134.3c7.4 3.3 14.2 10.3 17.6 17.8 3.6 7.9 3.8 18.3.5 26.8-2.9 7.5-9.9 14.9-17.6 18.5-5.2 2.4-7.2 2.8-15 2.8s-9.7-.4-14.6-2.8c-6.7-3.2-14.2-10.9-17.2-17.5-3.3-7.3-3.1-20.7.5-28.4 8.2-17.5 28.4-25 45.8-17.2z"/>
</svg>' );


	$labels = [
		'name'                  => __( 'TV Series','xlthlx' ),
		'singular_name'         => __( 'TV Series','xlthlx' ),
		'all_items'             => __( 'All TV Series','xlthlx' ),
		'archives'              => __( 'TV Series Archives','xlthlx' ),
		'attributes'            => __( 'TV Series Attributes','xlthlx' ),
		'insert_into_item'      => __( 'Insert in TV Series','xlthlx' ),
		'uploaded_to_this_item' => __( 'Uploaded to this TV Series','xlthlx' ),
		'featured_image'        => _x( 'Featured Image','tv-series','xlthlx' ),
		'set_featured_image'    => _x( 'Set featured image','tv-series','xlthlx' ),
		'remove_featured_image' => _x( 'Remove featured image','tv-series','xlthlx' ),
		'use_featured_image'    => _x( 'Use as featured image','tv-series','xlthlx' ),
		'filter_items_list'     => __( 'Filter TV Series list','xlthlx' ),
		'items_list_navigation' => __( 'TV Series list navigation','xlthlx' ),
		'items_list'            => __( 'TV Series list','xlthlx' ),
		'new_item'              => __( 'New TV Series','xlthlx' ),
		'add_new'               => __( 'Add New','xlthlx' ),
		'add_new_item'          => __( 'Add New TV Series','xlthlx' ),
		'edit_item'             => __( 'Edit TV Series','xlthlx' ),
		'view_item'             => __( 'View TV Series','xlthlx' ),
		'view_items'            => __( 'View TV Series','xlthlx' ),
		'search_items'          => __( 'Search TV Series','xlthlx' ),
		'not_found'             => __( 'No TV Series found','xlthlx' ),
		'not_found_in_trash'    => __( 'No TV Series found in trash','xlthlx' ),
		'parent_item_colon'     => __( 'Parent TV Series:','xlthlx' ),
		'menu_name'             => __( 'TV Series','xlthlx' ),
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
		'supports'           => [ 'title','editor','thumbnail','revisions' ],
		'admin_cols'         => [
			'title' => [
				'title'   => 'TV Series',
				'default' => 'ASC',
			],
			'date'  => [
				'title' => 'Data',
			],
		],
		'admin_filters'      => [
		],
	],[

		'singular' => __( 'TV Series','xlthlx' ),
		'plural'   => __( 'TV Series','xlthlx' ),
		'slug'     => __( 'tvseries','xlthlx' )

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
		1  => sprintf( __( 'TV Series updated. <a target="_blank" href="%s">View TV Series</a>','xlthlx' ),esc_url( $permalink ) ),
		2  => __( 'Custom field updated.','xlthlx' ),
		3  => __( 'Custom field deleted.','xlthlx' ),
		4  => __( 'TV Series updated.','xlthlx' ),
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'TV Series restored to revision from %s','xlthlx' ),wp_post_revision_title( (int) $_GET['revision'],false ) ) : false,
		6  => sprintf( __( 'TV Series published. <a href="%s">View TV Series</a>','xlthlx' ),esc_url( $permalink ) ),
		7  => __( 'TV Series saved.','xlthlx' ),
		8  => sprintf( __( 'TV Series submitted. <a target="_blank" href="%s">Preview TV Series</a>','xlthlx' ),esc_url( add_query_arg( 'preview','true',$permalink ) ) ),
		9  => sprintf( __( 'TV Series scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview TV Series</a>','xlthlx' ),
			date_i18n( __( 'M j, Y @ G:i','xlthlx' ),strtotime( $post->post_date ) ),esc_url( $permalink ) ),
		10 => sprintf( __( 'TV Series draft updated. <a target="_blank" href="%s">Preview TV Series</a>','xlthlx' ),esc_url( add_query_arg( 'preview','true',$permalink ) ) ),
	];

	return $messages;
}

add_filter( 'post_updated_messages','xlt_tv_series_updated_messages' );
