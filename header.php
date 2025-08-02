<?php
/**
 * Header.
 *
 * @package  xlthlx
 */

global $lang, $site_url;
?>
<!doctype html>
<html lang="<?php echo $lang; ?>" id="top">

<?php get_template_part( 'parts/head' ); ?>

<body <?php body_class( 'xlt-sidebar_active dark-theme' ); ?>>

<a class="screen-reader-text" href="#main-content">Skip to content</a>

<div class="xlt-layout">
	<?php get_template_part( 'parts/navbar' ); ?>


