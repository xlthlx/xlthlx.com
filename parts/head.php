<?php global $charset; ?>
<head>
	<meta charset="<?php echo $charset; ?>">
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $charset; ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="author" href="<?php echo get_template_directory_uri();?>/humans.txt"/>
	<link rel="preload" href="<?php echo get_template_directory_uri();?>/assets/fonts/ShadowsIntoLight.woff2" as="font" type="font/woff2" crossorigin />
	<link rel="preload" href="<?php echo get_template_directory_uri(); ?>/assets/js/main.min.js?ver=<?php echo filemtime( get_template_directory() . '/assets/js/main.min.js' ); ?>" as="script" crossorigin/>
	<meta name="theme-color" content="#6667ab"/>
	<link rel="manifest" href="<?php echo get_template_directory_uri();?>/assets/manifest/manifest.json"/>
	<?php wp_head(); ?>

	<?php if('http://localhost' !== home_url()) { ?>
	<script id="stats" defer data-domain="xlthlx.com" data-api="https://plausible.io/api/event" src="/stats/js/script.outbound-links.file-downloads.hash.js"></script>
	<script>window.plausible = window.plausible || function() { (window.plausible.q = window.plausible.q || []).push(arguments) }</script>
	<?php } ?>
</head>
