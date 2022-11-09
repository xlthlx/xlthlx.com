<?php
/**
 * The template for displaying all single posts.
 *
 * @package  xlthlx
 */
global $lang;
get_header();
?>

<?php
while ( have_posts() ) :
	the_post();
	?>

	<article class="post-type-<?php echo get_post_type(); ?>" id="post-<?php echo get_the_ID(); ?>">

		<div class="row d-flex flex-row-reverse">
			<div class="col-md-8">

				<div class="row">

					<div class="d-flex">
						<div class="col-12 d-flex">
							<h2 class="display-5 pb-3 shadows text-dark"><?php echo get_the_title(); ?></h2>
						</div>
					</div>

					<div class="col-md-12 text-break">
						<section class="article-content mb-4">
							<hr class="pt-0 mt-0 mb-2"/>
							<p class="mb-0"><?php echo ( 'en' === $lang ) ? get_date_en() : get_the_date(); ?></p>

							<div class="article-body pr-4">
								<?php echo xlt_old_posts_warning( $lang ); ?>
								<?php echo ( 'en' === $lang ) ? get_content_en() : apply_filters( 'the_content',get_the_content() ); ?>
							</div>

							<?php get_template_part( 'parts/social' ); ?>

							<div class="pt-4">
								<?php get_template_part( 'parts/terms' ); ?>
							</div>

							<hr class="mt-4 mb-0"/>
							<?php get_template_part( 'parts/navigation' ); ?>
						</section>

						<?php comments_template(); ?>
						<section id="related">
							<div class="p-2 mb-4 rounded-0">
								<h3 class="h2 pb-2 shadows">Articoli correlati</h3>
								<ul class="two-columns">
									<li>
										<a href="https://xlthlx.com/2022/09/the-queen-is-dead/" rel="bookmark" title="La regina è morta, e anch’io non mi sento tanto bene">La
											regina è morta, e anch’io non mi sento tanto bene</a></li>
									<li>
										<a href="https://xlthlx.com/2022/06/as-it-is-as-it-is-not/" rel="bookmark" title="Com’è, come non è">Com’è,
											come non è</a></li>
									<li>
										<a href="https://xlthlx.com/2008/12/lettera-a-babbo-nachele-2/" rel="bookmark" title="Lettera a Babbo Nachele">Lettera
											a Babbo Nachele</a></li>
									<li>
										<a href="https://xlthlx.com/2022/05/free-time/" rel="bookmark" title="Tempo libero">Tempo
											libero</a></li>
									<li>
										<a href="https://xlthlx.com/2022/05/where-is-your-towel-towelday/" rel="bookmark" title="Where is your towel? #TowelDay">Where
											is your towel? #TowelDay</a></li>
									<li>
										<a href="https://xlthlx.com/2009/05/there-must-be-something-more/" rel="bookmark" title="There must be something more">There
											must be something more</a></li>
								</ul>
							</div>
					</section>
				</div>
			</div>
		</div>

		<?php get_template_part( 'parts/sidebar-post' ); ?>

		</div>
	</article>
<?php endwhile; ?>
<?php
get_footer();
