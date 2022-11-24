<?php
/**
 * Global header.
 *
 * @package  xlthlx
 */

global $charset; ?>
<head>
	<meta charset="<?php echo $charset; ?>">
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $charset; ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="author" href="<?php echo get_template_directory_uri(); ?>/humans.txt"/>
	<meta name="theme-color" content="#6667ab"/>
	<?php // @codingStandardsIgnoreStart ?>
	<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/img/icons/favicon.ico" sizes="any">
	<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/img/icons/icon.svg" type="image/svg+xml">
	<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/assets/img/icons/apple-touch-icon.png">
	<?php // @codingStandardsIgnoreEnd ?>
	<link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/assets/manifest/manifest.json"/>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<?php // @codingStandardsIgnoreStart ?>
	<script id="stats" defer data-domain="xlthlx.com" data-api="https://plausible.io/api/event" src="/stats/js/script.outbound-links.file-downloads.hash.js"></script>
	<script>
		window.plausible = window.plausible || function () {
			(window.plausible.q = window.plausible.q || []).push(arguments)
		}
	</script>
	<?php // @codingStandardsIgnoreEnd ?>
	<?php wp_head(); ?>
</head>
