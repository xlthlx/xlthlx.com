<?php
/**
 * Functions which enhance the theme by hooking into WordPress.
 *
 * @package  xlthlx
 */

// @codingStandardsIgnoreStart
use Highlight\Highlighter;

// @codingStandardsIgnoreEnd

/**
 * Removes WP Logo and comments in the admin bar.
 *
 * @return void
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

/**
 * Remove the Thank you text in the admin footer.
 *
 * @return string The content that will be printed.
 */
function xlt_custom_admin_footer_text() {
	return '';
}
add_filter( 'admin_footer_text', 'xlt_custom_admin_footer_text' );

/**
 * Modify the rendering of code Gutenberg block.
 *
 * @param string $block_content The block content.
 * @param array $block The full block, including name and attributes.
 *
 * @return string
 * @throws Exception Exception.
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
 * @throws Exception Exception.
 */
function xlt_render_code( $content ) {

	$hl = new Highlighter();
	$hl->setAutodetectLanguages( array( 'php', 'javascript', 'html' ) );

	$content = str_replace(
		array(
			'<pre class="wp-block-code">',
			'<code>',
			'</code>',
			'</pre>',
		),
		'',
		html_entity_decode( $content, ENT_COMPAT, 'UTF-8' )
	);

	$highlighted = $hl->highlightAuto( trim( $content ) );

	if ( $highlighted ) {
		$content = '<pre class="wp-block-code"><code class="hljs ' . $highlighted->language . '">' . $highlighted->value . '</code></pre>';
		$content = apply_filters( 'the_content', $content );
	}

	return $content;
}

/**
 * Comment Field Order.
 *
 * @param array $fields The comment fields.
 *
 * @return array
 */
function xlt_comment_fields_custom_order( $fields ) {

	$comment_field = $fields['comment'];
	$author_field  = $fields['author'];
	$email_field   = $fields['email'];
	$url_field     = $fields['url'];

	unset( $fields['comment'], $fields['author'], $fields['email'], $fields['url'], $fields['cookies'] );

	$fields['comment'] = $comment_field;
	$fields['author']  = $author_field;
	$fields['email']   = $email_field;
	$fields['url']     = $url_field;

	return $fields;
}

add_filter( 'comment_form_fields', 'xlt_comment_fields_custom_order' );

/**
 * Redirect en comments to the correct url.
 *
 * @param string $location The 'redirect_to' URI sent via $_POST.
 * @param object $comment Comment object.
 *
 * @return string
 */
function xlt_en_comment_redirect( $location, $comment ) {
	if ( ! isset( $comment ) || empty( $comment->comment_post_ID ) ) {
		return $location;
	}

	// @codingStandardsIgnoreStart
	if ( isset( $_POST['en_redirect_to'] ) ) {
		$location = get_permalink( $comment->comment_post_ID ) . 'en/#comment-' . $comment->comment_ID;
	}

	// @codingStandardsIgnoreEnd

	return $location;
}

add_filter( 'comment_post_redirect', 'xlt_en_comment_redirect', 10, 2 );

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
 * Hide SEO settings meta box for posts.
 *
 * @return void
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
	return '|';
}

add_filter( 'document_title_separator', 'xlt_document_title_separator' );

/**
 * Removes tags from blog posts.
 *
 * @return void
 */
function xlt_unregister_tags() {
	unregister_taxonomy_for_object_type( 'post_tag', 'post' );
}

add_action( 'init', 'xlt_unregister_tags' );

/**
 * Replace YouTube.com with the no cookie version.
 *
 * @param string $return The returned oEmbed HTML.
 * @param object $data A data object result from an oEmbed provider.
 *
 * @return string
 */
function xlt_youtube_oembed_filters( $return, $data ) {
	if ( false === $return || ! in_array( $data->type, array( 'rich', 'video' ), true ) ) {
		return $return;
	}

	if ( false !== strpos( $return, 'youtube' ) || false !== strpos( $return, 'youtu.be' ) ) {
		$return = str_replace( 'youtube.com/embed', 'youtube-nocookie.com/embed', $return );
	}

	return $return;
}

add_filter( 'oembed_dataparse', 'xlt_youtube_oembed_filters', 99, 2 );

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
 * @param bool $enable Whether to enable <link> tag discovery. Default true.
 *
 * @return bool
 */
function xlt_restore_oembed_cache( $enable ) {
	if ( 1 === did_action( 'wpse_do_cleanup' ) ) {
		$GLOBALS['wp_embed']->usecache = 1;
	}

	return $enable;
}

add_filter( 'embed_oembed_discover', 'xlt_restore_oembed_cache' );

/**
 * Insert minified CSS into header.
 *
 * @return void
 */
