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
<meta name="color-scheme" content="dark light">

<?php get_template_part( 'parts/head' ); ?>

<body <?php body_class(); ?>>
<header>
	<?php get_template_part( 'parts/navbar' ); ?>
</header>
<main class="pb-0 mb-0">
	<a class="visually-hidden" href="#content">Skip to content</a>
	<div class="container pb-5 px-3 main-spacing mb-0 box-dashed fill">
		<div class="nav pt-3 mb-3">
			<?php if ( 'en' === $lang ) { ?>
				<a href="<?php echo get_url_trans(); ?>" title="Italiano"
				   class="btn btn-outline-secondary lang pink-hover" role="button">IT</a>
				<button title="English" type="button" class="btn btn-secondary pe-none lang active">EN</button>
			<?php } else { ?>
				<button title="Italiano" type="button" class="btn btn-secondary pe-none lang active">IT</button>
				<a href="<?php echo get_url_trans(); ?>" title="English"
				   class="btn btn-outline-secondary lang pink-hover" role="button">EN</a>
			<?php } ?>
			<a href="<?php echo $site_url; ?>mode/" title="Dark mode" id="btn-toggle" class="btn btn-outline-secondary lang pink-hover">
				<svg class="dark-mode" aria-label="Dark mode" role="img" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" focusable="false">
					<path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
				</svg>
			</a>
			<a href="<?php echo $site_url; ?>" title="Poe" id="btn-poe" class="btn btn-outline-secondary lang pink-hover">
				<svg class="sheep" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" viewBox="0 0 40 40">
				  <image xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAAXNSR0IArs4c6QAAAgZJREFUWEftmF2ShCAMhPGaej69pluwhm1jAh2cnfLBeZiySiQfnV+d0sN/08P50l3APXDAIVtDD6WUCti+83zTVE2FbIYWH2rtETCtMIDKrSZDFNCEM4wW48xBespGAC9wsjmCLMuS1nUtgNZ9L2aPtRceFtCEEzCEsq6z8YCaJyYaEF3GGNRKMoCgeiijqnoYa9mgQFgxqN2+bduQioyCpnvneS7hlA3n6xx3GTj/8rWojIdgVNSx2AN0S4qoJqACiKBaNSY0tJu7gJh1WgHLtQIszyHkpwFrmxCwngEEtkKg93yt3L9d5+/PqU2nPmZB6qRBA3cA0c0tF9d+iyf3VLAyfDQGGcDLFNByc6v8oJJMFqM3876WgiVzW+5DWNkQu4qUH10rPwF4KivandrVGQQVwtNj+WGTw5p8UMHupOIlii4tWAtRzcBwW4cNAaRnPEsNnFp0N2HHLgteYpCGk+zyYkkX7mjMeS6mAUdjKeparKfZxS/gq2AvOUYVaj0ncyFVZr6dHF4vdgv13XIRVRinaqqTPAWwFH1d+b/tXvadxBxWo66KrtdwdawmNqKLObGXucSCiwAenre/Zt0JA+jf5nTfe6vTp6W+t7HDxLH5/33dEuUM97gHQXjPrahKWEFtAF4Pmi9gsu4FNBSo41sjgy8fAbCdNXtysCxYsRUJk/DzP0Upri7dyfyeAAAAAElFTkSuQmCC" width="40" height="40"/>
				</svg>
			</a>
		</div>
		<?php if ( ! ( is_home() || is_front_page() ) ) { ?>
			<nav class="mb-4" style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
				<?php xlt_breadcrumbs(); ?>
			</nav>
		<?php } ?>

		<div id="content">
