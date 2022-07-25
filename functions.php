<?php
/**
 * xlthlx functions and definitions.
 *
 * @package  xlthlx
 */

/**
 * Load vendors.
 */
require_once __DIR__ . '/vendor.phar';

add_filter( 'login_display_language_dropdown','__return_false' );

/*
 * Set theme supports and image sizes.
 */
function xlthlx_add_supports() {

	add_theme_support( 'block-templates' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'custom-spacing' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'html5',[
		'comment-list',
		'comment-form',
		'search-form',
		'gallery',
		'caption',
		'style',
		'script'
	] );

	remove_theme_support( 'automatic-feed-links' );
	remove_theme_support( 'widgets-block-editor' );

	remove_action( 'wp_head','feed_links_extra',3 );

	add_image_size( 'featured',1200,675,true );
	add_image_size( 'sticky',437,225,true );
	add_image_size( 'cover',250,370,true );
}

add_action( 'init','xlthlx_add_supports' );

/**
 * Register main and footer menu.
 */
function xlthlx_register_menus() {
	register_nav_menus(
		[
			'primary' => 'Main',
			'footer'  => 'Footer',
		]
	);
}

add_action( 'init','xlthlx_register_menus' );

/**
 * Register widget area.
 */
function xlthlx_widgets_init() {
	register_sidebar( [
		'name'          => esc_html__( 'Sidebar','xlthlx' ),
		'id'            => 'sidebar',
		'description'   => esc_html__( 'Sidebar','xlthlx' ),
		'before_widget' => '<div id="%1$s" class="widget widget_grey %2$s p-4 mb-4 rounded-0">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="h2 pb-2 shadows">',
		'after_title'   => '</h3>',
	] );

	register_sidebar( [
		'name'          => esc_html__( 'Page Sidebar','xlthlx' ),
		'id'            => 'page_sidebar',
		'description'   => esc_html__( 'Page Sidebar','xlthlx' ),
		'before_widget' => '<div id="%1$s" class="widget widget_grey %2$s p-4 mb-4 rounded-0">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="h2 pb-2 shadows">',
		'after_title'   => '</h3>',
	] );
}

add_action( 'widgets_init','xlthlx_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function xlthlx_scripts() {
	// Styles.
	wp_dequeue_style( 'wp-block-library' );
	// Scripts.
	if ( 'http://localhost' !== home_url() && ! is_admin() ) {
		wp_deregister_script( 'jquery' );
	}

	wp_deregister_script( 'wp-embed' );
}

add_action( 'wp_enqueue_scripts','xlthlx_scripts' );

/**
 * Enqueue editor scripts.
 *
 * @return void
 */
function enqueue_editor_scripts() {
	wp_enqueue_script( 'theme-editor',
		get_template_directory_uri() . '/assets/js/admin/editor.min.js',
		[ 'wp-blocks','wp-dom' ],
		filemtime( get_template_directory() . '/assets/js/admin/editor.min.js' ),
		true );
}

add_action( 'enqueue_block_editor_assets','enqueue_editor_scripts' );

/**
 * Set up globals.
 *
 * @return void
 */
function xlthlx_add_to_globals() {
	global $lang,$charset,$site_url,$site_name,$site_desc;
	$lang      = get_lang();
	$charset   = get_bloginfo( 'charset' );
	$site_url  = home_url( '/' );
	$site_name = get_bloginfo( 'name' );
	$site_desc = get_bloginfo( 'description' );

	if ( 'en' === $lang ) {
		$site_url  .= 'en/';
		$site_desc = 'Better than a cyber duck in the ass.';
	}

}

add_action( 'after_setup_theme','xlthlx_add_to_globals' );

if ( file_exists( __DIR__ . '/inc/cmb2/cmb2/init.php' ) ) {
	require_once __DIR__ . '/inc/cmb2/cmb2/init.php';
}

/**
 * Custom login.
 */
require_once 'inc/custom-login.php';

/**
 * Custom widgets.
 */
require_once 'inc/custom-widgets.php';

/**
 * Custom fields for English.
 */
require_once 'inc/eng-fields-admin.php';

/**
 * Frontend functions for English translation.
 */
require_once 'inc/eng-fields-frontend.php';

/**
 * Template (rewrite) functions for English translation.
 */
require_once 'inc/eng-fields-template.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require_once 'inc/template-functions.php';

/**
 * Post types.
 */
require_once 'inc/custom-post-types.php';

/**
 * Taxonomies.
 */
require_once 'inc/custom-taxonomies.php';

/**
 * Custom template tags.
 */
require_once 'inc/template-tags.php';

/**
 * Toolkit.
 */
require_once 'inc/toolkit/toolkit.php';

/**
 * Newsletter.
 */
require_once 'inc/newsletter/newsletter.php';

/**
 * Minify HTML.
 */
require_once 'inc/minify-html.php';

/**
 * Dashboard widgets.
 */
require_once 'inc/dashboard-widgets.php';