function xlt_insert_css() {
	$file  = get_template_directory() . '/assets/css/main.min.css';
	$style = xlt_get_file_content( $file );

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
	$script = xlt_get_file_content( $file );

	echo '<script id="all-scripts-inline" type="text/javascript">' . $script . '</script>';

//	$snow   = get_template_directory() . '/assets/js/snow.min.js';
//	$script_snow = xlt_get_file_content( $snow );
//	echo '<script type="text/javascript">' . $script_snow . '</script>';
}

add_action( 'wp_footer', 'xlt_insert_scripts' );

/**
 * Send 404 to Plausible.
 *
 * @return void
 */
function xlt_404_plausible() {
	if ( is_404() ) {
		?>
        <script>plausible('404', { props: { path: document.location.pathname } })</script>
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

	wp_admin_css_color(
		'xlthlx',
		__( 'Xlthlx', 'xlthlx' ),
		$theme_dir . '/assets/css/admin/color-scheme.min.css',
		array( '#1e2327', '#fff', '#92285e', '#6667ab' ),
		array(
			'base'    => '#ffffff',
			'focus'   => '#92285e',
			'current' => '#ffffff',
		)
	);
}

add_action( 'admin_init', 'xlt_admin_color_scheme' );

/**
 * Create a menu separator.
 *
 * @param int $position Menu position.
 *
 * @return void
 */
function xlt_add_admin_menu_separator( $position ) {
	global $menu;
	$index = 0;

	// @codingStandardsIgnoreStart
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
				'wp-menu-separator',
			);
			break;
		}
	}

	ksort( $menu );
	// @codingStandardsIgnoreEnd
}

/**
 * Move around some admin menu items.
 *
 * @return void
 */
function xlt_rearrange_admin_menu() {

	remove_menu_page( 'edit-comments.php' );

	// @codingStandardsIgnoreStart
	add_submenu_page(
		'edit.php',
		'Commenti',
		'Commenti',
		'edit_posts',
		'edit-comments.php',
		'',
		22
	);
	// @codingStandardsIgnoreEnd

	xlt_add_admin_menu_separator( 24 );
}

add_action( 'admin_menu', 'xlt_rearrange_admin_menu' );

/**
 * Hide SEO and description columns.
 *
 * @param string[] $columns An associative array of column headings.
 *
 * @return string[]
 */
function xlt_hide_seo_columns( $columns ) {
	unset( $columns['meta_title'], $columns['meta_description'], $columns['description'], $columns['noindex'], $columns['index'] );

	return $columns;
}

add_filter( 'manage_page_posts_columns', 'xlt_hide_seo_columns', 20 );
add_filter( 'manage_post_posts_columns', 'xlt_hide_seo_columns', 20 );
add_filter( 'manage_edit-category_columns', 'xlt_hide_seo_columns', 20 );
add_filter( 'manage_film_posts_columns', 'xlt_hide_seo_columns', 20 );
add_filter( 'manage_tvseries_posts_columns', 'xlt_hide_seo_columns', 20 );

/**
 * Wrap the image with picture tag to support webp.
 *
 * @param string $html HTML img element or empty string on failure.
 * @param int $attachment_id Image attachment ID.
 * @param string $size Requested image size.
 * @param bool $icon Whether the image should be treated as an icon.
 * @param string[] $attr Attributes for the image markup.
 *
 * @return string
 */
function xlt_wrap_image_with_picture( $html, $attachment_id, $size, $icon, $attr ) {
	if ( is_admin() ) {
		return $html;
	}

	$type = get_post_mime_type( $attachment_id );

	if ( ! $icon ) {
		$webp_src = preg_replace( '/(?:jpg|png|jpeg)$/i', 'webp', $attr['src'] );

		$html = '<picture>
			  <source srcset="' . $webp_src . '" type="image/webp">
			  <source srcset="' . $attr['src'] . '" type="' . $type . '">
			  ' . $html . '
			</picture>';
	}

	return $html;
}

add_filter( 'wp_get_attachment_image', 'xlt_wrap_image_with_picture', 10, 5 );

/**
 * Wrap the image with picture tag to support webp.
 *
 * @param string $filtered_image Full img tag with attributes that will replace the source img tag.
 * @param string $context Additional context, like the current filter name or the function name from where this was called.
 * @param int $attachment_id Image attachment ID.
 *
 * @return string
 */
function xlt_image_with_picture( $filtered_image, $context, $attachment_id ) {
	if ( is_admin() ) {
		return $filtered_image;
	}

	$type = get_post_mime_type( $attachment_id );

	preg_match( '/width="([^"]+)/i', $filtered_image, $width, PREG_OFFSET_CAPTURE );
	preg_match( '/height="([^"]+)/i', $filtered_image, $height, PREG_OFFSET_CAPTURE );
	if ( isset( $width[1], $height[1] ) ) {
		$size = array( $width[1][0], $height[1][0] );
	} else {
		$size = 'full';
	}

	$img_src  = wp_get_attachment_image_url( $attachment_id, $size );
	$webp_src = preg_replace( '/(?:jpg|png|jpeg)$/i', 'webp', $img_src );

	$filtered_image = '<picture>
			  <source srcset="' . $webp_src . '" type="image/webp">
			  <source srcset="' . $img_src . '" type="' . $type . '">
			  ' . $filtered_image . '
			</picture>';

	return $filtered_image;
}

