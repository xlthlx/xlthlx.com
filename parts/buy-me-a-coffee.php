<?php global $lang;
$text = ( 'en' === $lang ) ? 'Buy me a coffee' : 'Offrimi un caffè';
?>
<div id="xlthlx-bmc" class="widget widget_grey widget_block p-4 mb-4 rounded-0">
	<div class="textwidget">
		<ul>
			<li>
				<a class="bmc-btn" target="_blank" href="https://buymeacoffee.com/xlthlx">
					<?php echo xlt_print_svg( '/assets/img/bmc.svg' ); ?>
					<span class="bmc-btn-text"><?php echo $text; ?></span>
				</a>
			</li>
		</ul>
	</div>
</div>
