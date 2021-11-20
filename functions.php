<?php
/**
 * Core functionalities.
 *
 * @package  WordPress
 * @subpackage  Xlthlx
 */

/**
 * Load vendors.
 */
require_once __DIR__ . '/vendor.phar';

/**
 * Initialise Timber.
 */
$timber              = new Timber\Timber();
$timber::$dirname    = array( 'views' );
$timber::$autoescape = false;

/**
 * Subclass of Timber\Site to init the theme.
 */
class xlthlxSite extends Timber\Site {
	/** Add timber support. */
	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'init', array( $this, 'register_menus' ) );
		add_filter( 'timber/context', array( $this, 'add_to_context' ) );
		add_action( 'widgets_init', array( $this, 'widgets_init' ) );
		parent::__construct();
	}

	/** General context.
	 *
	 * @return string
	 */
	public function add_to_context( $context ) {
		global $timber;

		$context['menu']             = new Timber\Menu( 'primary' );
		$context['menu_footer']      = new Timber\Menu( 'footer' );
		$context['site']             = $this;
		$context['site']->login_url  = wp_login_url( get_permalink() );
		$context['site']->logout_url = wp_logout_url( $context['site']->url );
		$context['logged_in']        = is_user_logged_in();
		$context['is_home']          = is_home() || is_front_page();
		$context['current_user']     = new Timber\User();
		$context['sidebar']          = $timber::get_widgets( 'sidebar' );
		$context['page_sidebar']     = $timber::get_widgets( 'page_sidebar' );

		return $context;
	}

	/**
	 * Registers theme support.
	 */
	public function theme_supports() {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'editor-styles' );
		add_theme_support( 'custom-spacing' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script' ) );
		remove_theme_support( 'automatic-feed-links' );
		remove_theme_support( 'widgets-block-editor' );
	}

	/**
	 * Register main and footer menu.
	 */
	public function register_menus() {
		register_nav_menus(
			[
				'primary' => 'Main',
				'footer'  => 'Footer',
			]
		);
	}

	/**
	 * Enqueue scripts and styles.
	 */
	public function enqueue_scripts() {
		// Styles.
		wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/vendor/twbs/bootstrap/dist/css/bootstrap.css' );
		wp_enqueue_style( 'main', get_template_directory_uri() . '/assets/css/main.css' );

		// Scripts.
		//wp_deregister_script( 'jquery' );
		wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/vendor/twbs/bootstrap/dist/js/bootstrap.bundle.js', [], false, true );

		// Service worker.
		wp_enqueue_script( 'service-worker', get_template_directory_uri() . '/assets/js/sw.js', [], false, true );

		if ( is_singular() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		if ( is_singular() ) {
			wp_enqueue_style( 'highlight', get_template_directory_uri() . '/assets/css/highlight.css' );
			wp_enqueue_script( 'badge', get_template_directory_uri() . '/assets/js/badge.js', [], false, true );
			wp_enqueue_script( 'single', get_template_directory_uri() . '/assets/js/single.js', [], false, true );
		}
	}

	/**
	 * Register widget areas and custom widgets.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
	 */
	public function widgets_init() {

		register_sidebar( array(
			'name'          => esc_html__( 'Sidebar', 'xlthlx' ),
			'id'            => 'sidebar',
			'description'   => esc_html__( 'Sidebar', 'xlthlx' ),
			'before_widget' => '<div id="%1$s" class="widget widget_grey %2$s p-4 mb-4 rounded-0">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="font-italic pb-2">',
			'after_title'   => '</h4>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Page Sidebar', 'xlthlx' ),
			'id'            => 'page_sidebar',
			'description'   => esc_html__( 'Page Sidebar', 'xlthlx' ),
			'before_widget' => '<div id="%1$s" class="widget widget_grey %2$s p-4 mb-4 rounded-0">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="font-italic pb-2">',
			'after_title'   => '</h4>',
		) );
	}

}

new xlthlxSite();

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
 * Custom fields for English template.
 */
require_once 'inc/eng-fields-template.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require_once 'inc/template-functions.php';

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
