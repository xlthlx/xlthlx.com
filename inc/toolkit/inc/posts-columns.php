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

		$columns = array_merge(
			$columns,
			array(
				'xlt_thumbs' => __( 'Thumbnail' ),
				'xlt_date'   => __( 'Date Modified' ),
			)
		);
	}

	return $columns;
}

/**
 * Sets content for Thumbnail column and date
 *
 * @param string $column_name
 * @param int    $id
 */
function wt_posts_custom_columns( $column_name, $id ) {
	if ( $column_name === 'xlt_thumbs' ) {
		echo get_the_post_thumbnail( $id, 'thumbnail' );
	}
	if ( $column_name === 'xlt_date' ) {
		echo get_the_modified_time( 'l, d F Y H:i:s', $id );
	}
}

if ( is_admin() ) {
	add_filter( 'manage_posts_columns', 'wt_posts_columns', 9999 );
	add_action( 'manage_posts_custom_column', 'wt_posts_custom_columns', 9999, 2 );
}
