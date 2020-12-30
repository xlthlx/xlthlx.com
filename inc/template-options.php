<?php
/**
 * Theme options page.
 * Based on CMB2: see vendor/cmb2/cmb2/example-functions.php
 *
 * @package  WordPress
 * @subpackage  Xlthlx
 */

/**
 * Callback to define the options saved message.
 *
 * @param CMB2 $cmb The CMB2 object.
 * @param array $args An array of message arguments
 */
function xlt_options_page_message_callback( CMB2 $cmb, array $args ) {
	if ( ! empty( $args['should_notify'] ) ) {

		if ( $args['is_updated'] ) {

			// Modify the updated message.
			$args['message'] = sprintf( esc_html__( '%s &mdash; Updated!', 'cmb2' ), $cmb->prop( 'title' ) );
		}

		add_settings_error( $args['setting'], $args['code'], $args['message'], $args['type'] );
	}
}

/**
 * Hook in and register a metabox to handle a theme options page and adds a menu item.
 */
function xlt_register_theme_options() {
	$cmb_options = new_cmb2_box( array(
		'id'           => 'xlt_theme_options_page',
		'title'        => esc_html__( 'Theme Options', 'cmb2' ),
		'object_types' => array( 'options-page' ),
		'option_key'   => 'xlt_theme_options',
		'icon_url'     => 'dashicons-palmtree',
		'menu_title'   => esc_html__( 'Options', 'cmb2' ),
		'capability'   => 'manage_options',
		'save_button'  => esc_html__( 'Save Theme Options', 'cmb2' ),
		'message_cb'   => 'xlt_options_page_message_callback',
	) );

	$cmb_options->add_field( array(
		'name'    => esc_html__( 'Site Background Color', 'cmb2' ),
		'desc'    => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'      => 'bg_color',
		'type'    => 'colorpicker',
		'default' => '#ffffff',
	) );

}

add_action( 'cmb2_admin_init', 'xlt_register_theme_options' );
