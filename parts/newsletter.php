<?php global $lang; ?>
<div id="xlthlx-newsletter" class="widget widget_grey widget_xlthlx-newsletter p-4 mb-4 rounded-0">
	<h3 class="h2 pb-2 shadows">Newsletter</h3>
	<div class="textwidget">
		<?php echo ( 'en' === $lang ) ? 'Do you want to receive an email when a new article is published?' : 'Vuoi ricevere una email quando viene pubblicato un nuovo post?'; ?>
		<br/>
		<?php $form_id = ( 'en' === $lang ) ? 34503 : 34396; ?>
		<?php echo do_shortcode( '[contact-form-7 id="' . $form_id . '"]' ); ?>
	</div>
</div>

