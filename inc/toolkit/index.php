<?php
/**
 * Toolkit.
 *
 * @package  xlthlx
 */

/**
 * Sets all the default values for the options.
 */
$defaults = [
	'wt_general'   => [
		'emoji_support'     => 'yes',
		'rest_api'          => 'yes',
		'links'             => 'yes',
		'wordpress_version' => 'yes',
		'pings'             => 'no',
		'comments'          => 'yes',
		'versions'          => 'yes',
	],
	'wt_dashboard' => [
		'dashboard_widgets' => 'yes',
	],
	'wt_seo'       => [
		'header'        => 'yes',
		'images_alt'    => 'yes',
	],
	'wt_archives'  => [
		'remove_title'    => 'yes',
		'media_redirect'  => 'yes',
		'redirect_author' => 'yes',
	],
	'wt_listing'   => [
		'posts_columns' => 'yes',
		'pages_columns' => 'yes',
	],
	'wt_login'     => [
		'wt_login' => 'entra',
	],
	'wt_uploads'   => [
		'clean_names' => 'yes',
	],
];

$wt_general   = $defaults['wt_general'];
$wt_dashboard = $defaults['wt_dashboard'];
$wt_seo       = $defaults['wt_seo'];
$wt_archives  = $defaults['wt_archives'];
$wt_listing   = $defaults['wt_listing'];
$wt_login     = $defaults['wt_login'];
$wt_uploads   = $defaults['wt_uploads'];

require_once( __DIR__ . '/toolkit-options.php' );