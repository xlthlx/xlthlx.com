<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package  xlthlx
 */

global $lang;
get_header();

$title   = ( 'en' === $lang ) ? 'Not found' : 'Non trovato';
$content = ( 'en' === $lang ) ? 'The hamsters running this website have not found what you are looking for.' : 'I criceti che gestiscono questo sito non hanno trovato quello che stavi cercando.';
?>

	<article class="post-type-404" id="post-404">

		<div class="row">
			<div class="col-md-8">

				<div class="row">

					<div class="col-12 d-flex">
						<div class="col-md-12 d-flex">
							<h2 class="display-4 pb-3 shadows"><?php echo $title; ?></h2>
						</div>
					</div>

					<div class="col-md-12 text-break">

						<section class="page-content mb-4">
							<hr class="pt-0 mt-0 mb-4"/>
							<p class="text-center mb-5 mt-5">
								<?php echo $content; ?>
							</p>
							<p>
								<img class="img-fluid mx-auto d-block"
									 src="<?php echo get_template_directory_uri(); ?>/assets/img/404.gif" alt="404"/>
							</p>
							<div class="text-center pt-3 px-5 m-5">
								<?php get_template_part( 'parts/search-form' ); ?>
							</div>
						</section>
					</div>
				</div>

			</div>

			<div class="col-md-4">
				<aside class="sidebar mt-md-0 mt-4 ps-md-4 ps-0">
					<?php dynamic_sidebar( 'page_sidebar' ); ?>
				</aside>
			</div>
		</div>

	</article>

<?php
get_footer();
