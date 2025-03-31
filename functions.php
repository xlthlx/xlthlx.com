<?php
/**
 * Theme functions and definitions.
 *
 * @package  xlthlx
 */

/**
 * General setup.
 */
function xlt_setup() {
	add_filter( 'login_display_language_dropdown', '__return_false' );
	add_filter( 'enable_post_by_email_configuration', '__return_false' );
	add_filter( 'enable_update_services_configuration', '__return_false' );

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
	remove_theme_support( 'post-formats' );

	remove_action( 'wp_head', 'feed_links_extra', 3 );

	add_image_size( 'featured', 1200, 675, true );

	register_nav_menus(
		array(
			'primary' => 'Main',
			'footer'  => 'Footer',
			'topics'  => 'Topics',
			'stuff'   => 'Stuff',
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
	// CF7.
	if ( is_page( 'contatti' ) || is_page( 'newsletter' ) ) {
		if ( function_exists( 'wpcf7_enqueue_scripts' ) ) {
			wpcf7_enqueue_scripts();
		}

		if ( function_exists( 'wpcf7_enqueue_styles' ) ) {
			wpcf7_enqueue_styles();
		}
	}
}

add_action( 'wp_enqueue_scripts', 'xlt_enqueue_scripts' );

/**
 * Set up globals.
 *
 * @return void
 */
function xlt_add_to_globals() {
	global $charset, $site_url, $site_name, $site_desc;
	$charset   = get_bloginfo( 'charset' );
	$site_url  = home_url( '/' );
	$site_name = get_bloginfo( 'name' );
	$site_desc = get_bloginfo( 'description' );

	if ( function_exists( 'get_lang' ) ) {
		global $lang;
		$lang = get_lang();
		if ( 'en' === $lang ) {
			$site_url  = home_url( '/en/' );
			$site_name = get_option( 'english_title', '' );
			$site_desc = get_option( 'english_tagline', '' );
		}
	}

}

add_action( 'after_setup_theme', 'xlt_add_to_globals' );

/**
 * Enqueue login CSS.
 *
 * @return void
 */
function xlt_enqueue_login() {
	wp_dequeue_style( 'login' );
	wp_deregister_style( 'login' );

	wp_enqueue_style( 'custom-login', get_template_directory_uri() . '/assets/css/admin/login.min.css', array(), filemtime( get_template_directory() . '/assets/css/admin/login.min.css' ) );
	wp_enqueue_script( 'custom-script', get_template_directory_uri() . '/assets/js/admin/login.min.js', array(), filemtime( get_template_directory() . '/assets/js/admin/login.min.js' ), true );
}

add_action( 'login_enqueue_scripts', 'xlt_enqueue_login' );

/**
 * Enqueue js and css into admin.
 *
 * @return void
 */
function xlt_enqueue_admin_css_js() {
	wp_enqueue_style(
		'admin',
		get_template_directory_uri() . '/assets/css/admin/admin.min.css',
		array(),
		filemtime( get_template_directory() . '/assets/css/admin/admin.min.css' )
	);
	wp_enqueue_script(
		'admin',
		get_template_directory_uri() . '/assets/js/admin/admin.min.js',
		array(),
		filemtime( get_template_directory() . '/assets/js/admin/admin.min.js' ),
		true
	);
}

add_action( 'admin_enqueue_scripts', 'xlt_enqueue_admin_css_js' );

/**
 * This method gets the content of a given file.
 *
 * @param string $file_path The file path.
 *
 * @return  string Content of $file_path
 */
function xlt_get_asset_content( $file_path ) {

	global $wp_filesystem;
	require_once ABSPATH . '/wp-admin/includes/file.php';

	WP_Filesystem();
	$content = '';

	if ( $wp_filesystem->exists( $file_path ) ) {
		$content = $wp_filesystem->get_contents( $file_path );
	}

	return $content;

}

/**
 * Insert minified CSS into header.
 *
 * @return void
 */
function xlt_insert_css() {
	$file  = get_template_directory() . '/assets/css/main.min.css';
	$style = xlt_get_asset_content( $file );

	echo '<style id="all-styles-inline">' . $style . '</style>';
}

add_action( 'wp_head', 'xlt_insert_css' );

/**
 * Insert minified JS into footer.
 *
 * @return void
 */
function xlt_insert_scripts() {

	echo '<script type="text/javascript">const theme_url = "' . get_template_directory_uri() . '"; </script>';
	$file   = get_template_directory() . '/assets/js/main.min.js';
	$script = xlt_get_asset_content( $file );

	echo '<script id="all-scripts-inline" type="text/javascript">' . $script . '</script>';
}

add_action( 'wp_footer', 'xlt_insert_scripts' );
