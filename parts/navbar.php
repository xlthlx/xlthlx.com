<?php
/**
 * Template part for main navbar.
 *
 * @package  xlthlx
 */

global $lang, $site_url, $site_name, $site_desc; ?>
<header class="xlt-h xlt-row">
	<div class="xlt-spacing xlt-spacing-title">
		<div class='xlt-logo'>
			<a href="<?php echo $site_url; ?>" rel="home" itemprop="url">
				<h1 class="xlt-site__title"><?php echo $site_name; ?></h1>
				<p class="xlt-site__description"><?php echo $site_desc; ?></p>
			</a>
		</div>
	</div>
</header>
