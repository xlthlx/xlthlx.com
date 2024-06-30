<?php global $lang; ?>
<article class="xlt-entry">
	<div class="xlt-row">
		<div class="xlt-entry__content xlt-spacing-min">
			<div class="xlt-widget__title">
				<?php if ( 'en' === $lang ) { ?>
					<a href="<?php echo get_url_trans(); ?>"
					   class="svg-btn" title="Italiano">Italiano</a>&nbsp;&mdash;&nbsp;
					<span>English</span>
				<?php } else { ?>
					<span>Italiano</span>&nbsp;&mdash;&nbsp;
					<a class="svg-btn" href="<?php echo get_url_trans(); ?>" title="English">English</a>
				<?php } ?>
			</div>
		</div>
		<div class="xlt-entry__content xlt-spacing-min">
			<div class="xlt-widget__title">
				<?php if ( 'en' === $lang ) { ?>Sign the <?php } else { ?>Firma il <?php } ?>
				<a class="svg-btn" title="Sign the Sustainable Web Manifesto"
				   target="_blank" href="https://www.sustainablewebmanifesto.com/">
					Sustainable Web Manifesto
				</a>
			</div>
		</div>
		<div class="xlt-entry__meta xlt-spacing-min">
			<p class="xlt-widget__title">
				<?php $text = ( 'en' === $lang ) ? 'Subscribe to the newsletter' : 'Iscriviti alla Newsletter'; ?>
				<?php $url = ( 'en' === $lang ) ? '/en/' : '/'; ?>
				<a title="<?php echo $text; ?>" class="svg-btn no-under"
				   href="https://xlthlx.com/newsletter<?php echo $url; ?>">
					<?php echo xlt_print_svg( '/assets/img/newsletter.svg' ); ?>
				</a>
				<a title="<?php echo $text; ?>" class="svg-btn"
				   href="https://xlthlx.com/newsletter<?php echo $url; ?>">
					<span>Newsletter</span>
				</a>
			</p>
		</div>
	</div>
</article>
