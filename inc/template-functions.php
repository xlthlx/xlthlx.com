<?php
/**
 * Functions which enhance the theme by hooking into WordPress.
 *
 * @package  WordPress
 * @subpackage  Xlthlx
 */

add_action( 'admin_menu', 'xlt_remove_menu_pages', 999 );
/**
 * Removes annoying submenus.
 */
function xlt_remove_menu_pages() {
	remove_submenu_page( 'aioseo', 'https://aioseo.com/lite-upgrade/?utm_source=WordPress&#038;utm_campaign=liteplugin&#038;utm_medium=admin-menu' );
}

add_action( 'wp_before_admin_bar_render', 'xlt_remove_admin_bar_wp_logo', 20 );
/**
 * Removes WP Logo, comments and SEO in the admin bar.
 */
function xlt_remove_admin_bar_wp_logo() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_node( 'wp-logo' );
	$wp_admin_bar->remove_node( 'view-site' );
	$wp_admin_bar->remove_node( 'comments' );
	$wp_admin_bar->remove_node( 'aioseo-main' );
}

add_filter( 'pre_option_link_manager_enabled', '__return_true' );
add_filter( 'wpcf7_load_js', '__return_false' );
add_filter( 'wpcf7_load_css', '__return_false' );


