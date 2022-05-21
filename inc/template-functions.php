<?php
/**
 * Functions which enhance the theme by hooking into WordPress.
 *
 * @package  WordPress
 * @subpackage  Xlthlx
 */

use Highlight\Highlighter;

/**
 * Removes WP Logo and comments in the admin bar.
 */
function xlt_remove_admin_bar_wp_logo() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_node( 'wp-logo' );
	$wp_admin_bar->remove_node( 'comments' );
}

add_action( 'wp_before_admin_bar_render', 'xlt_remove_admin_bar_wp_logo', 20 );

/**
 * Removes the version from the admin footer.
 *
 * @return void
 */
function xlt_admin_footer_remove() {
	remove_filter( 'update_footer', 'core_update_footer' );
}

add_action( 'admin_menu', 'xlt_admin_footer_remove' );

add_filter( 'pre_option_link_manager_enabled', '__return_true' );
add_filter( 'wpcf7_load_js', '__return_false' );
add_filter( 'wpcf7_load_css', '__return_false' );

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

add_filter( 'render_block', 'xlt_render_code_block', 10, 2 );

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

/**
 * Removes the comment-reply script.
 */
function xlt_remove_comment_reply() {
	wp_deregister_script( 'comment-reply' );
}

add_action( 'init', 'xlt_remove_comment_reply' );

/**
 * Remove the very annoying jQuery Migrate notice.
 */
function xlt_remove_jquery_migrate_notice() {
	$m                    = $GLOBALS['wp_scripts']->registered['jquery-migrate'];
	$m->extra['before'][] = 'xlt_logconsole = window.console.log; window.console.log=null;';
	$m->extra['after'][]  = 'window.console.log=xlt_logconsole;';
}

add_action( 'init', 'xlt_remove_jquery_migrate_notice', 5 );

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
	wp_enqueue_style( 'admin',
		get_template_directory_uri() . '/assets/css/admin/admin.min.css', [],
		filemtime( get_template_directory() . '/assets/css/admin/admin.min.css' ) );
	wp_enqueue_script( 'admin',
		get_template_directory_uri() . '/assets/js/admin/admin.min.js', [],
		filemtime( get_template_directory() . '/assets/js/admin/admin.min.js' ),
		true );
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

	if ( is_home() || is_front_page() ) {
		$lang = get_lang();
		if ( 'en' === $lang ) {
			$title = get_bloginfo( 'name' ) . ' | ' . 'Better than a cyber duck in the ass.';
		}
	}

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
	if ( is_home() || is_front_page() ) {
		$lang = get_lang();
		if ( 'en' === $lang ) {
			$description = 'xlthlx. Better than a cyber duck in the ass. Maybe.';
		}
	}

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

/**
 * Replace YouTube.com with the no cookie version.
 *
 * @param $html
 * @param $data
 * @param $url
 *
 * @return string
 */
function xlt_youtube_oembed_filters( $html, $data, $url ) {
	if ( false === $html || ! in_array( $data->type, [ 'rich', 'video' ],
			true ) ) {
		return $html;
	}

	if ( false !== strpos( $html, 'youtube' ) || false !== strpos( $html,
			'youtu.be' ) ) {
		$html = str_replace( 'youtube.com/embed', 'youtube-nocookie.com/embed',
			$html );
	}

	return $html;
}

add_filter( 'oembed_dataparse', 'xlt_youtube_oembed_filters', 99, 3 );

/**
 * Clean the oembed cache.
 *
 * @return int
 */
function xlt_clean_oembed_cache() {
	$GLOBALS['wp_embed']->usecache = 0;
	do_action( 'wpse_do_cleanup' );

	return 0;
}

add_filter( 'oembed_ttl', 'xlt_clean_oembed_cache' );

/**
 * Restore the oembed cache.
 *
 * @param $discover
 *
 * @return mixed
 */
function xlt_restore_oembed_cache( $discover ) {
	if ( 1 === did_action( 'wpse_do_cleanup' ) ) {
		$GLOBALS['wp_embed']->usecache = 1;
	}

	return $discover;
}

add_filter( 'embed_oembed_discover', 'xlt_restore_oembed_cache' );

/**
 * Insert minified CSS into header.
 *
 * @return void
 */
