<?php
/**
 * Sidebar post.
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
	<section id="xlthlx-archives" class="widget widget_xlthlx-archives">
		<p class="xlt-widget__title">
			<span><?php echo ( 'en' === $lang ) ? 'Topics' : 'Argomenti'; ?></span>
		</p>

		<?php
		if ( function_exists( 'xlt_print_menu' ) ) {
			xlt_print_menu( 'Topics' );
		}
		?>
	</section>

	<section id="xlthlx-archives" class="widget widget_xlthlx-archives">
		<p class="xlt-widget__title">
			<span><?php echo ( 'en' === $lang ) ? 'Archives' : 'Archivi'; ?></span>
		</p>

		<?php
		if ( function_exists( 'xlt_get_years' ) ) {
			xlt_get_years();
		}
		?>
	</section>

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

	<section id="xlthlx-stuff" class="widget widget_xlthlx-stuff">
		<p class="xlt-widget__title">
			<span><?php echo ( 'en' === $lang ) ? 'My stuff' : 'Stuff'; ?></span>
		</p>

		<?php
		if ( function_exists( 'xlt_print_menu' ) ) {
			xlt_print_menu( 'Stuff' );
		}
		?>
	</section>

	<?php dynamic_sidebar( 'post-sidebar' ); ?>
	<section id="xlthlx-coffee" class="widget widget_xlthlx-coffee">
		<div class="xlt-widget__title">
			<?php $text = ( 'en' === $lang ) ? 'Buy me a coffee' : 'Offrimi un caffè'; ?>
			<a title="<?php echo $text; ?>" class="svg-btn no-under" target="_blank"
			   href="https://buymeacoffee.com/xlthlx">
				<?php
				if ( function_exists( 'xlt_print_svg' ) ) {
					echo xlt_print_svg( '/assets/img/bmc.svg' );
				}
				?>
			</a>
			<a title="<?php echo $text; ?>" class="svg-btn" target="_blank" href="https://buymeacoffee.com/xlthlx">
				<span><?php echo $text; ?></span>
			</a>
		</div>
	</section>
	<section id="xlthlx-512kb-club" class="widget widget_xlthlx-512kb-club">
		<div class="xtl-inline">
			<a target="blank" href="https://512kb.club" title="512KB Club Blue Team">
				<span class="kb-club-no-bg">512KB Club</span><span class="kb-club-bg">Blue Team</span>
			</a>
		</div>
	</section>
</aside>
