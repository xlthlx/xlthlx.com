<?php
/**
 * Template part for footer navbar.
 *
 * @package  xlthlx
 */

$menu_items = xlt_get_menu_items( 'footer' ); ?>
<div id="footer" class="xlt-nav_footer">
	<?php foreach ( $menu_items as $menu_item ) { ?>
	<a title="<?php echo $menu_item['title']; ?>" <?php echo $menu_item['target']; ?> href="<?php echo $menu_item['url']; ?>">
		<?php echo $menu_item['title']; ?>
	</a>
	<?php } ?>
</div>
