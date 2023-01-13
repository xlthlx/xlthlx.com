<?php
/**
 * Sidebar post.
 *
 * @package  xlthlx
 */

?>
<div class="col-md-3">
	<aside class="sidebar mt-md-0 mt-4 ps-md-3 ps-0">
		<?php get_template_part( 'parts/sidebar-image' ); ?>
		<?php dynamic_sidebar( 'post-sidebar' ); ?>
	</aside>
</div>
