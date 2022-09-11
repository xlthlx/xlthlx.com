<?php
/**
 * Header.
 *
 * @package  xlthlx
 */

global $lang;
?>
<!doctype html>
<html lang="<?php echo $lang; ?>" id="top">
<meta name="color-scheme" content="dark light">

<?php get_template_part( 'parts/head' ); ?>

<body <?php body_class(); ?>>
<div class="banner">
	<p class="h2">Her Majesty Queen Elizabeth II</p>
	<p>21 April 1926 &nbsp;&mdash;&nbsp; 8 September 2022</p>
</div>
<header>
	<?php get_template_part( 'parts/navbar' ); ?>
</header>
<main class="pb-0 mb-0">
	<a class="visually-hidden" href="#content">Skip to content</a>
	<div class="container py-5 px-3 px-xl-5 mb-0 box-dashed fill">
		<?php if ( ! ( is_home() || is_front_page() ) ) { ?>
			<nav class="mb-4" style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
				<?php xlt_breadcrumbs(); ?>
			</nav>
		<?php } ?>

		<div id="content">
