<?php
/**
 * Template part for first row in all site.
 *
 * @package  xlthlx
 */

global $lang, $site_url; ?>
<article class="xlt-entry">
	<div class="xlt-row xlt-row_break">
		<div class="xlt-entry__content xlt-spacing-min">
			<div class="xlt-widget__title">
				<?php
				if ( function_exists( 'xlt_get_switcher' ) ) {
					xlt_get_switcher();
				}
				$feed_url = get_home_url() . '/feed/';
				if ( 'en' === $lang ) {
                    $feed_url .= 'english/';
				}
				?>
			</div>
			<div class="xlt-meta__tools xlt-widget__title">
				<ul>
					<li>
						<a href="<?php echo $site_url; ?>" title="Poe" id="btn-poe">
							<span class="screen-reader-text">Poe</span>
							<svg class="xlt-shrink" width="32" height="26" aria-label="Poe" role="img"
								 xmlns="http://www.w3.org/2000/svg"
								 xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" viewBox="0 0 40 40">
							  <image xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAAXNSR0IArs4c6QAAAgZJREFUWEftmF2ShCAMhPGaej69pluwhm1jAh2cnfLBeZiySiQfnV+d0sN/08P50l3APXDAIVtDD6WUCti+83zTVE2FbIYWH2rtETCtMIDKrSZDFNCEM4wW48xBespGAC9wsjmCLMuS1nUtgNZ9L2aPtRceFtCEEzCEsq6z8YCaJyYaEF3GGNRKMoCgeiijqnoYa9mgQFgxqN2+bduQioyCpnvneS7hlA3n6xx3GTj/8rWojIdgVNSx2AN0S4qoJqACiKBaNSY0tJu7gJh1WgHLtQIszyHkpwFrmxCwngEEtkKg93yt3L9d5+/PqU2nPmZB6qRBA3cA0c0tF9d+iyf3VLAyfDQGGcDLFNByc6v8oJJMFqM3876WgiVzW+5DWNkQu4qUH10rPwF4KivandrVGQQVwtNj+WGTw5p8UMHupOIlii4tWAtRzcBwW4cNAaRnPEsNnFp0N2HHLgteYpCGk+zyYkkX7mjMeS6mAUdjKeparKfZxS/gq2AvOUYVaj0ncyFVZr6dHF4vdgv13XIRVRinaqqTPAWwFH1d+b/tXvadxBxWo66KrtdwdawmNqKLObGXucSCiwAenre/Zt0JA+jf5nTfe6vTp6W+t7HDxLH5/33dEuUM97gHQXjPrahKWEFtAF4Pmi9gsu4FNBSo41sjgy8fAbCdNXtysCxYsRUJk/DzP0Upri7dyfyeAAAAAElFTkSuQmCC"
									 width="40" height="40"/>
							</svg>
						</a>
					</li>
					<li>
						<a title="Feed RSS" target="_blank" href="<?php echo $feed_url; ?>">
							<span class="screen-reader-text">Feed RSS</span>
							<svg class="xlt-shrink" width="32" height="26" aria-label="Feed RSS" role="img"
								 viewBox="0 0 24 24" fill="none"
								 xmlns="http://www.w3.org/2000/svg">
								<g stroke-width="0"></g>
								<g stroke-linecap="round" stroke-linejoin="round"></g>
								<path d="M4 11C6.38695 11 8.67613 11.9482 10.364 13.636C12.0518 15.3239 13 17.6131 13 20M4 4C8.24346 4 12.3131 5.68571 15.3137 8.68629C18.3143 11.6869 20 15.7565 20 20M6 19C6 19.5523 5.55228 20 5 20C4.44772 20 4 19.5523 4 19C4 18.4477 4.44772 18 5 18C5.55228 18 6 18.4477 6 19Z"
									  stroke="var(--theme-text-color)" stroke-width="2" stroke-linecap="round"
									  stroke-linejoin="round"></path>
							</svg>
						</a>
					</li>
				</ul>
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
		<div class="xlt-main-sidebar xlt-spacing-min">
			<?php get_template_part( 'parts/search-form' ); ?>
		</div>
	</div>
</article>
