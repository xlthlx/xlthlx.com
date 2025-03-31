<?php
/**
 * Sidebar page.
 *
 * @package  xlthlx
 */

global $lang;
?>
<aside class="xlt-widgetarea" role="complementary" aria-label="Sidebar">

	<section id="xlthlx-newsletter" class="widget widget_xlthlx-newsletter">
		<div class="xlt-widget__title">
			<?php $text = ( 'en' === $lang ) ? 'Subscribe to the newsletter' : 'Iscriviti alla Newsletter'; ?>
			<?php $url = ( 'en' === $lang ) ? '/en/' : '/'; ?>
			<a title="<?php echo $text; ?>" class="svg-btn no-under"
			   href="https://xlthlx.com/newsletter<?php echo $url; ?>">
				<?php
				if ( function_exists( 'xlt_print_svg' ) ) {
					echo xlt_print_svg( '/assets/img/newsletter.svg' );
				}
				?>
			</a>
			<a title="<?php echo $text; ?>" class="svg-btn"
			   href="https://xlthlx.com/newsletter<?php echo $url; ?>">
				<span>Newsletter</span>
			</a>
		</div>
	</section>

	<?php if ( ( is_year() || is_month() ) ) { ?>

		<section id="months" class="widget widget_months">
			<p class="xlt-widget__title"><span><?php echo ( 'en' === $lang ) ? 'Months' : 'Mesi'; ?></span></p>
			<?php $month = ( is_year() ) ? '' : get_the_time( 'n' ); ?>

			<?php
			if ( function_exists( 'xlt_get_months' ) ) {
				xlt_get_months( get_the_time( 'Y' ), $month ); }
			?>
		</section>

		<section id="years" class="widget widget_years">
			<p class="xlt-widget__title"><span><?php echo ( 'en' === $lang ) ? 'Years' : 'Anni'; ?></span></p>

			<?php
			if ( function_exists( 'xlt_get_years' ) ) {
				xlt_get_years( get_the_time( 'Y' ) ); }
			?>
		</section>

	<?php } ?>
	<section id="xlthlx-pages" class="widget widget_xlthlx-pages">
		<p class="xlt-widget__title">
			<span><?php echo ( 'en' === $lang ) ? 'Pages' : 'Pagine'; ?></span>
		</p>

		<?php
		if ( function_exists( 'xlt_print_menu' ) ) {
			xlt_print_menu( 'Main' );
		}
		?>
	</section>
	<?php dynamic_sidebar( 'page-sidebar' ); ?>
	<section id="xlthlx-512kb-club" class="widget widget_xlthlx-512kb-club">
		<div class="xtl-inline">
			<a class="kb-club" target="blank" href="https://512kb.club" title="512KB Club Blue Team">
				<span class="kb-club-no-bg">512KB Club</span><span class="kb-club-bg">Blue Team</span>
			</a>
		</div>
	</section>
</aside>
