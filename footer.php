<?php
/**
 * Footer.
 *
 * @package  xlthlx
 */

global $lang, $site_url, $site_name; ?>
<footer class="xlt-f">
	<div class="xlt-row xlt-row_break">
		<?php if ( is_singular( 'post' ) ) { ?>
		<div class="xlt-f__col">
			<aside class="xlt-widgetarea xlt-spacing" role="complementary" aria-label="Footer Sidebar Left">
				<?php dynamic_sidebar( 'footer-sidebar-left' ); ?>
			</aside>
		</div>
		<div class="xlt-f__col">
			<aside class="xlt-widgetarea xlt-spacing" role="complementary" aria-label="Footer Sidebar Center">
				<section id="xlthlx-related" class="widget widget_xlthlx-related">
					<p class="xlt-widget__title">
						<span><?php echo ( 'en' === $lang ) ? 'Related articles' : 'Articoli correlati'; ?></span>
					</p>

					<?php
					if ( function_exists( 'xlt_related_links' ) ) {
						echo xlt_related_links();
					}
					?>
				</section>
				<?php dynamic_sidebar( 'footer-sidebar-center' ); ?>
			</aside>
		</div>
		<div class="xlt-f__col">
			<aside class="xlt-widgetarea xlt-spacing" role="complementary" aria-label="Footer Sidebar Right">
				<?php dynamic_sidebar( 'footer-sidebar-right' ); ?>
			</aside>
		</div>
	</div>
	<div class="xlt-row xlt-row_break">
		<?php } ?>
		<div class="xlt-f__col">
			<aside class="xlt-spacing"></aside>
		</div>
		<div class="xlt-f__col">
			<aside class="xlt-spacing"></aside>
		</div>
		<div class="xlt-f__col">
			<aside class="xlt-spacing"></aside>
		</div>
	</div>

	<div class="xlt-row xlt-row_break">
		<div class="xlt-copy"></div>
		<div class="xlt-copy">
			<p class="xtl-inline" prefix="dct: https://purl.org/dc/terms/ cc: https://creativecommons.org/ns#">
				<a title="by <?php echo $site_name; ?>"
				   href="<?php echo $site_url; ?>" property="cc:attributionName" rel="cc:attributionURL">
					<?php echo $site_name; ?>
				</a>&nbsp;
				<a rel="license noreferrer noopener" href="https://creativecommons.org/licenses/by-nc-sa/4.0/"
				   title="Creative Commons License: Attribution-NonCommercial-ShareAlike" target="_blank">
					<svg class="creative" aria-label="Creative Commons" role="img" xmlns="http://www.w3.org/2000/svg"
						 viewBox="0 0 496 512">
						<path fill="currentColor"
							  d="M245.83 214.87l-33.22 17.28c-9.43-19.58-25.24-19.93-27.46-19.93-22.13 0-33.22 14.61-33.22 43.84 0 23.57 9.21 43.84 33.22 43.84 14.47 0 24.65-7.09 30.57-21.26l30.55 15.5c-6.17 11.51-25.69 38.98-65.1 38.98-22.6 0-73.96-10.32-73.96-77.05 0-58.69 43-77.06 72.63-77.06 30.72-.01 52.7 11.95 65.99 35.86zm143.05 0l-32.78 17.28c-9.5-19.77-25.72-19.93-27.9-19.93-22.14 0-33.22 14.61-33.22 43.84 0 23.55 9.23 43.84 33.22 43.84 14.45 0 24.65-7.09 30.54-21.26l31 15.5c-2.1 3.75-21.39 38.98-65.09 38.98-22.69 0-73.96-9.87-73.96-77.05 0-58.67 42.97-77.06 72.63-77.06 30.71-.01 52.58 11.95 65.56 35.86zM247.56 8.05C104.74 8.05 0 123.11 0 256.05c0 138.49 113.6 248 247.56 248 129.93 0 248.44-100.87 248.44-248 0-137.87-106.62-248-248.44-248zm.87 450.81c-112.54 0-203.7-93.04-203.7-202.81 0-105.42 85.43-203.27 203.72-203.27 112.53 0 202.82 89.46 202.82 203.26-.01 121.69-99.68 202.82-202.84 202.82z"></path>
					</svg>
					<svg class="creative" aria-label="Creative Commons Attribution" role="img"
						 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512">
						<path fill="currentColor"
							  d="M314.9 194.4v101.4h-28.3v120.5h-77.1V295.9h-28.3V194.4c0-4.4 1.6-8.2 4.6-11.3 3.1-3.1 6.9-4.7 11.3-4.7H299c4.1 0 7.8 1.6 11.1 4.7 3.1 3.2 4.8 6.9 4.8 11.3zm-101.5-63.7c0-23.3 11.5-35 34.5-35s34.5 11.7 34.5 35c0 23-11.5 34.5-34.5 34.5s-34.5-11.5-34.5-34.5zM247.6 8C389.4 8 496 118.1 496 256c0 147.1-118.5 248-248.4 248C113.6 504 0 394.5 0 256 0 123.1 104.7 8 247.6 8zm.8 44.7C130.2 52.7 44.7 150.6 44.7 256c0 109.8 91.2 202.8 203.7 202.8 103.2 0 202.8-81.1 202.8-202.8.1-113.8-90.2-203.3-202.8-203.3z"></path>
					</svg>
					<svg class="creative" aria-label="Creative Commons Non Commercial" role="img"
						 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512">
						<path fill="currentColor"
							  d="M247.6 8C387.4 8 496 115.9 496 256c0 147.2-118.5 248-248.4 248C113.1 504 0 393.2 0 256 0 123.1 104.7 8 247.6 8zM55.8 189.1c-7.4 20.4-11.1 42.7-11.1 66.9 0 110.9 92.1 202.4 203.7 202.4 122.4 0 177.2-101.8 178.5-104.1l-93.4-41.6c-7.7 37.1-41.2 53-68.2 55.4v38.1h-28.8V368c-27.5-.3-52.6-10.2-75.3-29.7l34.1-34.5c31.7 29.4 86.4 31.8 86.4-2.2 0-6.2-2.2-11.2-6.6-15.1-14.2-6-1.8-.1-219.3-97.4zM248.4 52.3c-38.4 0-112.4 8.7-170.5 93l94.8 42.5c10-31.3 40.4-42.9 63.8-44.3v-38.1h28.8v38.1c22.7 1.2 43.4 8.9 62 23L295 199.7c-42.7-29.9-83.5-8-70 11.1 53.4 24.1 43.8 19.8 93 41.6l127.1 56.7c4.1-17.4 6.2-35.1 6.2-53.1 0-57-19.8-105-59.3-143.9-39.3-39.9-87.2-59.8-143.6-59.8z"></path>
					</svg>
					<svg class="creative" aria-label="Creative Commons Share Alike" role="img"
						 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512">
						<path fill="currentColor"
							  d="M247.6 8C389.4 8 496 118.1 496 256c0 147.1-118.5 248-248.4 248C113.6 504 0 394.5 0 256 0 123.1 104.7 8 247.6 8zm.8 44.7C130.2 52.7 44.7 150.6 44.7 256c0 109.8 91.2 202.8 203.7 202.8 103.2 0 202.8-81.1 202.8-202.8.1-113.8-90.2-203.3-202.8-203.3zM137.7 221c13-83.9 80.5-95.7 108.9-95.7 99.8 0 127.5 82.5 127.5 134.2 0 63.6-41 132.9-128.9 132.9-38.9 0-99.1-20-109.4-97h62.5c1.5 30.1 19.6 45.2 54.5 45.2 23.3 0 58-18.2 58-82.8 0-82.5-49.1-80.6-56.7-80.6-33.1 0-51.7 14.6-55.8 43.8h18.2l-49.2 49.2-49-49.2h19.4z"></path>
					</svg>
				</a>
			</p>
			&nbsp;&mdash;&nbsp;
			<?php get_template_part( 'parts/navbar-footer' ); ?>
		</div>
		<div class="xlt-copy">
			<p>
				<a id="top-arrow" title="Back to top" class="xlt-arrow-up" href="#top">
					<svg style="transform: rotate(270deg);" fill="currentColor" data-icon="arrow-up" aria-label="Back to top" role="img" height="18" width="29" viewBox="0 0 50 31" xmlns="http://www.w3.org/2000/svg">
						<path d="m1060.3125 264.84375c-.625-.625003-.625-1.249997 0-1.875l10.46875-11.5625h-44.53125c-.83334 0-1.25-.41666-1.25-1.25s.41666-1.25 1.25-1.25h44.53125l-10.46875-11.5625c-.625-.625-.625-1.25 0-1.875s1.25-.625 1.875 0c8.22921 9.06255 12.39583 13.64583 12.5 13.75.20833.20833.3125.52083.3125.9375s-.10417.72917-.3125.9375l-12.5 13.75c-.20833.208334-.52083.3125-.9375.3125s-.72917-.104166-.9375-.3125z"
							  fill-rule="evenodd" transform="translate(-1025 -235)" />
					</svg>
				</a>
			</p>
		</div>
	</div>

</footer>

<div class="xlt-grid">
	<span class="xlt-grid_vertical"></span>
	<span class="xlt-grid_vertical"></span>
	<span class="xlt-grid_vertical"></span>
	<span class="xlt-grid_vertical"></span>
</div>

</div>
<?php wp_footer(); ?>
<span id="db3bd4a3c96f1fe80cd12d8df05e6320"></span>

</body>
</html>
