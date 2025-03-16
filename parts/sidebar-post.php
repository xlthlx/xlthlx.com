<?php
/**
 * Sidebar post.
 *
 * @package  xlthlx
 */

global $lang;
?>
<aside class="xlt-widgetarea xlt-sticky_top" role="complementary" aria-label="Sidebar">
	<section id="xlthlx-search" class="widget widget_xlthlx-search">
		<?php get_template_part( 'parts/search-form' ); ?>
	</section>

	<section id="xlthlx-buy-coffee" class="widget widget_xlthlx-buy-coffee">
		<?php $text = ( 'en' === $lang ) ? 'Buy me a coffee' : 'Offrimi un caffè'; ?>
		<p class="xlt-widget__title">
			<a title="<?php echo $text; ?>" class="svg-btn no-under" target="_blank" href="https://buymeacoffee.com/xlthlx">
				<?php if ( function_exists('xlt_print_svg') ) { echo xlt_print_svg( '/assets/img/bmc.svg' ); } ?>
			</a>
			<a title="<?php echo $text; ?>" class="svg-btn" target="_blank" href="https://buymeacoffee.com/xlthlx">
				<span><?php echo $text; ?></span>
			</a>
		</p>
	</section>

	<section id="xlthlx-image" class="widget widget_xlthlx-image">
		<?php
		if ( ( 'en' === $lang ) ) {
			?>
			<figure class="wp-block-image size-full is-style-default">
				<a title="#FixTheDigitalStatus!" href="https://the3million.org.uk/fix-the-digital-status"
				   target="_blank">
					<img width="300" height="120"
						 src="<?php echo get_template_directory_uri(); ?>/assets/img/fix-digital-status.jpg"
						 alt="#FixTheDigitalStatus!"
						 srcset="<?php echo get_template_directory_uri(); ?>/assets/img/fix-digital-status.jpg 300w, <?php echo get_template_directory_uri(); ?>/assets/img/fix-digital-status-150x60.jpg 150w"
						 sizes="(max-width: 300px) 100vw, 300px">
				</a>
			</figure>
		<?php } else { ?>
			<figure class="wp-block-image size-full is-style-default">
				<a title="Sbattèzzati!" href="https://www.sbattezzati.it/" target="_blank">
					<img width="300" height="78"
						 src="<?php echo get_template_directory_uri(); ?>/assets/img/exit.jpg" alt="Sbattèzzati!"
						 srcset="<?php echo get_template_directory_uri(); ?>/assets/img/exit.jpg 300w, <?php echo get_template_directory_uri(); ?>/assets/img/exit-150x39.jpg 150w"
						 sizes="(max-width: 300px) 100vw, 300px">
				</a>
			</figure>
		<?php } ?>
	</section>

	<?php dynamic_sidebar( 'post-sidebar' ); ?>
</aside>
