<?php
global $lang, $post;
$more = ( 'en' === $lang ) ? "Keep reading: '":"Continua a leggere: '";
?>
<article class="tease tease-<?php echo $post->post_type; ?>" id="tease-<?php echo $post->ID; ?>">
	<div class="row g-0 border overflow-hidden flex-md-row mb-4 border-0 h-md-250 position-relative rounded-0">

		<h2 class="mb-1 h1 shadows"><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h2>
		<p class="text-muted"><?php echo ( 'en' === $lang ) ? get_date_en() : get_the_date(); ?></p>
		<p class="card-text px-0 col-md-8 pb-4"><?php echo xlt_get_excerpt( 50 ); ?>
			<a aria-label="<?php echo $more . get_the_title(); ?>"
			   href="<?php echo get_the_permalink(); ?>"
			   class="display-6 stretched-link text-decoration-none arrow ln-0 align-middle">
				&#8674;
			</a>
		</p>
		<hr/>
	</div>
</article>
