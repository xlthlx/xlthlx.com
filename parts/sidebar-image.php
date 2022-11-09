<?php
global $lang;
if ( ( 'en' === $lang ) ) { ?>
	<div id="xlthlx-fix" class="widget p-4">
		<figure class="wp-block-image size-full is-style-default">
			<a title="#FixTheDigitalStatus!" href="https://the3million.org.uk/fix-the-digital-status" target="_blank">
				<picture>
					<source srcset="<?php echo get_template_directory_uri(); ?>/assets/img/fix-digital-status.webp" type="image/webp">
					<source srcset="<?php echo get_template_directory_uri(); ?>/assets/img/fix-digital-status.jpg" type="image/jpeg">
					<img width="300" height="120" src="<?php echo get_template_directory_uri(); ?>/assets/img/fix-digital-status.jpg" alt="#FixTheDigitalStatus!" class="img-fluid" srcset="<?php echo get_template_directory_uri(); ?>/assets/img/fix-digital-status.jpg 300w, <?php echo get_template_directory_uri(); ?>/assets/img/fix-digital-status-150x60.jpg 150w" sizes="(max-width: 300px) 100vw, 300px">
				</picture>
			</a>
		</figure>
	</div>
<?php } else { ?>
	<div id="xlthlx-exit" class="widget p-4">
		<figure class="wp-block-image size-full is-style-default">
			<a title="Sbattèzzati!" href="https://www.sbattezzati.it/" target="_blank">
				<picture>
					<source srcset="<?php echo get_template_directory_uri(); ?>/assets/img/exit.webp" type="image/webp">
					<source srcset="<?php echo get_template_directory_uri(); ?>/assets/img/exit.jpg" type="image/jpeg">
					<img width="300" height="78" src="<?php echo get_template_directory_uri(); ?>/assets/img/exit.jpg" alt="Sbattèzzati!" class="img-fluid" srcset="<?php echo get_template_directory_uri(); ?>/assets/img/exit.jpg 300w, <?php echo get_template_directory_uri(); ?>/assets/img/exit-150x39.jpg 150w" sizes="(max-width: 300px) 100vw, 300px">
				</picture>
			</a>
		</figure>
	</div>
	<?php
}
