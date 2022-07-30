<?php
/**
 * Adds Thumbnail column for posts
 *
 * @param array $columns
 *
 * @return array $columns
 */
function wt_posts_columns( $columns ) {
	$post_type = get_post_type();
	if ( $post_type === 'post' ) {
		unset( $columns['date'] );

		$columns = array_merge( $columns,
			[ 'thumbs' => __( 'Thumbnail' ),'date' => __( 'Date' ) ] );
	}

	return $columns;
}

/**
 * Sets content for Thumbnail column and date
 *
 * @param string $column_name
 * @param int $id
 */
function wt_posts_custom_columns( $column_name,$id ) {
	if ( $column_name === 'thumbs' ) {
		echo get_the_post_thumbnail( $id,'thumbnail' );
	}
	if ( $column_name === 'date' ) {
		echo get_the_date( $id );
	}
}

if ( is_admin() ) {
	add_filter( 'manage_posts_columns','wt_posts_columns',9999 );
	add_action( 'manage_posts_custom_column','wt_posts_custom_columns',9999,2 );
}
