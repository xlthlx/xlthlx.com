<?php
/**
 * Template part for search form.
 *
 * @package  xlthlx
 */

global $lang, $site_url;
$label = ( 'en' === $lang ) ? 'Search' : 'Cerca'; ?>
<form action="<?php echo $site_url; ?>" method="post" id="searchform" novalidate>
    <input type="hidden" name="lang" id="lang" value="<?php echo ( 'en' === $lang ) ? 'en' : 'it'; ?>">
	<label for="s" class="screen-reader-text"><?php echo $label; ?></label>
	<input class="search" value="<?php echo get_query_var( 's' ); ?>" type="text" aria-label="<?php echo $label; ?>" name="s" id="s" placeholder="<?php echo $label; ?>"><button class="submit search" type="submit">
		<svg xmlns="http://www.w3.org/2000/svg" width="22" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" role="img" viewBox="0 0 25 25" focusable="false"><title><?php echo $label; ?></title><circle cx="10.5" cy="10.5" r="7.5"/><path d="M21 21l-5.2-5.2"/></svg>
		<span class="screen-reader-text"><?php echo $label; ?></span>
	</button>
</form>
