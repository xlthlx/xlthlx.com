<?php
/**
 * Functions which enhance the theme by hooking into WordPress.
 *
 * @package  xlthlx
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

add_action( 'wp_before_admin_bar_render','xlt_remove_admin_bar_wp_logo',20 );

/**
 * Removes the version from the admin footer.
 *
 * @return void
 */
function xlt_admin_footer_remove() {
	remove_filter( 'update_footer','core_update_footer' );
}

add_action( 'admin_menu','xlt_admin_footer_remove' );

add_filter( 'pre_option_link_manager_enabled','__return_true' );
add_filter( 'wpcf7_load_js','__return_false' );
add_filter( 'wpcf7_load_css','__return_false' );

/**
 * Modify the rendering of code Gutenberg block.
 *
 * @param $block_content
 * @param $block
 *
 * @return string
 * @throws Exception
 */
function xlt_render_code_block( $block_content,$block ) {
	if ( 'core/code' !== $block['blockName'] ) {
		return $block_content;
	}

	return xlt_render_code( $block_content );
}

add_filter( 'render_block','xlt_render_code_block',10,2 );

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
	$hl->setAutodetectLanguages( [ 'php','javascript','html' ] );

	$content = str_replace( [
		'<pre class="wp-block-code">',
		'<code>',
		'</code>',
		'</pre>'
	],'',html_entity_decode( $content ) );

	$highlighted = $hl->highlightAuto( trim( $content ) );

	if ( $highlighted ) {
		$content = '<pre class="wp-block-code"><code class="hljs ' . $highlighted->language . '">' . $highlighted->value . '</code></pre>';
		$content = apply_filters( 'the_content',$content );
	}

	return $content;
}

/**
 * Removes the comment-reply script.
 */
function xlt_remove_comment_reply() {
	wp_deregister_script( 'comment-reply' );
}

add_action( 'init','xlt_remove_comment_reply' );

/**
 * Remove the very annoying jQuery Migrate notice.
 */
function xlt_remove_jquery_migrate_notice() {
	$m                    = $GLOBALS['wp_scripts']->registered['jquery-migrate'];
	$m->extra['before'][] = 'xlt_logconsole = window.console.log; window.console.log=null;';
	$m->extra['after'][]  = 'window.console.log=xlt_logconsole;';
}

add_action( 'init','xlt_remove_jquery_migrate_notice',5 );

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

	unset( $fields['comment'],$fields['author'],$fields['email'],$fields['url'],$fields['cookies'] );

	$fields['author']  = $author_field;
	$fields['email']   = $email_field;
	$fields['url']     = $url_field;
	$fields['comment'] = $comment_field;

	return $fields;
}

add_filter( 'comment_form_fields','xlt_comment_fields_custom_order' );

/**
 * Redirect en comments to the correct url.
 *
 * @param $location
 * @param $comment_data
 *
 * @return mixed
 */
function xlt_en_comment_redirect( $location,$comment_data ) {
	if ( ! isset( $comment_data ) || empty( $comment_data->comment_post_ID ) ) {
		return $location;
	}

	if ( isset( $_POST['en_redirect_to'] ) ) {
		$location = get_permalink( $comment_data->comment_post_ID ) . "en/#comment-" . $comment_data->comment_ID;
	}

	return $location;
}

add_filter( 'comment_post_redirect','xlt_en_comment_redirect',10,2 );

/**
 * Enqueue js and css into admin.
 */
function xlt_enqueue_admin_css_js() {
	wp_enqueue_style( 'admin',
		get_template_directory_uri() . '/assets/css/admin/admin.min.css',[],
		filemtime( get_template_directory() . '/assets/css/admin/admin.min.css' ) );
	wp_enqueue_script( 'admin',
		get_template_directory_uri() . '/assets/js/admin/admin.min.js',[],
		filemtime( get_template_directory() . '/assets/js/admin/admin.min.js' ),
		true );
}

add_action( 'admin_enqueue_scripts','xlt_enqueue_admin_css_js' );

