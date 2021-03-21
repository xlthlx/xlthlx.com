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

add_filter( 'render_block', 'xlt_render_code_block', 10, 2 );

/**
 * Modify the rendering of code Gutenberg block.
 *
 * @param $block_content
 * @param $block
 *
 * @return string
 * @throws Exception
 */
function xlt_render_code_block( $block_content, $block ) {
	if ( 'core/code' !== $block['blockName'] ) {
		return $block_content;
	}

	return xlt_render_code( $block_content );
}

/**
 * Renders the block type output for given attributes.
 *
 * @param string $content Optional. Block content. Default empty string.
 *
 * @return string Rendered block type output.
 * @throws Exception
 * @since 5.0.0
 */
function xlt_render_code( string $content ) {

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


add_action( 'init', 'xlt_remove_jquery_migrate_notice', 5 );

/**
 * Remove the very annoying jQuery Migrate notice.
 */
function xlt_remove_jquery_migrate_notice() {
	$m                    = $GLOBALS['wp_scripts']->registered['jquery-migrate'];
	$m->extra['before'][] = 'temp_jm_logconsole = window.console.log; window.console.log=null;';
	$m->extra['after'][]  = 'window.console.log=temp_jm_logconsole;';
}

