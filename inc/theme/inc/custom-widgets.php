<?php
/**
 * Custom widget register.
 *
 * @package  xlthlx
 */

/**
 * Register Widgets.
 */
function xlt_register_widget() {

	register_widget( 'Archive_Widget' );
	register_widget( 'Coffee_Widget' );
	register_widget( 'Images_Widget' );
	register_widget( 'Newsletter_Widget' );
	register_widget( 'Related_Widget' );

}

add_action( 'widgets_init', 'xlt_register_widget' );
