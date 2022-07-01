<?php
/**
 * Functions for custom link manager.
 *
 * @package  xlthlx
 */

add_action( 'load-link-add.php', 'xlt_add_meta_boxes' );
add_action( 'load-link.php', 'xlt_add_meta_boxes' );
add_action( 'load-link-manager.php', 'xlt_setup_columns' );

/**
 * Adds meta boxes.
 */
function xlt_add_meta_boxes() {
	add_action( 'add_meta_boxes', 'xlt_add_link_meta_boxes' );
	add_action( 'edit_link', 'xlt_save_link_meta_box_year' );
	add_action( 'edit_link', 'xlt_save_link_meta_box_directors' );
	add_action( 'edit_link', 'xlt_save_link_meta_box_starring' );
}

/**
 * All hooks for custom columns.
 */
function xlt_setup_columns() {
	add_filter( 'manage_link-manager_columns', 'xlt_add_remove_link_columns' );
	add_action( 'manage_link_custom_column', 'xlt_add_link_columns_data', 10, 2 );
	add_filter( 'manage_link-manager_sortable_columns', 'xlt_register_sortable_columns' );
	add_filter( 'request', 'xlt_order_by_column_year' );
}

/**
 * Add columns Description and Year.
 */
function xlt_add_remove_link_columns( $link_columns ) {

	$link_columns['link_description'] = 'Descrizione';
	$link_columns['year']             = 'Anno';
	$link_columns['directors']             = 'Director(s)';
	$link_columns['starring']             = 'Starring';

	unset( $link_columns['rel'], $link_columns['rating'], $link_columns['visible'] );

	return $link_columns;
}

/**
 * Display column content.
 *
 * @param $column_name
 * @param $id
 *
 * @return void
 */
function xlt_add_link_columns_data( $column_name, $id ) {

	if ( $column_name === 'year' ) {
		$val = get_post_meta( $id, 'link_year', true );
		if ( empty( $val ) ) {
			return;
		}

		echo $val;
	}

	if ( $column_name === 'directors' ) {
		$val = get_post_meta( $id, 'link_directors', true );
		if ( empty( $val ) ) {
			return;
		}

		echo $val;
	}

	if ( $column_name === 'starring' ) {
		$val = get_post_meta( $id, 'link_starring', true );
		if ( empty( $val ) ) {
			return;
		}

		echo $val;
	}

	if ( $column_name === 'link_description' ) {
		$val = get_bookmark_field( 'link_description', $id );
		if ( empty( $val ) ) {
			return;
		}

		echo $val;
	}
}

/**
 * Register column for sorting.
 *
 * @param $columns
 *
 * @return string
 */
function xlt_register_sortable_columns( $columns ) {
	$columns['year'] = 'year';
	$columns['directors'] = 'directors';
	$columns['starring'] = 'starring';

	return $columns;
}

/**
 * Register order by.
 *
 * @param $vars
 *
 * @return string
 */
function xlt_order_by_column_year( $vars ) {
	if ( isset( $vars['orderby'] ) && 'year' === $vars['orderby'] ) {
		$vars = array_merge( $vars, array(
			'meta_key' => 'year',
			'orderby'  => 'meta_value'
		) );
	}

	return $vars;
}

/**
 * Add meta box.
 */
function xlt_add_link_meta_boxes() {
	add_meta_box(
		'link_year',
		'Year',
		'xlt_render_meta_box_year',
		'link',
		'side'
	);

	add_meta_box(
		'link_directors',
		'Director(s)',
		'xlt_render_meta_box_directors',
		'link',
		'side'
	);

	add_meta_box(
		'link_starring',
		'Starring',
		'xlt_render_meta_box_starring',
		'link',
		'side'
	);
}

/**
 * Render meta box.
 */
function xlt_render_meta_box_year() {

	global $link;
	wp_nonce_field( plugin_basename( __FILE__ ), 'xlt_year_nonce' );

	$value = get_post_meta( $link->link_id, 'link_year', true );
	echo '<label for="link_year">';
	echo "Year";
	echo '</label> ';
	echo '<input type="text" id="link_year" name="link_year" value="' . esc_attr( $value ) . '"  />';
}

function xlt_render_meta_box_directors() {
	global $link;
	wp_nonce_field( plugin_basename( __FILE__ ), 'xlt_directors_nonce' );

	$value = get_post_meta( $link->link_id, 'link_directors', true );
	echo '<label for="link_directors">';
	echo "Director(s)";
	echo '</label> ';
	echo '<input type="text" id="link_directors" name="link_directors" value="' . esc_attr( $value ) . '"  />';
}

function xlt_render_meta_box_starring() {
	global $link;
	wp_nonce_field( plugin_basename( __FILE__ ), 'xlt_starring_nonce' );

	$value = get_post_meta( $link->link_id, 'link_starring', true );
	echo '<label for="link_starring">';
	echo "Starring";
	echo '</label><br/>';
	echo '<textarea name="link_starring" id="link_starring" rows="5" spellcheck="false">';
	echo esc_attr( $value );
	echo '</textarea>';
}


/**
 * Save meta box.
 *
 * @param $post_id
 *
 * @return void
 */
function xlt_save_link_meta_box_year( $post_id ) {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! isset( $_POST['xlt_year_nonce'] ) || ! wp_verify_nonce( $_POST['xlt_year_nonce'], plugin_basename( __FILE__ ) ) ) {
		return;
	}

	$link_year = sanitize_text_field( $_POST['link_year'] );
	update_post_meta( $post_id, 'link_year', $link_year );
}

/**
 * Save meta box.
 *
 * @param $post_id
 *
 * @return void
 */
function xlt_save_link_meta_box_directors( $post_id ) {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! isset( $_POST['xlt_directors_nonce'] ) || ! wp_verify_nonce( $_POST['xlt_directors_nonce'], plugin_basename( __FILE__ ) ) ) {
		return;
	}

	$link_directors = sanitize_text_field( $_POST['link_directors'] );
	update_post_meta( $post_id, 'link_directors', $link_directors );
}

/**
 * Save meta box.
 *
 * @param $post_id
 *
 * @return void
 */
function xlt_save_link_meta_box_starring( $post_id ) {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! isset( $_POST['xlt_starring_nonce'] ) || ! wp_verify_nonce( $_POST['xlt_starring_nonce'], plugin_basename( __FILE__ ) ) ) {
		return;
	}

	$link_starring = sanitize_text_field( $_POST['link_starring'] );
	update_post_meta( $post_id, 'link_starring', $link_starring );
}
