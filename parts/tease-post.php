<?php
global $lang,$post;
$more = ( 'en' === $lang ) ? "Keep reading: '" : "Continua a leggere: '";
?>
<article class="tease tease-<?php echo $post->post_type; ?>" id="tease-<?php echo $post->ID; ?>">
	<div class="row g-0 border overflow-hidden flex-md-row mb-4 border-0 h-md-250 position-relative rounded-0">

		<h2 class="mb-1 h1 shadows"><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h2>
		<p class="text-muted"><?php echo ( 'en' === $lang ) ? get_date_en() : get_the_date(); ?></p>
		<p class="card-text px-0 col-md-8 pb-4"><?php echo xlt_get_excerpt( 50 ); ?>
			<a aria-label="<?php echo $more . get_the_title(); ?>" href="<?php echo get_the_permalink(); ?>"
			   class="display-6 stretched-link text-decoration-none arrow ln-0 align-middle">
				<svg xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" x="0px" y="0px" viewBox="0 0 512 512">
					<path fill="currentColor" d="M505.183,239.544L388.819,123.179c-6.654-6.658-16.668-8.645-25.363-5.046
	c-8.696,3.603-14.367,12.089-14.367,21.501v93.092H23.273C10.42,232.727,0,243.147,0,256s10.42,23.273,23.273,23.273h325.818v93.091
	c0,9.413,5.669,17.9,14.367,21.501c2.878,1.193,5.904,1.773,8.901,1.773c6.056,0,12.009-2.365,16.46-6.819l116.364-116.364
	C514.273,263.368,514.273,248.633,505.183,239.544z"/>
				</svg>
			</a>
		</p>
		<hr/>
	</div>
</article>
