<?php
global $lang, $post;
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
			   class="display-6 text-decoration-none arrow ln-0 align-middle">&#8674;</a></p>
	</div>
	<div class="col-auto d-flex pb-md-0 pb-3">
		<?php if ( get_post_thumbnail_id( $post ) ) {
			echo xlt_get_sticky_img( get_post_thumbnail_id( $post ), get_the_title() );
		}
		?>
	</div>
</div>

