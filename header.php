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
<header>
	<?php get_template_part( 'parts/navbar' ); ?>
</header>
<main class="pb-0 mb-0">
	<a class="visually-hidden" href="#content">Skip to content</a>
	<div class="container pb-5 px-3 px-xl-5 mb-0 box-dashed fill">
		<div class="nav pt-3 mb-3">
			<?php if ( 'en' === $lang ) { ?>
				<button title="English" type="button" class="btn btn-secondary pe-none lang active">EN</button>
				<a href="<?php echo get_url_trans(); ?>" title="Italiano"
				   class="btn btn-outline-secondary lang pink-hover" role="button">IT</a>
			<?php } else { ?>
				<button title="Italiano" type="button" class="btn btn-secondary pe-none lang active">IT</button>
				<a href="<?php echo get_url_trans(); ?>" title="English"
				   class="btn btn-outline-secondary lang pink-hover" role="button">EN</a>
			<?php } ?>
		</div>
		<?php if ( ! ( is_home() || is_front_page() ) ) { ?>
			<nav class="mb-4" style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
				<?php xlt_breadcrumbs(); ?>
			</nav>
		<?php } ?>

		<div id="content">
