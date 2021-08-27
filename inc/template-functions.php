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

/**
 * Comment Field Order.
 *
 * @param $fields
 *
 * @return array
 */
function xlt_comment_fields_custom_order( $fields ) {

	$comment_field = $fields['comment'];
	$author_field  = $fields['author'];
	$email_field   = $fields['email'];
	$url_field     = $fields['url'];

	unset( $fields['comment'], $fields['author'], $fields['email'], $fields['url'], $fields['cookies'] );

	$fields['author']  = $author_field;
	$fields['email']   = $email_field;
	$fields['url']     = $url_field;
	$fields['comment'] = $comment_field;

	return $fields;
}

add_filter( 'comment_form_fields', 'xlt_comment_fields_custom_order' );

/**
 * Redirect en comments to the correct url.
 *
 * @param $location
 * @param $comment_data
 *
 * @return mixed
 */
function xlt_en_comment_redirect( $location, $comment_data ) {
	if ( ! isset( $comment_data ) || empty( $comment_data->comment_post_ID ) ) {
		return $location;
	}

	if ( isset( $_POST['en_redirect_to'] ) ) {
		$location = get_permalink( $comment_data->comment_post_ID ) . "en/#comment-" . $comment_data->comment_ID;
	}

	return $location;
}

add_filter( 'comment_post_redirect', 'xlt_en_comment_redirect', 10, 2 );

/**
 * Enqueue js and css into admin.
 */
function xlt_enqueue_admin_css_js() {
	wp_enqueue_style( 'admin', get_template_directory_uri() . '/assets/css/admin/admin.css', [], filemtime( get_template_directory() . '/assets/css/admin/admin.css' ) );
	wp_enqueue_script( 'admin', get_template_directory_uri() . '/assets/js/admin/admin.js', [], '', true );
}

add_action( 'admin_enqueue_scripts', 'xlt_enqueue_admin_css_js' );

/**
 * Change the meta title based on language.
 *
 * @param $title
 *
 * @return mixed|string
 */
function xlt_en_title( $title ) {
	if ( is_single() ) {
		$lang = get_lang();
		if ( 'en' === $lang ) {
			$title = get_title_en() . ' | ' . get_bloginfo( 'name' );
		}
	}

	return $title;
}

add_filter( 'slim_seo_meta_title', 'xlt_en_title' );

/**
 * Change the meta description based on language.
 *
 * @param $description
 *
 * @return mixed|string
 * @throws Exception
 */
function xlt_en_description( $description ) {
	if ( is_single() ) {
		$lang = get_lang();
		if ( 'en' === $lang ) {
			$description = wp_trim_excerpt( get_content_en() );
		}
	}

	return $description;
}

add_filter( 'slim_seo_meta_description', 'xlt_en_description' );

/**
 * Hide SEO settings meta box for posts.
 */
function xlt_hide_slim_seo_meta_box() {
	$context = apply_filters( 'slim_seo_meta_box_context', 'normal' );
	remove_meta_box( 'slim-seo', null, $context );
}

add_action( 'add_meta_boxes', 'xlt_hide_slim_seo_meta_box', 20 );

/**
 * Change the title separator.
 *
 * @return string
 */
function xlt_document_title_separator() {
	return "|";
}

add_filter( 'document_title_separator', 'xlt_document_title_separator' );

/**
 * Removes tags from blog posts.
 */
function xlt_unregister_tags() {
	unregister_taxonomy_for_object_type( 'post_tag', 'post' );
}

add_action( 'init', 'xlt_unregister_tags' );


