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
        <p class="xlt-widget__title">
			<?php $text = ( 'en' === $lang ) ? 'Subscribe to the newsletter' : 'Iscriviti alla Newsletter'; ?>
			<?php $url = ( 'en' === $lang ) ? '/en/' : '/'; ?>
            <a title="<?php echo $text; ?>" class="svg-btn no-under"
               href="https://xlthlx.com/newsletter<?php echo $url; ?>">
				<?php echo xlt_print_svg( '/assets/img/newsletter.svg' ); ?>
            </a>
            <a title="<?php echo $text; ?>" class="svg-btn" href="https://xlthlx.com/newsletter<?php echo $url; ?>">
                <span>Newsletter</span>
            </a>
        </p>
    </section>

    <section id="xlthlx-search" class="widget widget_xlthlx-search">
		<?php get_template_part( 'parts/search-form' ); ?>
    </section>

	<?php if ( ( is_year() || is_month() ) ) { ?>

        <section id="months" class="widget widget_months">
            <p class="xlt-widget__title"><span><?php echo ( 'en' === $lang ) ? 'Months' : 'Mesi'; ?></span></p>
			<?php $month = ( is_year() ) ? '' : get_the_time( 'n' ); ?>

			<?php xlt_get_months( get_the_time( 'Y' ), $month ); ?>
        </section>

        <section id="years" class="widget widget_years">
            <p class="xlt-widget__title"><span><?php echo ( 'en' === $lang ) ? 'Years' : 'Anni'; ?></span></p>

			<?php xlt_get_years( get_the_time( 'Y' ) ); ?>
        </section>

	<?php } ?>
	<?php dynamic_sidebar( 'page-sidebar' ); ?>
</aside>