/**
 * Hide SEO settings meta box for posts.
 */
function xlt_hide_slim_seo_meta_box() {
	$context = apply_filters( 'slim_seo_meta_box_context','normal' );
	remove_meta_box( 'slim-seo',null,$context );
}

add_action( 'add_meta_boxes','xlt_hide_slim_seo_meta_box',20 );

/**
 * Change the title separator.
 *
 * @return string
 */
function xlt_document_title_separator() {
	return "|";
}

add_filter( 'document_title_separator','xlt_document_title_separator' );

/**
 * Removes tags from blog posts.
 */
function xlt_unregister_tags() {
	unregister_taxonomy_for_object_type( 'post_tag','post' );
}

add_action( 'init','xlt_unregister_tags' );

/**
 * Replace YouTube.com with the no cookie version.
 *
 * @param $html
 * @param $data
 * @param $url
 *
 * @return string
 */
function xlt_youtube_oembed_filters( $html,$data,$url ) {
	if ( false === $html || ! in_array( $data->type,[ 'rich','video' ],
			true ) ) {
		return $html;
	}

	if ( false !== strpos( $html,'youtube' ) || false !== strpos( $html,
			'youtu.be' ) ) {
		$html = str_replace( 'youtube.com/embed','youtube-nocookie.com/embed',
			$html );
	}

	return $html;
}

add_filter( 'oembed_dataparse','xlt_youtube_oembed_filters',99,3 );

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

add_filter( 'oembed_ttl','xlt_clean_oembed_cache' );

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

add_filter( 'embed_oembed_discover','xlt_restore_oembed_cache' );

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

add_action( 'wp_head','xlt_insert_css' );

/**
 * Insert minified JS into footer.
 *
 * @return void
 */
function xlt_insert_scripts() {
	$file   = get_template_directory() . '/assets/js/main.min.js';
	$script = xlt_get_file_content( $file );

	echo '<script type="text/javascript">' . $script . '</script>';
}

add_action( 'wp_footer','xlt_insert_scripts' );

/**
 * Add a class to previous/next links.
 *
 * @param $html
 *
 * @return array|string|string[]
 */
function xlt_add_post_link( $html ) {
	return str_replace( '<a ','<a class="text-decoration-none" ',$html );
}

add_filter( 'next_post_link','xlt_add_post_link' );
add_filter( 'previous_post_link','xlt_add_post_link' );

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

add_action( 'wp_head','xlt_404_plausible' );

/**
 * Custom Admin colour scheme.
 *
 * @return void
 */
function xlt_admin_color_scheme() {

	$theme_dir = get_stylesheet_directory_uri();

	wp_admin_css_color( 'xlthlx',__( 'Xlthlx' ),
		$theme_dir . '/assets/css/admin/color-scheme.min.css',
		[ '#1e2327','#fff','#92285e','#6667ab' ],
		[
			'base'    => '#ffffff',
			'focus'   => '#92285e',
			'current' => '#ffffff'
		]
	);
}

add_action( 'admin_init','xlt_admin_color_scheme' );

/**
 * Create a menu separator.
 *
 * @param $position
 *
 * @return void
 */
