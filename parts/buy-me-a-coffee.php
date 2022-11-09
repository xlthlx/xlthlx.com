<?php global $lang;
$text = ( 'en' === $lang ) ? 'Buy me a coffee' : 'Offrimi un caffè';
?>
<div id="xlthlx-bmc" class="widget p-4">
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
