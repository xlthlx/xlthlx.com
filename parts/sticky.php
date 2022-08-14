<?php
global $lang,$post;
$more = "Continua a leggere: '";
if ( 'en' === $lang ) {
	$more = "Keep reading: '";
}
?>
<div class="row g-0 rounded-0 overflow-hidden flex-lg-row flex-column-reverse mb-4 p-5">
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
				<svg xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" x="0px" y="0px" viewBox="0 0 512 512">
					<path fill="currentColor" d="M505.183,239.544L388.819,123.179c-6.654-6.658-16.668-8.645-25.363-5.046
	c-8.696,3.603-14.367,12.089-14.367,21.501v93.092H23.273C10.42,232.727,0,243.147,0,256s10.42,23.273,23.273,23.273h325.818v93.091
	c0,9.413,5.669,17.9,14.367,21.501c2.878,1.193,5.904,1.773,8.901,1.773c6.056,0,12.009-2.365,16.46-6.819l116.364-116.364
	C514.273,263.368,514.273,248.633,505.183,239.544z"/>
				</svg>
			</a></p>
	</div>
	<div class="col-auto d-flex pb-md-0 pb-3">
		<?php if ( get_post_thumbnail_id( $post ) ) {
			echo xlt_get_sticky_img( get_post_thumbnail_id( $post ),get_the_title() );
		}
		?>
	</div>
</div>

