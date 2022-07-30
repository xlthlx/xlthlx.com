<?php
/**
 * Remove emoji CDN hostname from DNS prefetch hints.
 *
 * @param array $urls URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 *
 * @return array Difference between the two arrays.
 */
function wt_disable_emojis_remove_dns_prefetch( $urls,$relation_type ) {
	if ( 'dns-prefetch' === $relation_type ) {
		/** This filter is documented in wp-includes/formatting.php */
		$emoji_svg_url = apply_filters( 'emoji_svg_url','https://s.w.org/images/core/emoji/2/svg/' );
		$urls          = array_diff( $urls,[ $emoji_svg_url ] );
	}

	return $urls;
}

/**
 * Remove Emoji support
 */
function wt_disable_emoji_support() {

	remove_action( 'wp_head','print_emoji_detection_script',7 );
	remove_action( 'admin_print_scripts','print_emoji_detection_script' );
	remove_action( 'wp_print_styles','print_emoji_styles' );
	remove_action( 'admin_print_styles','print_emoji_styles' );
	remove_filter( 'the_content_feed','wp_staticize_emoji' );
	remove_filter( 'comment_tewt_rss','wp_staticize_emoji' );
	remove_filter( 'wp_mail','wp_staticize_emoji_for_email' );
	add_filter( 'emoji_svg_url','__return_false' );

	add_filter( 'wp_resource_hints','wt_disable_emojis_remove_dns_prefetch',10,2 );
}

add_action( 'init','wt_disable_emoji_support' );
