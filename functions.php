<?php
/**
 * Theme functions and definitions.
 *
 * @package  xlthlx
 */

/**
 * Load vendors.
 */
require_once dirname( __FILE__ ) . '/vendor.phar';

add_filter( 'login_display_language_dropdown', '__return_false' );

/**
 * Set theme supports and image sizes.
 *
 * @return void
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
	add_image_size( 'sticky', 437, 225, true );
	add_image_size( 'cover', 250, 370, true );
}

add_action( 'init', 'xlthlx_add_supports' );

/**
 * Register main and footer menu.
 */
function xlthlx_register_menus() {
	register_nav_menus(
		array(
			'primary' => 'Main',
			'footer'  => 'Footer',
		)
	);
}

add_action( 'init', 'xlthlx_register_menus' );

/**
 * Register widget area.
 */
function xlthlx_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'xlthlx' ),
			'id'            => 'sidebar',
			'description'   => esc_html__( 'Sidebar', 'xlthlx' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s p-4">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="h2 pb-2 shadows">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Page Sidebar', 'xlthlx' ),
			'id'            => 'page_sidebar',
			'description'   => esc_html__( 'Page Sidebar', 'xlthlx' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s p-4">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="h2 pb-2 shadows">',
			'after_title'   => '</h3>',
		)
	);
}

add_action( 'widgets_init', 'xlthlx_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function xlthlx_scripts() {
	// Styles.
	wp_dequeue_style( 'wp-block-library' );
	wp_deregister_style('classic-theme-styles');
	wp_dequeue_style('classic-theme-styles');
	// Scripts.
	wp_deregister_script( 'wp-embed' );
	if ( 'http://localhost' !== home_url() && ! is_admin() ) {
		wp_deregister_script( 'jquery' );
	}
}

add_action( 'wp_enqueue_scripts', 'xlthlx_scripts' );

/**
 * Enqueue editor scripts.
 *
 * @return void
 */
function enqueue_editor_scripts() {
	wp_enqueue_script(
		'theme-editor',
		get_template_directory_uri() . '/assets/js/admin/editor.min.js',
		array( 'wp-blocks', 'wp-dom' ),
		filemtime( get_template_directory() . '/assets/js/admin/editor.min.js' ),
		true
	);
}

add_action( 'enqueue_block_editor_assets', 'enqueue_editor_scripts' );

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
		$site_url .= 'en/';
		$site_desc = 'Better than a cyber duck.';
	}

}

add_action( 'after_setup_theme', 'xlthlx_add_to_globals' );

/**
 * Adds the plausible scripts to header.
 *
 * @return void
 */
function xlt_add_to_header() {
	?>
	<?php // @codingStandardsIgnoreStart ?>
	<script id="stats" defer data-domain="xlthlx.com" src="https://plausible.io/js/script.outbound-links.file-downloads.hash.js"></script>
	<script>
		window.plausible = window.plausible || function () {
			(window.plausible.q = window.plausible.q || []).push(arguments)
		}
	</script>
	<?php // @codingStandardsIgnoreEnd ?>
	<?php
}

add_action( 'wp_head', 'xlt_add_to_header' );

/**
 * Adds to wp_footer.
 *
 * @return void
 */
function xlt_add_to_footer() {
	// @codingStandardsIgnoreStart ?>
<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono&family=Shadows+Into+Light&family=Titillium+Web&display=swap" rel="stylesheet">
<?php // @codingStandardsIgnoreEnd
}

add_action( 'wp_footer', 'xlt_add_to_footer', 100 );

if ( file_exists( dirname( __FILE__ ) . '/inc/cmb2/cmb2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/inc/cmb2/cmb2/init.php';
}

/**
 * Theme functions and tags.
 */
require_once 'inc/theme/index.php';

/**
 * Functions for English translation.
 */
require_once 'inc/eng/index.php';

/**
 * Film and TV Series.
 */
require_once 'inc/film-tv/index.php';

/**
 * Toolkit.
 */
require_once 'inc/toolkit/index.php';

/**
 * Newsletter.
 */
require_once 'inc/newsletter/index.php';
