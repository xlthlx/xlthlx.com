<?php global $lang, $site_url;
$label = ( 'en' === $lang ) ? 'Search' : 'Cerca'; ?>
<form action="<?php echo $site_url; ?>" method="get" id="searchform" class="d-flex">
	<label for="s" class="visually-hidden"><?php echo $label; ?></label>
	<input class="form-control me-2 rounded-0" type="text" aria-label="<?php echo $label; ?>" name="s" id="s"
		   placeholder="<?php echo $label; ?>">
	<?php if ( 'en' === $lang ) { ?>
		<input type="hidden" name="lang" id="lang" value="en">
	<?php } ?>
	<button class="btn btn-dark rounded-0 border-0 btn-50" type="submit">
		<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none"
			 stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
			 stroke-width="2" role="img" viewBox="0 0 24 24" focusable="false"><title><?php echo $label; ?></title>
			<circle cx="10.5" cy="10.5" r="7.5"/>
			<path d="M21 21l-5.2-5.2"/>
		</svg>
		<span class="visually-hidden"><?php echo $label; ?></span>
	</button>
</form>
