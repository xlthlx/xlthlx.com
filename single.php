<?php
/**
 * The template for displaying all single posts.
 *
 * @package  xlthlx
 */
global $lang;
get_header();
?>

<?php while ( have_posts() ) :
	the_post(); ?>

	<article class="post-type-<?php echo get_post_type(); ?>" id="post-<?php echo get_the_ID(); ?>">

		<div class="row">
			<div class="col-md-8">

				<div class="row">

					<div class="d-flex">
						<div class="col-12 d-flex">
							<h2 class="display-5 pb-3 shadows"><?php echo get_the_title(); ?></h2>
						</div>
					</div>

					<div class="col-md-12 text-break">
						<section class="article-content mb-4">
							<hr class="pt-0 mt-0 mb-2"/>
							<p class="mb-0"><?php echo ( 'en' === $lang ) ? get_date_en() : get_the_date(); ?></p>

							<div class="article-body pr-4">
								<?php echo xlt_old_posts_warning( $lang ); ?>
								<?php echo ( 'en' === $lang ) ? get_content_en() : apply_filters( 'the_content', get_the_content() ); ?>
							</div>

							<?php get_template_part( 'parts/social' ); ?>

							<div class="pt-4">
								<?php get_template_part( 'parts/terms' ); ?>
							</div>

							<hr class="mt-4 mb-0"/>
							<?php get_template_part( 'parts/navigation' ); ?>
						</section>

						<?php comments_template(); ?>
					</div>
				</div>
			</div>

			<?php get_template_part( 'parts/sidebar-post' ); ?>

		</div>
	</article>
<?php endwhile; ?>
<?php
get_footer();
