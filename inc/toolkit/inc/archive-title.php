<?php
/**
 * Remove archive title.
 *
 * @param $title
 *
 * @return string
 */
function wt_remove_archive_title_prefix( $title ) {

	$single_cat_title = single_term_title( '',false );
	if ( is_category() || is_tag() || is_tax() ) {
		return esc_html( $single_cat_title );
	}

	return $title;
}

add_filter( 'get_the_archive_title','wt_remove_archive_title_prefix' );