function xlt_insert_css() {
	$file  = get_template_directory() . '/assets/css/main.min.css';
	$style = str_replace( '../fonts/',
		get_template_directory_uri() . '/assets/fonts/',
		xlt_get_file_content( $file ) );

	echo '<style id="all-styles-inline">' . $style . '</style>';
}

add_action( 'wp_head', 'xlt_insert_css' );

/**
 * Add attributes to next post link.
 *
 * @param $link
 *
 * @return string
 */
function xlt_filter_next_post_link( $link ) {

	$title = 'Post successivo';

	if ( 'en' === get_lang() ) {
		$title = 'Next post';
		$url   = xlt_get_url_from_href( $link );

		$link = str_replace( $url, $url . 'en/', $link );
	}

	return str_replace( "rel=",
		'title="' . $title . '" class="display-5 arrow" rel=', $link );
}

add_filter( 'next_post_link', 'xlt_filter_next_post_link' );

/**
 * Add attributes to previous post link.
 *
 * @param $link
 *
 * @return string
 */
function xlt_filter_previous_post_link( $link ) {

	$title = 'Post precedente';

	if ( 'en' === get_lang() ) {
		$title = 'Previous post';
		$url   = xlt_get_url_from_href( $link );

		$link = str_replace( $url, $url . 'en/', $link );
	}

	return str_replace( "rel=",
		'title="' . $title . '" class="display-5 arrow" rel=', $link );
}

add_filter( 'previous_post_link', 'xlt_filter_previous_post_link' );

/**
 * Add a class to previous/next links.
 *
 * @param $html
 *
 * @return array|string|string[]
 */
function xlt_add_post_link( $html ) {
	return str_replace( '<a ', '<a class="text-decoration-none" ', $html );
}

add_filter( 'next_post_link', 'xlt_add_post_link' );
add_filter( 'previous_post_link', 'xlt_add_post_link' );

/**
 * Send 404 to Plausible.
 *
 * @return void
 */
function xlt_404_plausible() {
	if ( is_404() ) {
		?>
        <script>plausible("404", {props: {path: document.location.pathname}});</script>
		<?php
	}
}

add_action( 'wp_head', 'xlt_404_plausible' );

/**
 * Custom Admin colour scheme.
 *
 * @return void
 */
function xlt_admin_color_scheme() {

	$theme_dir = get_stylesheet_directory_uri();

	wp_admin_css_color( 'xlthlx', __( 'Xlthlx' ),
		$theme_dir . '/assets/css/admin/color-scheme.min.css',
		array( '#1e2327', '#fff', '#92285e', '#6667ab' ),
		array(
			'base'    => '#ffffff',
			'focus'   => '#92285e',
			'current' => '#ffffff'
		)
	);
}

add_action( 'admin_init', 'xlt_admin_color_scheme' );

/**
 * Create a menu separator.
 *
 * @param $position
 *
 * @return void
 */
function add_admin_menu_separator( $position ) {
	global $menu;
	$index = 0;
	foreach ( $menu as $offset => $section ) {
		if ( 0 === strpos( $section[2], 'separator' ) ) {
			$index ++;
		}
		if ( $offset >= $position ) {
			$menu[ $position ] = array(
				'',
				'read',
				"separator$index",
				'',
				'wp-menu-separator'
			);
			break;
		}
	}
	ksort( $menu );
}

/**
 * Move around some admin menu items.
 *
 * @return void
 */
function xlt_rearrange_admin_menu() {
	remove_menu_page( 'wp-tweets-pro' );
	remove_menu_page( 'edit-comments.php' );

	add_menu_page(
		'Twitter',
		'Twitter',
		'manage_options',
		'wp-tweets-pro',
		'',
		'dashicons-twitter',
		34
	);

	add_submenu_page(
		'edit.php',
		'Commenti',
		'Commenti',
		'edit_posts',
		'edit-comments.php',
		'',
		22
	);

	add_admin_menu_separator( 24 );
}

add_action( 'admin_menu', 'xlt_rearrange_admin_menu' );

/**
 * Hide SEO and description columns.
 *
 * @param $columns
 *
 * @return mixed
 */
function xlt_hide_seo_columns( $columns ) {
	unset( $columns['meta_title'], $columns['meta_description'], $columns['description'] );

	return $columns;
}

add_filter( 'manage_post_posts_columns', 'xlt_hide_seo_columns', 20 );
add_filter( 'manage_edit-category_columns', 'xlt_hide_seo_columns', 20 );