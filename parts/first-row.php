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
                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40">
							  <image xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAAXNSR0IArs4c6QAAAgZJREFUWEftmF2ShCAMhPGaej69pluwhm1jAh2cnfLBeZiySiQfnV+d0sN/08P50l3APXDAIVtDD6WUCti+83zTVE2FbIYWH2rtETCtMIDKrSZDFNCEM4wW48xBespGAC9wsjmCLMuS1nUtgNZ9L2aPtRceFtCEEzCEsq6z8YCaJyYaEF3GGNRKMoCgeiijqnoYa9mgQFgxqN2+bduQioyCpnvneS7hlA3n6xx3GTj/8rWojIdgVNSx2AN0S4qoJqACiKBaNSY0tJu7gJh1WgHLtQIszyHkpwFrmxCwngEEtkKg93yt3L9d5+/PqU2nPmZB6qRBA3cA0c0tF9d+iyf3VLAyfDQGGcDLFNByc6v8oJJMFqM3876WgiVzW+5DWNkQu4qUH10rPwF4KivandrVGQQVwtNj+WGTw5p8UMHupOIlii4tWAtRzcBwW4cNAaRnPEsNnFp0N2HHLgteYpCGk+zyYkkX7mjMeS6mAUdjKeparKfZxS/gq2AvOUYVaj0ncyFVZr6dHF4vdgv13XIRVRinaqqTPAWwFH1d+b/tXvadxBxWo66KrtdwdawmNqKLObGXucSCiwAenre/Zt0JA+jf5nTfe6vTp6W+t7HDxLH5/33dEuUM97gHQXjPrahKWEFtAF4Pmi9gsu4FNBSo41sjgy8fAbCdNXtysCxYsRUJk/DzP0Upri7dyfyeAAAAAElFTkSuQmCC"
                                     width="40" height="40"/>
							</svg>
                        </a>
                    </li>
                    <li>
                        <a title="Feed RSS" target="_blank" href="<?php echo $feed_url; ?>">
                            <span class="screen-reader-text">Feed RSS</span>
                            <svg class="xlt-shrink" width="32" height="26" aria-label="Feed RSS" role="img"
                                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <g stroke-width="0"></g>
                                <g stroke-linecap="round" stroke-linejoin="round"></g>
                                <path d="M4 11C6.38695 11 8.67613 11.9482 10.364 13.636C12.0518 15.3239 13 17.6131 13 20M4 4C8.24346 4 12.3131 5.68571 15.3137 8.68629C18.3143 11.6869 20 15.7565 20 20M6 19C6 19.5523 5.55228 20 5 20C4.44772 20 4 19.5523 4 19C4 18.4477 4.44772 18 5 18C5.55228 18 6 18.4477 6 19Z"
                                      stroke="var(--theme-text-color)" stroke-width="2" stroke-linecap="round"
                                      stroke-linejoin="round"></path>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a title="Mastodon" target="_blank" rel="me" href="https://hachyderm.io/@xlthlx">
                            <span class="screen-reader-text">Mastodon</span>
                            <svg class="xlt-shrink" xmlns="http://www.w3.org/2000/svg" aria-label="Mastodon" role="img" width="32"
                                 height="32" viewBox="0 0 192 192">
                                <path d="M2004.3 228h-.57c-19.87.163-38.97 2.491-50.13 7.601-.5.213-24.58 10.78-24.58 46.99 0 7.394-.14 16.236.09 25.612.4 16.438 2 32.742 7.21 45.957 5.67 14.406 15.47 25.335 32.04 29.72 14.11 3.737 26.23 4.503 35.99 3.967h.01c18.41-1.021 28.71-6.695 28.71-6.695a6.018 6.018 0 0 0 3.16-5.558l-.56-12.178a5.984 5.984 0 0 0-2.56-4.646 5.995 5.995 0 0 0-5.24-.804s-11.04 3.471-23.45 3.047c-4.87-.167-9.84-.357-14.18-1.544-3.91-1.069-7.14-3.148-8.76-7.347 5.59.951 13.45 2.021 22.27 2.425 10.49.481 20.33-.592 30.33-1.785 12.37-1.477 23.76-6.688 31.4-13.091 5.8-4.865 9.47-10.509 10.5-15.801v-.001c3.23-16.623 3.05-40.428 3.04-41.319-.01-36.286-24.23-46.801-24.58-46.951-11.14-5.105-30.25-7.436-50.14-7.599Zm59.9 93.58.09-.471c3.1-15.948 2.73-38.451 2.73-38.451v-.067c0-27.633-17.49-36.04-17.49-36.04a.234.234 0 0 0-.05-.024c-10.05-4.616-27.33-6.379-45.26-6.527h-.41c-17.93.148-35.2 1.911-45.25 6.527l-.06.024s-17.48 8.407-17.48 36.04c0 7.308-.15 16.047.09 25.314v.004c.36 14.96 1.64 29.826 6.37 41.852 4.27 10.836 11.49 19.221 23.95 22.519 12.65 3.349 23.51 4.066 32.26 3.585 9.61-.533 16.56-2.512 20.36-3.891l-.04-.739c-5.11 1.018-12.33 2.033-20 1.771-16.29-.559-32.69-3.029-35.34-23.016a40.2 40.2 0 0 1-.35-5.4 6 6 0 0 1 2.3-4.719 5.998 5.998 0 0 1 5.13-1.109s12.59 3.066 28.55 3.798c9.81.45 19.01-.598 28.36-1.713 9.88-1.18 19.01-5.258 25.11-10.372 3.36-2.814 5.83-5.834 6.43-8.895Zm-54.2-36.244c.68-2.603 3.99-12.807 14.27-12.807 10.68 0 10.54 12.137 10.54 12.137v34.224c0 3.311 2.69 6 6 6s6-2.689 6-6v-34.406s-.68-23.955-22.54-23.955c-10 0-16.43 5.292-20.4 10.778-4.07-5.273-10.62-10.293-20.78-10.293-6.92 0-11.53 2.138-14.68 4.857-6.67 5.747-6.86 14.826-6.81 16.949l.02.455s-.01-.161-.02-.455v-.052 36.342c0 3.311 2.69 6 6 6s6-2.689 6-6v-36.342c0-.169-.01-.338-.02-.507 0 0-.5-4.577 2.66-7.298 1.45-1.252 3.66-1.949 6.85-1.949 10.65 0 14.18 9.844 14.91 12.386v20.233c0 3.311 2.69 6 6 6s6-2.689 6-6v-20.297Z"
                                      style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2"
                                      transform="translate(-1908 -212)" fill="var(--theme-text-color)"/>
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
                    Sign the <?php
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
