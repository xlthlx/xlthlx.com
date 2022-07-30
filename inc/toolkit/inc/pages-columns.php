<?php
/**
 * Remove comments column and adds Template column for pages
 *
 * @param array $columns
 *
 * @return array $columns
 */
function wt_page_column_views( $columns ) {
	unset( $columns['comments'],$columns['date'] );

	return array_merge( $columns,
		[ 'page-layout' => __( 'Template' ),'date' => __( 'Date' ) ] );

}

/**
 * Sets content for Template column and date
 *
 * @param string $column_name
 * @param int $id
 */
function wt_page_custom_column_views( $column_name,$id ) {
	if ( $column_name === 'page-layout' ) {
		$set_template = get_post_meta( get_the_ID(),'_wp_page_template',
			true );
		if ( ( $set_template === 'default' ) || ( $set_template === '' ) ) {
			$set_template = 'Default';
		}
		$templates = wp_get_theme()->get_page_templates();
		foreach ( $templates as $key => $value ) :
			if ( ( $set_template === $key ) && ( $set_template !== '' ) ) {
				$set_template = $value;
			}
		endforeach;

		echo $set_template;
	}
	if ( $column_name === 'date' ) {
		echo get_the_date( $id );
	}
}

if ( is_admin() ) {
	add_filter( 'manage_pages_columns','wt_page_column_views',9999 );
	add_action( 'manage_pages_custom_column','wt_page_custom_column_views',9999,2 );
}
