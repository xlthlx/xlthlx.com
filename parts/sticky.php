<?php
/**
 * Sticky post.
 *
 * @package  xlthlx
 */

global $lang,$post;
$more = "Continua a leggere: '";
if ( 'en' === $lang ) {
	$more = "Keep reading: '";
}
?>
<div class="row g-0 rounded-0 overflow-hidden flex-lg-row flex-column-reverse">
	<div class="col d-flex flex-column position-static">
		<h2 class="display-4 font-italic shadows">
			<a class="text-dark" href="<?php echo get_the_permalink(); ?>"
			   title="<?php echo $more . get_the_title(); ?>'">
				<?php echo get_the_title(); ?>
			</a>
		</h2>
		<p class="card-text card-text mb-auto me-5 mt-3"><?php echo xlt_get_excerpt( 40 ); ?>
			<a href="<?php echo get_the_permalink(); ?>" title="<?php echo $more . get_the_title(); ?>"
			   class="display-6 text-decoration-none arrow ln-0 align-middle">
				<svg fill="currentColor" style="width:20px;height:20px" aria-label="<?php echo $more . get_the_title(); ?>" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="-32 0 512 512">
					<path d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z"/>
				</svg>
			</a></p>
	</div>
	<div class="col-auto d-flex pb-md-0 pb-3">
		<?php
		if ( get_post_thumbnail_id( $post ) ) {
			echo xlt_get_sticky_img( get_post_thumbnail_id( $post ), get_the_title() );
		}
		?>
	</div>
</div>

