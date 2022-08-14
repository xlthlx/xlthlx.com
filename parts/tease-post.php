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
				<svg fill="currentColor" style="width:20px;height:20px" aria-label="<?php echo $more . get_the_title(); ?>" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="-32 0 512 512">
					<path d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z"/>
				</svg>
			</a>
		</p>
		<hr/>
	</div>
</article>
