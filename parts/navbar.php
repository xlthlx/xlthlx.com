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

	<div class="xlt-h__right-col xlt-spacing">
		<div class="xlt-meta__tools">
			<ul>
				<li>
					<a class="xlt-shrink" href="<?php echo $site_url; ?>" title="Poe" id="btn-poe">
						<span class="screen-reader-text">Poe</span>
						<svg width="32" height="26" aria-label="Poe" role="img" xmlns="http://www.w3.org/2000/svg"
							 xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" viewBox="0 0 40 40">
						  <image xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAAXNSR0IArs4c6QAAAgZJREFUWEftmF2ShCAMhPGaej69pluwhm1jAh2cnfLBeZiySiQfnV+d0sN/08P50l3APXDAIVtDD6WUCti+83zTVE2FbIYWH2rtETCtMIDKrSZDFNCEM4wW48xBespGAC9wsjmCLMuS1nUtgNZ9L2aPtRceFtCEEzCEsq6z8YCaJyYaEF3GGNRKMoCgeiijqnoYa9mgQFgxqN2+bduQioyCpnvneS7hlA3n6xx3GTj/8rWojIdgVNSx2AN0S4qoJqACiKBaNSY0tJu7gJh1WgHLtQIszyHkpwFrmxCwngEEtkKg93yt3L9d5+/PqU2nPmZB6qRBA3cA0c0tF9d+iyf3VLAyfDQGGcDLFNByc6v8oJJMFqM3876WgiVzW+5DWNkQu4qUH10rPwF4KivandrVGQQVwtNj+WGTw5p8UMHupOIlii4tWAtRzcBwW4cNAaRnPEsNnFp0N2HHLgteYpCGk+zyYkkX7mjMeS6mAUdjKeparKfZxS/gq2AvOUYVaj0ncyFVZr6dHF4vdgv13XIRVRinaqqTPAWwFH1d+b/tXvadxBxWo66KrtdwdawmNqKLObGXucSCiwAenre/Zt0JA+jf5nTfe6vTp6W+t7HDxLH5/33dEuUM97gHQXjPrahKWEFtAF4Pmi9gsu4FNBSo41sjgy8fAbCdNXtysCxYsRUJk/DzP0Upri7dyfyeAAAAAElFTkSuQmCC"
								 width="40" height="40"/>
						</svg>
					</a>
				</li>
				<li>
					<a class="xlt-shrink" href="<?php echo $site_url; ?>mode/" title="Dark mode" id="btn-toggle">
						<span class="screen-reader-text">Dark mode</span>
						<svg fill="var(--theme-text-color)" width="32" height="26" aria-label="Dark mode" role="img"
							 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
							<path d="M18 27h-4a2 2 0 0 1-2-2v-3.84a10 10 0 0 1-6-9.47A10.14 10.14 0 0 1 15.69 2 10 10 0 0 1 20 21.16V25a2 2 0 0 1-2 2ZM15.75 4A8.12 8.12 0 0 0 8 11.75a8 8 0 0 0 5.33 7.79 1 1 0 0 1 .67.94V25h4v-4.52a1 1 0 0 1 .67-.94 8 8 0 0 0 2.9-13.28A7.85 7.85 0 0 0 15.75 4ZM19 30h-6a1 1 0 0 1 0-2h6a1 1 0 0 1 0 2Z"/>
							<path d="M15 24v-4.52a9 9 0 0 1-6-8.76c.09-3 1.71-4.93 4.52-6.32C9.49 4.47 7.12 8 7 11.72a9 9 0 0 0 6 8.76V25a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1h-3a1 1 0 0 1-1-1Z"/>
						</svg>
					</a>
				</li>
				<li>
					<a class="xlt-shrink" title="Feed RSS" target="_blank" href="<?php echo $site_url; ?>feed/">
						<span class="screen-reader-text">Feed RSS</span>
						<svg width="32" height="26" aria-label="Feed RSS" role="img" viewBox="0 0 24 24" fill="none"
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
		<button type="button" class="xlt-h-nav__trigger xlt-shrink">
			<span></span>
			<span class="screen-reader-text">Menu</span>
		</button>
		<div class="xlt-nav__wrapper">
			<nav id="xlt-nav-primary" class="xlt-nav">
				<div class="menu-main-container">
					<ul id="menu-main" class="menu">
						<?php
						$menu_items = xlt_get_menu_items( 'primary' );
						if ( ! empty( $menu_items ) ) {
							foreach ( $menu_items as $menu_item ) {
								?>

								<?php if ( isset( $menu_item['submenu'] ) ) { ?>
								<li class="xlt-nav-title <?php echo $menu_item['classes']; ?>">
									<?php if ( $menu_item['url'] ) { ?>
										<a<?php echo $menu_item['target']; ?> href="<?php echo $menu_item['url']; ?>"
																			   title="<?php echo $menu_item['title']; ?>">
											<?php echo $menu_item['title']; ?>
										</a>
									<?php } else { ?>
										<?php echo $menu_item['title']; ?>
									<?php } ?>
									<ul class="sub-menu">
										<?php foreach ( $menu_item['submenu'] as $menu_subitem ) { ?>
											<li class="<?php echo $menu_subitem['classes']; ?>">
												<?php if ( $menu_subitem['url'] ) { ?>
													<a<?php echo $menu_subitem['target']; ?>
															title="<?php echo $menu_subitem['title']; ?>"
															href="<?php echo $menu_subitem['url']; ?>">
														<?php echo $menu_subitem['title']; ?>
													</a>
												<?php } else { ?>
													<?php echo $menu_subitem['title']; ?>
												<?php } ?>
											</li>
										<?php } ?>
									</ul>
								</li>
							<?php } else { ?>
								<li class="xlt-nav-title <?php echo $menu_item['classes']; ?>">
									<?php if ( $menu_item['url'] ) { ?>
										<a<?php echo $menu_item['target']; ?> href="<?php echo $menu_item['url']; ?>"
																			   title="<?php echo $menu_item['title']; ?>">
											<?php echo $menu_item['title']; ?>
										</a>
									<?php } else { ?>
										<?php echo $menu_item['title']; ?>
									<?php } ?>
								</li>
							<?php } ?>
								<?php
							} 
						}
						?>
					</ul>
				</div>
			</nav>
		</div>

	</div>
</header>