function xlt_add_admin_menu_separator( $position ) {
	global $menu;
	$index = 0;
	foreach ( $menu as $offset => $section ) {
		if ( 0 === strpos( $section[2],'separator' ) ) {
			$index ++;
		}
		if ( $offset >= $position ) {
			$menu[ $position ] = [
				'',
				'read',
				"separator$index",
				'',
				'wp-menu-separator'
			];
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

	xlt_add_admin_menu_separator( 24 );
}

add_action( 'admin_menu','xlt_rearrange_admin_menu' );

/**
 * Hide SEO and description columns.
 *
 * @param $columns
 *
 * @return mixed
 */
function xlt_hide_seo_columns( $columns ) {
	unset( $columns['meta_title'],$columns['meta_description'],$columns['description'] );

	return $columns;
}

add_filter( 'manage_post_posts_columns','xlt_hide_seo_columns',20 );
add_filter( 'manage_edit-category_columns','xlt_hide_seo_columns',20 );


/** Add sources with webp.
 *
 * @param $attachment_id
 * @param $size
 * @param $type
 * @param $html
 *
 * @return string
 */
function xlt_get_sources_for_image( $attachment_id,$size,$type,$html ) {
	$img_src  = wp_get_attachment_image_url( $attachment_id,$size );
	$webp_src = preg_replace( '/(?:jpg|png|jpeg)$/i','webp',$img_src );

	return '<picture>
			  <source srcset="' . $webp_src . '" type="image/webp">
			  <source srcset="' . $img_src . '" type="' . $type . '">
			  ' . $html . '
			</picture>';
}

/**
 * Wrap the image with picture tag to support webp.
 *
 * @param $html
 * @param $attachment_id
 * @param $size
 * @param $icon
 * @param $attr
 *
 * @return mixed|string
 */
function xlt_wrap_image_with_picture( $html,$attachment_id,$size,$icon,$attr ) {
	if ( is_admin() ) {
		return $html;
	}

	$type = get_post_mime_type( $attachment_id );

	if ( $type !== 'image/gif' ) {
		$html = xlt_get_sources_for_image( $attachment_id,$size,$type,$html );
	}

	return $html;
}

add_filter( 'wp_get_attachment_image','xlt_wrap_image_with_picture',10,5 );

/**
 * Wrap the image with picture tag to support webp.
 *
 * @param $html
 * @param $context
 * @param $attachment_id
 *
 * @return mixed|string
 */
function xlt_image_with_picture( $html,$context,$attachment_id ) {
	if ( is_admin() ) {
		return $html;
	}

	$type = get_post_mime_type( $attachment_id );

	if ( $type !== 'image/gif' ) {

		preg_match( '/width="([^"]+)/i',$html,$width,PREG_OFFSET_CAPTURE );
		preg_match( '/height="([^"]+)/i',$html,$height,PREG_OFFSET_CAPTURE );
		if ( isset( $width[1], $height[1] ) ) {
			$size = [ $width[1][0], $height[1][0] ];
		} else {
			$size = 'full';
		}

		$html = xlt_get_sources_for_image( $attachment_id,$size,$type,$html );
	}

	return $html;
}

add_filter( 'wp_content_img_tag','xlt_image_with_picture',10,3 );

/**
 * Add icons into admin.
 *
 * @return void
 */
function xlt_add_admin_icons() { ?>
	<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/img/icons/favicon.ico"
		  sizes="any"><!-- 32×32 -->
	<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/img/icons/icon.svg" type="image/svg+xml">
	<link rel="apple-touch-icon"
		  href="<?php echo get_template_directory_uri(); ?>/assets/img/icons/apple-touch-icon.png">
<?php }

add_action( 'login_head','xlt_add_admin_icons' );
add_action( 'admin_head','xlt_add_admin_icons' );

/**
 * Add column Description.
 */
function xlt_add_remove_link_columns( $link_columns ) {

	$link_columns['link_description'] = 'Descrizione';

	unset( $link_columns['rel'],$link_columns['rating'],$link_columns['visible'] );

	return $link_columns;
}

/**
 * Display column content.
 *
 * @param $column_name
 * @param $id
 *
 * @return void
 */
function xlt_add_link_columns_data( $column_name,$id ) {

	if ( $column_name === 'link_description' ) {
		$val = get_bookmark_field( 'link_description',$id );
		if ( empty( $val ) ) {
			return;
		}

		echo $val;
	}
}

/**
 * All hooks for custom columns.
 */
function xlt_setup_columns() {
	add_filter( 'manage_link-manager_columns','xlt_add_remove_link_columns' );
	add_action( 'manage_link_custom_column','xlt_add_link_columns_data',10,2 );
}

add_action( 'load-link-manager.php','xlt_setup_columns' );
