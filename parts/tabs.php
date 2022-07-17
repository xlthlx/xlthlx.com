<?php global $lang,$post; ?>
<div class="col-auto d-flex justify-content-end ms-auto">
	<a href="" title="Dark mode" id="btn-toggle" class="btn btn-outline-secondary lang pink-hover">☾</a>
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
