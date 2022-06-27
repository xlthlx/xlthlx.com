<?php
/**
 * Template Name: Links
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

					<div class="col-12 d-flex">
						<div class="col-md-12 d-flex">
							<h2 class="display-4 pb-3 shadows"><?php echo get_the_title(); ?></h2>
						</div>
					</div>

					<div class="col-md-12 text-break">

						<section class="page-content mb-4">
							<hr class="pt-0 mt-0 mb-4"/>
							<?php echo ( 'en' === $lang ) ? get_content_en() : apply_filters( 'the_content', get_the_content() ); ?>
							<ul class="list-unstyled">
								<?php wp_list_bookmarks( 'title_li=&categorize=0&category_name=Music' ); ?>
							</ul>

							<ul class="list-unstyled">
								<?php wp_list_bookmarks( 'title_li=&categorize=0&category_name=Organizations' ); ?>
							</ul>

							<ul class="list-unstyled">
								<?php wp_list_bookmarks( 'title_li=&categorize=0&category_name=Fun' ); ?>
							</ul>

							<ul class="list-unstyled">
								<?php wp_list_bookmarks( 'title_li=&categorize=0&category_name=Recommended' ); ?>
							</ul>
						</section>
					</div>
				</div>

			</div>

			<?php get_template_part( 'parts/sidebar-page' ); ?>
		</div>

	</article>

<?php endwhile; ?>
<?php
get_footer();
