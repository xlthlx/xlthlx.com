<?php
/**
 * Sidebar page.
 *
 * @package  xlthlx
 */

global $lang;
?>
<aside class="xlt-widgetarea" role="complementary" aria-label="Sidebar">
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
