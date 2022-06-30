<?php

add_action( 'load-link-add.php', 'meta_box' );
add_action( 'load-link.php', 'meta_box' );
add_action( 'load-link-manager.php', 'make_columns' );
add_filter( 'get_bookmarks', 'link_manager_order' );
add_action( 'admin_footer-link-manager.php', 'print_admin_footer' );
add_filter( 'attachment_fields_to_edit', 'remove_upload_fields', 99, 2 );

/**
 * Instantiate Meta Box.
 */
function meta_box() {
	add_action( 'add_meta_boxes', 'add_fli_meta_box' );
}

/**
 * Dispatch all hooks for custom columns.
 */
function make_columns() {
	add_filter( 'manage_link-manager_columns', 'add_id_column' );
	add_action( 'manage_link_custom_column', 'add_id_column_data', 10, 2 );

	add_filter( 'request', 'thumb_column_orderby' );
	add_filter( 'manage_link-manager_sortable_columns', 'column_register_sortable' );
}

/**
 * Add columns, ID and Thumbnail
 *
 */
function add_id_column( $link_columns ) {
	$link_columns['thumbnail'] = __( 'Thumbnail', 'fli' );

	return $link_columns;
}

/**
 * Display column content
 *
 * @param string $column_name
 * @param int $id
 */
function add_id_column_data( $column_name, $id ) {
	if ( $column_name === 'thumbnail' ) {
		$val = get_bookmark_field( 'link_image', $id );
		if ( empty( $val ) ) {
			return;
		}

		$img = '<img src="' . $val . '" style="max-width:50px">';
		echo $img;
	}
}

/**
 * Register column for display
 *
 * @param $columns
 *
 * @return string
 */
function column_register_sortable( $columns ) {
	$columns['thumbnail'] = 'link_image';

	return $columns;
}

/**
 * Register orderby in 'request' filter
 *
 * @param $vars
 *
 * @return string
 */
function thumb_column_orderby( $vars ) {
	if ( isset( $vars['orderby'] ) && 'thumbnail' === $vars['orderby'] ) {
		$vars = array_merge( $vars, array(
			'meta_key' => 'link_image',
			'orderby'  => 'meta_value_num'
		) );
	}

	return $vars;
}

/**
 * Sort Links by thumbnail
 */
function link_manager_order( $links ) {
	if ( ! isset( $_GET['orderby'] ) ) {
		return $links;
	}

	global $current_screen;
	if ( $current_screen->id === 'link-manager' && $_GET['orderby'] === 'link_image' ) {
		$order = ( $_GET['order'] === 'asc' ) ? SORT_ASC : SORT_DESC;
		sort_on_field( $links, 'link_image', $order );

		return $links;
	}

	return $links;
}

/**
 *
 */
function print_admin_footer() {
	echo '<style>#thumbnail { max-width:20%; }</style>';
}


/**
 * Set content of important field that we are hiding
 *
 * @param $form_fields
 * @param $post
 *
 * @return array
 */
function remove_upload_fields( $form_fields, $post ) {
	if ( ! isset( $_GET['fli_type'] ) ) {
		return $form_fields;
	}

	$html = "<input type='hidden' name='attachments[" . $post->ID . "][url]' value='" . $post->guid . "'/>";

	$form_fields['url']['html']  = $html;
	$form_fields['url']['helps'] = '';
	$form_fields['url']['label'] = '';

	return $form_fields;
}

/*
 * Sort multidimensional array by stdClass
 */

function sort_on_field( &$db, $col, $order = SORT_ASC ) {
	$sort = array();
	foreach ( $db as $i => $obj ) {
		$sort[ $i ] = $obj->{$col};
	}
	$sorted_db = array_multisort( $sort, $order, $db );
}

/**
 * Adds the meta box container
 */
function add_fli_meta_box() {
	add_meta_box(
		'featured_link_image_meta_box'
		, __( 'Featured Link Image', 'fli' )
		, 'render_meta_box_content'
		, 'link'
		, 'side'
	);
}

/**
 * Render Meta Box content
 */
function render_meta_box_content() {
	global $link;

	$img        = ( isset( $link->link_image ) && '' !== $link->link_image ) ? '<img src="' . $link->link_image . '" class="link-featured-image">' : '';
	$class_hide = ( '' === $img ) ? 'hide-image-text' : '';
	$class_show = ( '' !== $img ) ? 'hide-image-text' : '';
	$spanimg    = sprintf( '<div id="my-link-img">%s</div>', $img );
	?>
	<table>
		<tr>
			<td>
                    <span class="link-help-text <?php echo $class_show; ?>">
                        <?php _e( 'After selecting/uploading, the image address will be inserted inside the Advanced->Image Address field.', 'fli' ); ?>
                    </span>
			</td>
		</tr>
		<tr>
			<td>
				<a id="upload_image_button" class="<?php echo $class_show; ?>" href="#">
					<?php _e( 'Set link image', 'fli' ); ?>
				</a>
			</td>
		</tr>
		<tr>
			<td><?php echo $spanimg; ?></td>
		</tr>
		<tr>
			<td>
				<a href="#" id="remove-image-text" class="<?php echo $class_hide; ?>">
					<?php _e( 'Remove image', 'fli' ); ?>
				</a>
			</td>
		</tr>
	</table>
	<?php
}
