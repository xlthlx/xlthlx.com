<?php
/**
 * Remove default style for comments widget.
 */
function wt_remove_comments_style() {
	global $wp_widget_factory;

	$widget_recent_comments = $wp_widget_factory->widgets['WP_Widget_Recent_Comments'] ?? null;

	if ( ! empty( $widget_recent_comments ) ) {
		remove_action( 'wp_head',[
			$wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
			'recent_comments_style'
		] );
	}
}

/**
 * Remove RSD link, wlwmanifest Link, Shortlink, Previous/Next Post Link in the header.
 */
function wt_disable_links() {

	remove_action( 'wp_head', 'adjacent_posts_rel_link' );
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );
	remove_action( 'template_redirect', 'wp_shortlink_header', 11 );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

	add_action( 'widgets_init','wt_remove_comments_style' );
}

if ( ! is_admin() ) {
	add_action( 'init','wt_disable_links' );
}
