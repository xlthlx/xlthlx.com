<?php global $lang; ?>
	<div id="xlthlx-newsletter" class="widget widget_grey widget_xlthlx-newsletter p-4 mb-4 rounded-0">
		<h3 class="font-italic pb-2">Newsletter</h3>
		<div class="textwidget">
			<?php echo ( 'en' === $lang ) ? 'Do you want to receive an email when a new article is published?' : 'Vuoi ricevere una email quando viene pubblicato un nuovo post?'; ?>
			<br/>
			<?php $form_id = ( 'en' === $lang ) ? 34503 : 34396; ?>
			<?php echo do_shortcode( '[contact-form-7 id="' . $form_id . '"]' ); ?>
		</div>
	</div>
<?php if ( ( 'en' === $lang ) ) { ?>
	<div id="xlthlx-fix" class="widget widget_grey widget_block p-4 mb-4 rounded-0">
		<a title="#FixTheDigitalStatus!" href="https://www.the3million.org.uk/fix-the-digital-status" target="_blank">
			<img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/assets/img/fix-digital-status.jpg"
				 class="img-fluid" alt="#FixTheDigitalStatus!" width="300" height="120">
		</a>
	</div>
<?php } else { ?>
	<div id="xlthlx-exit" class="widget widget_grey widget_block p-4 mb-4 rounded-0">
		<a title="Sbattèzzati!" href="https://www.sbattezzati.it/" target="_blank">
			<img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/assets/img/exit.jpg" class="img-fluid"
				 alt="Sbattèzzati!" width="300" height="78">
		</a>
	</div>
<?php }
