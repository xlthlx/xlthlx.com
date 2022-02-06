<?php
/**
 * Sets the correct function when an option is activated
 *
 * @package  WordPress
 * @subpackage  Xlthlx
 */

require_once( __DIR__ . '/toolkit-functions.php' );
global $wt_updates, $wt_general, $wt_dashboard, $wt_seo, $wt_archives, $wt_listing, $wt_login, $wt_uploads;

/**
 * General options.
 */
if ( isset( $wt_general ) ) {
	foreach ( $wt_general as $key => $value ) {
		//Radio fields yes/no
		if ( $value === 'yes' ) {
			switch ( $key ) {
				case 'emoji_support':
					add_action( 'init', 'wt_disable_emoji_support' );
					break;
				case 'rest_api':
					if ( ! is_admin() ) {
						add_action( 'init', 'wt_disable_rest_api' );
					}
					break;
				case 'links':
					if ( ! is_admin() ) {
						add_action( 'init', 'wt_disable_links' );
					}
					break;
				case 'wordpress_version':
					if ( ! is_admin() ) {
						add_action( 'init', 'wt_remove_wordpress_version' );
					}
					break;
				case 'pings':
					if ( ! is_admin() ) {
						add_action( 'init', 'wt_remove_pings' );
					}
					break;
				case 'comments':
					if ( ! is_admin() ) {
						add_action( 'init', 'wt_remove_comments' );
					}
					break;
				case 'versions':
					if ( ! is_admin() ) {
						add_filter( 'style_loader_src',
							'wt_change_version_from_style_js', 9999, 1 );
						add_filter( 'script_loader_src',
							'wt_change_version_from_style_js', 9999, 1 );
					}
					break;
			}
		}
	}
}

/**
 * Dashboard options.
 */
if ( isset( $wt_dashboard ) ) {
	foreach ( $wt_dashboard as $key => $value ) {
		//Radio fields yes/no
		if ( $value === 'yes' ) {
			switch ( $key ) {
				case 'dashboard_widgets':
					add_action( 'wp_dashboard_setup',
						'wt_disable_dashboard_widgets', 999 );
					break;
			}
		}
	}
}

/**
 * SEO options.
 */
if ( isset( $wt_seo ) ) {
	foreach ( $wt_seo as $key => $value ) {
		//Radio fields yes/no
		if ( $value === 'yes' ) {
			switch ( $key ) {
				case 'pretty_search':
					add_filter( 'wpseo_json_ld_search_url', 'wt_rewrite' );
					add_action( 'template_redirect', 'wt_search_url_rewrite' );
					break;
				case 'header':
					add_action( 'wp_headers', 'wt_last_mod_header' );
					break;
				case 'images_alt':
					add_filter( 'the_content', 'wt_add_image_alt', 9999 );
					add_filter( 'wp_get_attachment_image_attributes',
						'wt_change_image_attr', 20, 2 );
					break;
			}
		}
	}
}

/**
 * Archive options.
 */
if ( isset( $wt_archives ) ) {
	foreach ( $wt_archives as $key => $value ) {
		//Radio fields yes/no
		if ( $value === 'yes' ) {
			switch ( $key ) {
				case 'remove_title':
					add_filter( 'get_the_archive_title',
						'wt_remove_archive_title_prefix' );
					break;
				case 'media_redirect':
					add_action( 'template_redirect',
						'wt_attachment_pages_redirect' );
					break;
				case 'redirect_author':
					add_action( 'template_redirect',
						'wt_redirect_archives_author' );
					break;
			}
		}
	}
}

/**
 * Listing options.
 */
if ( isset( $wt_listing ) ) {
	foreach ( $wt_listing as $key => $value ) {
		//Radio fields yes/no
		if ( $value === 'yes' ) {
			switch ( $key ) {
				case 'posts_columns':
					add_filter( 'manage_posts_columns', 'wt_posts_columns',
						9999 );
					add_action( 'manage_posts_custom_column',
						'wt_posts_custom_columns', 9999, 2 );
					break;
				case 'pages_columns':
					add_filter( 'manage_pages_columns', 'wt_page_column_views',
						9999 );
					add_action( 'manage_pages_custom_column',
						'wt_page_custom_column_views', 9999, 2 );
					break;
			}
		}
	}
}

/**
 * Login options.
 */
if ( isset( $wt_login ) ) {
	foreach ( $wt_login as $key => $value ) {
		if ( $value !== '' ) {
			switch ( $key ) {
				case 'wt_login':
					add_action( 'after_setup_theme', 'wt_plugins_loaded', 1 );
					add_action( 'wp_loaded', 'wt_wp_loaded' );

					add_filter( 'site_url', 'wt_site_url', 10, 4 );
					add_filter( 'wp_redirect', 'wt_wp_redirect', 10, 2 );

					add_filter( 'site_option_welcome_email',
						'wt_welcome_email' );
					add_filter( 'body_class', 'wt_admin_bar_body_class', 10,
						2 );

					remove_action( 'template_redirect',
						'wp_redirect_admin_locations', 1000 );
					break;
			}
		}
	}
}

/**
 * Uploads options.
 */
if ( isset( $wt_uploads ) ) {
	foreach ( $wt_uploads as $key => $value ) {
		//Radio fields yes/no
		if ( $value === 'yes' ) {
			switch ( $key ) {
				case 'clean_names':
					add_action( 'wp_handle_upload_prefilter',
						'wt_upload_filter' );
					add_action( 'add_attachment',
						'wt_update_attachment_title' );
					break;
			}
		}
	}
}


