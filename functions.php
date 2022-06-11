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
$timber::$twig_cache = false;

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
		add_action( 'after_setup_theme', array( $this, 'add_image_size' ) );
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_editor_scripts' ) );
		add_filter( 'image_size_names_choose', array( $this, 'custom_size_name' ) );
		add_filter( 'login_display_language_dropdown', '__return_false' );
		parent::__construct();
	}

	/**
	 * General context.
	 *
	 * @param $context
	 *
	 * @return mixed
	 */
	public function add_to_context( $context ) {
		global $timber;

		$context['lang']                 = get_lang();
		$context['menu']                 = new Timber\Menu( 'primary' );
		$context['menu_footer']          = new Timber\Menu( 'footer' );
		$context['site']                 = $this;
		$context['site']->url_en         = $context['site']->url . '/en/';
		$context['site']->description_en = 'Better than a cyber duck in the ass.';
		$context['logged_in']            = is_user_logged_in();
		$context['is_home']              = is_home() || is_front_page();
		$context['current_user']         = new Timber\User();
		$context['sidebar']              = $timber::get_widgets( 'sidebar' );
		$context['page_sidebar']         = $timber::get_widgets( 'page_sidebar' );

		$this->set_en_menu_title( $context['menu']->items );
		$this->set_en_menu_title( $context['menu_footer']->items );

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
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'custom-spacing' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'html5', array(
			'comment-list',
			'comment-form',
			'search-form',
			'gallery',
			'caption',
			'style',
			'script'
		) );

		remove_theme_support( 'automatic-feed-links' );
		remove_theme_support( 'widgets-block-editor' );
		remove_theme_support( 'core-block-patterns' );
		remove_action( 'wp_head', 'feed_links_extra', 3 );
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
		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'wpt-twitter-feed' );
		// Scripts.
		if ( 'http://localhost' !== home_url() ) {
			wp_deregister_script( 'jquery' );
		}
		wp_deregister_script( 'wp-embed' );
		wp_enqueue_script( 'main',
			get_template_directory_uri() . '/assets/js/main.min.js', [],
			filemtime( get_template_directory() . '/assets/js/main.min.js' ),
			true );

		if ( is_singular( 'post' ) && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
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

	/**
	 * Add custom image size.
	 *
	 * @return void
	 */
	public function add_image_size() {
		add_image_size( 'extra_large', 1536, 1536 );
		add_image_size( 'extra_extra_large', 2048, 2048 );
		add_image_size( 'featured', 1200, 900, true );
		add_image_size( 'sticky', 437, 225, true );
		remove_image_size( '1536x1536' );
		remove_image_size( '2048x2048' );
	}

	/**
	 * Make image custom size selectable from WordPress admin.
	 *
	 * @param $sizes
	 *
	 * @return array
	 */
	public function custom_size_name( $sizes ) {
		return array_merge( $sizes, array(
			'featured' => __( 'Featured' ),
			'sticky'   => __( 'Sticky' ),
		) );
	}

	/**
	 * Enqueue editor scripts.
	 *
	 * @return void
	 */
	public function enqueue_editor_scripts() {
		wp_enqueue_script( 'theme-editor',
			get_template_directory_uri() . '/assets/js/admin/editor.min.js',
			[ 'wp-blocks', 'wp-dom' ],
			filemtime( get_template_directory() . '/assets/js/admin/editor.min.js' ),
			true );
	}

	public function set_en_menu_title( $items ) {

		if ( 'en' === get_lang() ) {
			foreach ( $items as $item ) {
				if ( get_title_en( $item->master_object->ID ) !== '' ) {
					$item->title = get_title_en( $item->master_object->ID );
				}
				if ( isset( $item->children ) ) {
					foreach ( $item->children as $child ) {
						if ( get_title_en( $child->master_object->ID ) !== '' ) {
							$child->title = get_title_en( $child->master_object->ID );
						}
					}
				}
			}
		}
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


function add_to_globals() {
	global $lang;
	$lang = get_lang();
}

add_action( 'after_setup_theme', 'add_to_globals' );
