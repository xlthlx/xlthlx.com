<?php
/**
 * Template part for header.
 *
 * @package  xlthlx
 */

global $charset; ?>
<head>
	<meta charset="<?php echo $charset; ?>">
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $charset; ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="theme-color" content="#CACBE2"/>
	<link rel="author" href="<?php echo get_template_directory_uri(); ?>/humans.txt"/>
	<?php wp_head(); ?>
</head>
