<?php
/**
 * Functions which enhance the theme by hooking into WordPress.
 *
 * @package  WordPress
 * @subpackage  Xlthlx
 */

/**
 * Remove Emoji support.
 */
function xlt_disable_emoji_support() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_texlt_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'emoji_svg_url', '__return_false' );
	add_filter( 'wp_resource_hints', 'xlt_disable_emojis_remove_dns_prefetch', 10, 2 );
}

add_action( 'init', 'xlt_disable_emoji_support' );

/**
 * Remove emoji CDN hostname from DNS prefetch hints.
 *
 * @param array $urls URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 *
 * @return array Difference between the two arrays.
 */
function xlt_disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
	if ( 'dns-prefetch' === $relation_type ) {
		/** This filter is documented in wp-includes/formatting.php */
		$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );
		$urls          = array_diff( $urls, [ $emoji_svg_url ] );
	}

	return $urls;
}

/**
 * Replace <meta .* name="generator"> like tags.
 *
 * @param $html
 *
 * @return string|string[]|null
 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
 *
 */
function xlt_replace_meta_generators( $html ) {
	$raw_html = $html;

	$pattern = '/<meta[^>]+name=["\']generator["\'][^>]+>/i';
	$html    = preg_replace( $pattern, '', $html );

	// If replacement is completed with an error, user will receive a white screen.
	// We have to prevent it.
	if ( empty( $html ) ) {
		return $raw_html;
	}

	return $html;
}

/**
 * Clean meta generators.
 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
 */
function xlt_clean_meta_generators() {
	ob_start( 'xlt_replace_meta_generators' );
}

/**
 * Remove WordPress version.
 */
function xlt_remove_wordpress_version() {

	// Clean meta generator for Wordpress core
	remove_action( 'wp_head', 'wp_generator' );
	add_filter( 'the_generator', '__return_empty_string' );

	// Clean all meta generators
	add_action( 'wp_head', 'xlt_clean_meta_generators', 100 );
}

if ( ! is_admin() ) {
	add_action( 'init', 'xlt_remove_wordpress_version' );
}

/**
 * Remove version and add file version to js/css.
 *
 * @param string $src
 *
 * @return string
 */
function xlt_change_version_of_style_js( string $src ) {

	if ( ! is_admin() ) {

		$clean_src  = $src ? esc_url( remove_query_arg( 'ver', $src ) ) : false;
		$clean_path = '';

		if ( $clean_src ) {
			if ( str_contains( $clean_src, 'wp-content/plugins' ) ) {
				$clean_path = str_replace( site_url() . '/wp-content/plugins',
					ABSPATH . 'wp-content/plugins', $clean_src );
			}

			if ( str_contains( $clean_src, 'wp-content/themes' ) ) {
				$clean_path = str_replace( get_theme_root_uri(), get_theme_root(),
					$clean_src );
			}

			if ( str_contains( $clean_src, 'wp-includes' ) ) {
				$clean_path = str_replace( site_url() . '/wp-includes/',
					ABSPATH . 'wp-includes/', $clean_src );
			}

			if ( str_starts_with( $clean_src, "/wp-includes/" ) ) {
				$clean_path = str_replace( '/wp-includes/',
					ABSPATH . 'wp-includes/', $clean_src );
			}

			$return = file_exists( $clean_path ) ? add_query_arg( 'v',
				filemtime( $clean_path ), $clean_src ) : add_query_arg( 'v',
				'not-found', $clean_src );

			//External script/css
			if ( ! str_contains( $clean_src, site_url() ) ) {
				$return = preg_replace( '~(\?|&)ver=[^&]*~', '', $src );

			}

			//Internal wp-admin
			if ( str_contains( $clean_src, 'wp-admin' ) ) {
				$return = $clean_src;
			}

			return $return;
		}
	}

	return $src;

}

if ( ! is_admin() ) {
	add_filter( 'style_loader_src', 'xlt_change_version_of_style_js', 9999, 1 );
	add_filter( 'script_loader_src', 'xlt_change_version_of_style_js', 9999, 1 );
}

/**
 * End buffer.
 */
function xlt_buffer_end() {
	ob_flush();
}

add_action( 'wp_head', 'xlt_buffer_end', 999 );

if ( is_admin() ) {

	/**
	 * Adds Thumbnail column for posts
	 *
	 * @param array $columns
	 *
	 * @return array $columns
	 */
	function xlt_posts_columns( $columns ) {
		$post_type = get_post_type();
		if ( $post_type === 'post' ) {
			unset( $columns['date'] );

			$columns = array_merge( $columns,
				[ 'thumbs' => __( 'Thumbnail' ), 'date' => __( 'Date' ) ] );
		}

		return $columns;
	}

	add_filter( 'manage_posts_columns', 'xlt_posts_columns', 9999 );

	/**
	 * Sets content for Thumbnail column and date
	 *
	 * @param string $column_name
	 * @param int $id
	 */
	function xlt_posts_custom_columns( $column_name, $id ) {
		if ( $column_name === 'thumbs' ) {
			echo get_the_post_thumbnail( $id, 'thumbnail' );
		}
		if ( $column_name === 'date' ) {
			echo get_the_date( $id );
		}
	}

	add_action( 'manage_posts_custom_column', 'xlt_posts_custom_columns', 9999, 2 );

	/**
	 * Remove comments column and adds Template column for pages
	 *
	 * @param array $columns
	 *
	 * @return array $columns
	 */
	function xlt_page_column_views( $columns ) {
		unset( $columns['comments'], $columns['date'] );

		return array_merge( $columns,
			[ 'page-layout' => __( 'Template' ), 'date' => __( 'Date' ) ] );

	}

	add_filter( 'manage_pages_columns', 'xlt_page_column_views', 9999 );

	/**
	 * Sets content for Template column and date
	 *
	 * @param string $column_name
	 * @param int $id
	 */
	function xlt_page_custom_column_views( $column_name, $id ) {
		if ( $column_name === 'page-layout' ) {
			$set_template = get_post_meta( get_the_ID(), '_wp_page_template',
				true );
			if ( ( $set_template === 'default' ) || ( $set_template === '' ) ) {
				$set_template = 'Default';
			}
			$templates = wp_get_theme()->get_page_templates();
			foreach ( $templates as $key => $value ) :
				if ( ( $set_template === $key ) && ( $set_template !== '' ) ) {
					$set_template = $value;
				}
			endforeach;

			echo $set_template;
		}
		if ( $column_name === 'date' ) {
			echo get_the_date( $id );
		}
	}

	add_action( 'manage_pages_custom_column', 'xlt_page_custom_column_views', 9999, 2 );
}

/**
 * Removes annoying submenus.
 */
function xlt_remove_menu_pages() {
	remove_submenu_page( 'aioseo', 'https://aioseo.com/lite-upgrade/?utm_source=WordPress&#038;utm_campaign=liteplugin&#038;utm_medium=admin-menu' );
}

add_action( 'admin_menu', 'xlt_remove_menu_pages', 999 );

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

add_action( 'wp_before_admin_bar_render', 'xlt_remove_admin_bar_wp_logo', 20 );

add_filter( 'pre_option_link_manager_enabled', '__return_true' );
add_filter( 'wpcf7_load_js', '__return_false' );
add_filter( 'wpcf7_load_css', '__return_false' );


