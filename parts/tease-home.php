<?php
global $lang, $post;
$more = ( 'en' === $lang ) ? "Keep reading: '":"Continua a leggere: '";
?>
<div class="col-md-6">
	<article class="tease tease-<?php echo $post->post_type; ?>" id="tease-<?php echo $post->ID; ?>">
		<div class="row g-0 border overflow-hidden flex-md-row mb-4 border-0 h-md-250 position-relative rounded-0">
			<div class="col px-4 py-3 d-flex flex-column position-static min-h-200">
				<span class="d-inline-block mb-2 text-primary fw-bold">
					<?php get_template_part( 'parts/terms' ); ?>
				</span>
				<h2 class="display-6 mb-3 shadows"><?php echo get_the_title(); ?></h2>
				<p class="card-text mb-auto me-5"><?php echo xlt_get_excerpt( 20 ); ?>
					<a aria-label="<?php echo $more . get_the_title(); ?>" href="<?php echo get_the_permalink(); ?>"
					   class="display-6 stretched-link text-decoration-none arrow ln-0 align-middle">
						&#8674;
					</a>
				</p>
			</div>
		</div>
	</article>
</div>