add_filter( 'wp_content_img_tag', 'xlt_image_with_picture', 10, 3 );

/**
 * Add icons into admin.
 *
 * @return void
 */
function xlt_add_admin_icons() {
	$favicon = get_template_directory_uri() . '/assets/img/favicon.ico';

	echo '<link rel="shortcut icon" href="' . esc_url( $favicon ) . '" />';
}

add_action( 'login_head', 'xlt_add_admin_icons' );
add_action( 'admin_head', 'xlt_add_admin_icons' );

/**
 * Add column Description.
 *
 * @param string[] $post_columns An associative array of column headings.
 *
 * @return string[]
 */
function xlt_add_remove_link_columns( $post_columns ) {

	$post_columns['link_description'] = 'Descrizione';

	unset( $post_columns['rel'], $post_columns['rating'], $post_columns['visible'] );

	return $post_columns;
}

/**
 * Display column content.
 *
 * @param string $column_name The name of the column to display.
 * @param int $post_id The current post ID.
 *
 * @return void
 */
function xlt_add_link_columns_data( $column_name, $post_id ) {

	if ( 'link_description' === $column_name ) {
		$val = get_bookmark_field( 'link_description', $post_id );
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
	add_filter( 'manage_link-manager_columns', 'xlt_add_remove_link_columns' );
	add_action( 'manage_link_custom_column', 'xlt_add_link_columns_data', 10, 2 );
}

add_action( 'load-link-manager.php', 'xlt_setup_columns' );

/**
 * Add a link to the WP Toolbar for the English version.
 *
 * @param object $wp_admin_bar The WP_Admin_Bar instance, passed by reference.
 *
 * @return void
 */
function xlt_en_toolbar_link( $wp_admin_bar ) {

	global $pagenow;

	if ( 'post.php' === $pagenow && is_admin() ) {
		$args = array(
			'id'    => 'view-english',
			'title' => 'Visualizza articolo in Inglese',
			'href'  => get_permalink( get_query_var( 'post' ) ) . 'en/',
			'meta'  => array(
				'class' => 'ab-item',
				'title' => 'Visualizza articolo in Inglese',
			),
		);
		$wp_admin_bar->add_node( $args );
	}
}

add_action( 'admin_bar_menu', 'xlt_en_toolbar_link', 999 );

/**
 * Callback function for DeepL Auth Key Field.
 *
 * @param array $val Field Options.
 *
 * @return void
 */
function xlt_deepl_auth_key_callback_function( $val ) {
	$id          = $val['id'];
	$option_name = $val['option_name'];
	?>
    <label for="<?php echo esc_attr( $id ); ?>">Auth Key</label>
    <input type="password" name="<?php echo esc_attr( $option_name ); ?>"
           id="<?php echo esc_attr( $id ); ?>" value="<?php echo esc_attr( get_option( $option_name ) ); ?>"/>
	<?php
}

/**
 * Add DeepL Auth Key to Writing Settings Admin.
 *
 * @return void
 */
function xlt_deepl_auth_key_field_to_writing_admin_page() {

	register_setting(
		'writing',
		'deepl_auth_key',
		array(
			'show_in_rest' => true,
		)
	);

	add_settings_field(
		'deepl_auth_key_settings',
		'DeepL Auth Key',
		'xlt_deepl_auth_key_callback_function',
		'writing',
		'default',
		array(
			'id'          => 'deepl_auth_key',
			'option_name' => 'deepl_auth_key',
		)
	);
}

add_action( 'admin_menu', 'xlt_deepl_auth_key_field_to_writing_admin_page' );

/**
 * Iframe shortcode.
 *
 * @param array $atts Array of attributes.
 *
 * @return string The iframe HTML.
 */
function xlt_add_shortcode_iframe( $atts ) {
	$defaults = array(
		'src'         => '',
		'width'       => '100%',
		'height'      => '500',
		'scrolling'   => 'yes',
		'frameborder' => '0',
	);

	foreach ( $defaults as $default => $value ) {
		if ( ! array_key_exists( $default, $atts ) ) {
			$atts[ $default ] = $value;
		}
	}

	$html = '<iframe';
	foreach ( $atts as $attr => $value ) {

		if ( strtolower( $attr ) === 'src' ) {
			$value = esc_url( $value );
		}

		if ( strtolower( $attr ) !== 'onload' && strtolower( $attr ) !== 'onpageshow' && strtolower( $attr ) !== 'onclick' ) {
			if ( '' !== $value ) {
				$html .= ' ' . esc_attr( $attr ) . '="' . esc_attr( $value ) . '"';
			} else {
				$html .= ' ' . esc_attr( $attr );
			}
		}
	}
	$html .= '></iframe>' . "\n";

	return $html;
}

// @codingStandardsIgnoreStart
add_shortcode( 'iframe', 'xlt_add_shortcode_iframe' );
// @codingStandardsIgnoreEnd

/**
 * Add settings field.
 *
 * @return void
 */
function xlt_add_english_fields_settings() {
	register_setting( 'general', 'english_title', 'esc_attr' );
	register_setting( 'general', 'english_tagline', 'esc_attr' );

	add_settings_field( 'english_title', '<label for="english_title">' . __( 'English title', 'xlthlx' ) . '</label>', 'xlt_english_title_field', 'general' );
	add_settings_field( 'english_tagline', '<label for="english_tagline">' . __( 'English tagline', 'xlthlx' ) . '</label>', 'xlt_english_tagline_field', 'general' );
}

/**
 * English title field.
 *
 * @return void
 */
function xlt_english_title_field() {
	$english_title = get_option( 'english_title', '' );
	echo '<input aria-describedby="title-english" class="regular-text" type="text" id="english_title" name="english_title" value="' . $english_title . '" />';
	echo '<p class="description" id="title-english">Website title.</p>';
}

/**
 * English tagline field.
 *
 * @return void
 */
function xlt_english_tagline_field() {
	$english_tagline = get_option( 'english_tagline', '' );
	echo '<input aria-describedby="tagline-english" class="regular-text" type="text" id="english_tagline" name="english_tagline" value="' . $english_tagline . '" />';
	echo '<p class="description" id="tagline-english">In a few words, explain what this site is about.</p>';
}

add_filter( 'admin_init', 'xlt_add_english_fields_settings' );

/**
 * Allowed tags into excerpt.
 *
 * @return string
 */
function xlt_allowedtags() {
	return '<p>,<br>,<em>,<i>,<ul>,<ol>,<li>,<p>,<img>,<video>,<audio>,<figure>,<picture>,<source>';
}

/**
 * Set up an excerpt from $content.
 *
 * @param string $xlt_excerpt The post excerpt.
 *
 * @return string
 * @throws Exception Exception.
 */
function xlt_custom_wp_trim_excerpt( $xlt_excerpt ) {
	$raw_excerpt = $xlt_excerpt;

	if ( '' === $xlt_excerpt ) {

		global $lang, $post;
		$xlt_excerpt = get_the_content( '' );

		if ( isset( $post ) && 'en' === $lang ) {
			$xlt_excerpt = get_content_en( $post->ID );
		}

		$xlt_excerpt = strip_shortcodes( $xlt_excerpt );
		$xlt_excerpt = apply_filters( 'the_content', $xlt_excerpt );
		$xlt_excerpt = str_replace( ']]>', ']]&gt;', $xlt_excerpt );
		$xlt_excerpt = strip_tags( $xlt_excerpt, xlt_allowedtags() );

		$excerpt_word_count = 60;
		$excerpt_length     = apply_filters( 'excerpt_length', $excerpt_word_count );
		$tokens             = array();
		$excerpt_output     = '';
		$count              = 0;

		preg_match_all( '/(<[^>]+>|[^<>\s]+)\s*/u', $xlt_excerpt, $tokens );

		foreach ( $tokens[0] as $token ) {

			if ( $count >= $excerpt_word_count && preg_match( '/[,;?.!]\s*$/uS', $token ) ) {
				$excerpt_output .= trim( $token );
				break;
			}

			$count ++;
			$excerpt_output .= $token;
		}

		$xlt_excerpt = trim( force_balance_tags( $excerpt_output ) );

		$xlt_excerpt = str_replace( '<p></p>', '', $xlt_excerpt );

		$excerpt_end  = '...';
		$excerpt_more = apply_filters( 'excerpt_more', ' ' . $excerpt_end );

		$pos    = strrpos( $xlt_excerpt, '</' );
		$figure = strrpos( $xlt_excerpt, '</figure>' );
		if ( false !== $pos && false === $figure ) {
			$xlt_excerpt = substr_replace( $xlt_excerpt, $excerpt_end, $pos, 0 );
		}

		return $xlt_excerpt;

	}

	return apply_filters( 'xlt_custom_wp_trim_excerpt', $xlt_excerpt, $raw_excerpt );
}

remove_filter( 'get_the_excerpt', 'wp_trim_excerpt' );
add_filter( 'get_the_excerpt', 'xlt_custom_wp_trim_excerpt' );
