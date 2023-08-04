<?php
/**
 * Theme functions and definitions.
 *
 * @package  xlthlx
 */

/**
 * Load vendors.
 */
require_once get_template_directory() . '/vendor.phar';

/**
 * General setup.
 */
function xlt_setup() {
	add_filter( 'login_display_language_dropdown', '__return_false' );
	add_filter( 'wpcf7_load_js', '__return_false' );
	add_filter( 'wpcf7_load_css', '__return_false' );
	add_filter( 'enable_post_by_email_configuration', '__return_false' );

	add_filter( 'pre_option_link_manager_enabled', '__return_true' );

	add_theme_support( 'block-templates' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'custom-spacing' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support(
		'html5',
		array(
			'comment-list',
			'comment-form',
			'search-form',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	remove_theme_support( 'automatic-feed-links' );
	remove_theme_support( 'widgets-block-editor' );

	remove_action( 'wp_head', 'feed_links_extra', 3 );

	add_image_size( 'featured', 1200, 675, true );

	register_nav_menus(
		array(
			'primary' => 'Main',
			'footer'  => 'Footer',
		)
	);
}

add_action( 'init', 'xlt_setup' );

/**
 * Register widget area.
 */
function xlt_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Post Sidebar', 'xlthlx' ),
			'id'            => 'post-sidebar',
			'description'   => esc_html__( 'Post Sidebar', 'xlthlx' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<p class="xlt-widget__title"><span>',
			'after_title'   => '</span></p>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Page Sidebar', 'xlthlx' ),
			'id'            => 'page-sidebar',
			'description'   => esc_html__( 'Page Sidebar', 'xlthlx' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<p class="xlt-widget__title"><span>',
			'after_title'   => '</span></p>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Sidebar Left', 'xlthlx' ),
			'id'            => 'footer-sidebar-left',
			'description'   => esc_html__( 'Footer Sidebar Left', 'xlthlx' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<p class="xlt-widget__title"><span>',
			'after_title'   => '</span></p>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Sidebar Center', 'xlthlx' ),
			'id'            => 'footer-sidebar-center',
			'description'   => esc_html__( 'Footer Sidebar Center', 'xlthlx' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<p class="xlt-widget__title"><span>',
			'after_title'   => '</span></p>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Sidebar Right', 'xlthlx' ),
			'id'            => 'footer-sidebar-right',
			'description'   => esc_html__( 'Footer Sidebar Right', 'xlthlx' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<p class="xlt-widget__title"><span>',
			'after_title'   => '</span></p>',
		)
	);
}

add_action( 'widgets_init', 'xlt_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function xlt_enqueue_scripts() {
	// Styles.
	wp_dequeue_style( 'wp-block-library' );
	wp_deregister_style( 'classic-theme-styles' );
	wp_dequeue_style( 'classic-theme-styles' );
	// Scripts.
	wp_deregister_script( 'wp-embed' );
	if ( 'http://localhost:1050' !== home_url() && ! is_admin() ) {
		wp_deregister_script( 'jquery' );
		wp_deregister_script( 'wp-polyfill' );
	}
	wp_deregister_script( 'comment-reply' );
}

add_action( 'wp_enqueue_scripts', 'xlt_enqueue_scripts' );

/**
 * Set up globals.
 *
 * @return void
 */
function xlt_add_to_globals() {
	global $lang,$charset,$site_url,$site_name,$site_desc;
	$lang      = get_lang();
	$charset   = get_bloginfo( 'charset' );
	$site_url  = home_url( '/' );
	$site_name = get_bloginfo( 'name' );
	$site_desc = get_bloginfo( 'description' );

	if ( 'en' === $lang ) {
		$site_url .= 'en/';
		$site_desc = get_option( 'english_tagline', '' );
	}

}

add_action( 'after_setup_theme', 'xlt_add_to_globals' );

if ( file_exists( get_template_directory() . '/inc/cmb2/cmb2/init.php' ) ) {
	require_once get_template_directory() . '/inc/cmb2/cmb2/init.php';
}

/**
 * Theme functions and tags.
 */
require_once get_template_directory() . '/inc/theme/index.php';

/**
 * Functions for English translation.
 */
require_once get_template_directory() . '/inc/eng/index.php';

/**
 * Toolkit.
 */
require_once get_template_directory() . '/inc/toolkit/index.php';

/**
 * Newsletter.
 */
require_once get_template_directory() . '/inc/newsletter/index.php';
