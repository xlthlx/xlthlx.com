<?php
/**
 * The template for displaying all pages.
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

	<div class="xlt-row" id="main-content">
		<div class="xlt-ph xlt-spacing xlt-sticky">
			<div class="xlt-ph__wrapper xlt-sticky_top">
                <h2 class="xlt-ph__title"><?php echo get_the_title(); ?></h2>
			</div>
		</div>

		<div class="xlt-content xlt-spacing">
			<article class="post-type-<?php echo get_post_type(); ?>" id="post-<?php echo get_the_ID(); ?>">

				<?php echo ( 'en' === $lang ) ? get_content_en() : apply_filters( 'the_content', get_the_content() ); ?>

			</article>
		</div>

		<div class="xlt-main-sidebar xlt-spacing xlt-sticky">
			<?php get_template_part( 'parts/sidebar-page' ); ?>
		</div>

	</div>

<?php endwhile; ?>


<?php
get_footer();
