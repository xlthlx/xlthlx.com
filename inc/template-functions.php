<?php
/**
 * Functions which enhance the theme by hooking into WordPress.
 *
 * @package  WordPress
 * @subpackage  Xlthlx
 */

use Highlight\Highlighter;

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

add_action( 'after_setup_theme', 'xlt_render_code_block' );
/**
 * Modify the rendering of code Gutenberg block.
 */
function xlt_render_code_block() {
	register_block_type( 'core/code', array(
		'render_callback' => 'xlt_render_code',
	) );
}

/**
 * Renders the block type output for given attributes.
 *
 * @param array $attributes Optional. Block attributes. Default empty array.
 * @param string $content Optional. Block content. Default empty string.
 *
 * @return string Rendered block type output.
 * @throws Exception
 * @since 5.0.0
 */
function xlt_render_code( $attributes, string $content ) {

	$hl = new Highlighter();
	$hl->setAutodetectLanguages( array( 'php', 'javascript', 'html' ) );

	$content = str_replace( array(
		'<pre class="wp-block-code">',
		'<code>',
		'</code>',
		'</pre>'
	), '', html_entity_decode( $content ) );

	$highlighted = $hl->highlightAuto( trim( $content ) );

	if ( $highlighted ) {
		$content = '<pre class="wp-block-code"><code class="hljs ' . $highlighted->language . '">' . $highlighted->value . '</code></pre>';
		$content = apply_filters( 'the_content', $content );
	}

	return $content;
}

add_action( 'init', 'xlt_remove_comment_reply' );
/**
 * Removes the comment-reply script.
 */
function xlt_remove_comment_reply() {
	wp_deregister_script( 'comment-reply' );
}

/*add_action( 'admin_enqueue_scripts', 'my_enqueue' );

function my_enqueue() {

	wp_enqueue_script(
		'switch-lang-script',
		plugins_url( '/js/ajax.js', __FILE__ ),
		array( 'jquery' ),
		'',
		true
	);
	$switch_lang_nonce = wp_create_nonce( 'switch_lang_nonce' );
	wp_localize_script(
		'switch-lang-script',
		'switch_lang_obj',
		array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce'    => $switch_lang_nonce,
		)
	);
}

add_action( 'wp_ajax_switch_lang', 'xlt_get_page_content' );
add_action( 'wp_ajax_nopriv_switch_lang', 'xlt_get_page_content' );


function xlt_get_page_content() {
	check_ajax_referer( 'switch_lang_nonce' );

	$url = filter_var( $_REQUEST['url'] );

	if ( $url !== '' ) {
		$posts   = new Timber\PostQuery( array( 'p' => $url ) );
		$context = Timber::context();

		if ( $url === 'en' ) {
			$context['class_it'] = ' active';
			$context['class_en'] = '';

		} else {
			$context['class_it'] = '';
			$context['class_en'] = ' active';
		}

		$post = $posts[0];

		$context['post'] = $post;
		$context['lang'] = $url;

		$context['post']->title_en   = get_title_en();
		$context['post']->date_en    = get_date_en();
		$context['post']->content_en = get_content_en();

		Timber::render( 'ajax/content.twig', $context );
	} else {
		$context = Timber::context();
		Timber::render( '404.twig', $context );
	}

	wp_die();
}*/
