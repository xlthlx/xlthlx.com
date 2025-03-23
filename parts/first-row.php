<?php
/**
 * Template part for first row in all site.
 *
 * @package  xlthlx
 */

global $lang; ?>
<article class="xlt-entry">
	<div class="xlt-row xlt-row_break">
		<div class="xlt-entry__content xlt-spacing-min">
			<div class="xlt-widget__title">
				<?php
				if ( function_exists( 'xlt_get_switcher' ) ) {
					xlt_get_switcher();
				}
				?>
			</div>
		</div>
		<div class="xlt-entry__content xlt-spacing-min">
			<div class="xlt-widget__title">
				<?php
				if ( 'en' === $lang ) {
					?>
					Sign the 
					<?php
				} else {
					?>
					Firma il <?php } ?>
				<a class="svg-btn" title="Sign the Sustainable Web Manifesto"
				   target="_blank" href="https://www.sustainablewebmanifesto.com/">
					Sustainable Web Manifesto
				</a>
			</div>
		</div>
		<div class="xlt-entry__meta xlt-spacing-min">
			<div class="xlt-widget__title">
				<?php $text = ( 'en' === $lang ) ? 'Subscribe to the newsletter' : 'Iscriviti alla Newsletter'; ?>
				<?php $url = ( 'en' === $lang ) ? '/en/' : '/'; ?>
				<a title="<?php echo $text; ?>" class="svg-btn no-under"
				   href="https://xlthlx.com/newsletter<?php echo $url; ?>">
					<?php
					if ( function_exists( 'xlt_print_svg' ) ) {
						echo xlt_print_svg( '/assets/img/newsletter.svg' ); }
					?>
				</a>
				<a title="<?php echo $text; ?>" class="svg-btn"
				   href="https://xlthlx.com/newsletter<?php echo $url; ?>">
					<span>Newsletter</span>
				</a>
			</div>
		</div>
	</div>
</article>
