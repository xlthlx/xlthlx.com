<?php global $lang,$post,$site_url; ?>
<div class="col-auto d-flex justify-content-end ms-auto">
	<a href="<?php echo $site_url; ?>mode/" title="Dark mode" id="btn-toggle" class="btn btn-outline-secondary lang pink-hover">
		<svg style="margin-top:-6px" aria-label="Dark mode" role="img" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
			<path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
		</svg>
	</a>
	<?php if ( 'en' === $lang ) { ?>
		<button title="English" type="button" class="btn btn-secondary pe-none lang active">EN</button>
		<a href="<?php echo get_url_trans(); ?>" title="Italiano"
		   class="btn btn-outline-secondary lang pink-hover" role="button">IT</a>
	<?php } else { ?>
		<a href="<?php echo get_url_trans(); ?>" title="English"
		   class="btn btn-outline-secondary lang pink-hover" role="button">EN</a>
		<button title="Italiano" type="button" class="btn btn-secondary pe-none lang active">IT</button>
	<?php } ?>
</div>
