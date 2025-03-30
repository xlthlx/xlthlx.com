<?php
/**
 * The template for displaying all pages.
 *
 * @package  xlthlx
 */

global $lang;
get_header();
?>
<?php get_template_part( 'parts/first-row' ); ?>
<?php
while ( have_posts() ) :
	the_post();
	?>

	<div class="xlt-row" id="main-content">
		<div class="xlt-ph xlt-spacing"></div>

		<div class="xlt-content xlt-spacing xlt-top-smaller">
			<div class="xlt-ph__wrapper">
				<h2 class="xlt-ph__title"><?php echo get_the_title(); ?></h2>
			</div>
			<article class="post-type-<?php echo get_post_type(); ?>" id="post-<?php echo get_the_ID(); ?>">

				<?php echo apply_filters( 'the_content', get_the_content() ); ?>

			</article>
		</div>

		<div class="xlt-main-sidebar xlt-spacing xlt-top-smaller">
			<?php get_template_part( 'parts/sidebar-page' ); ?>
		</div>

	</div>

<?php endwhile; ?>


<?php
get_footer();
