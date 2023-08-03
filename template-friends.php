<?php
/**
 * Template Name: Friends & Others
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
			<div class="xlt-ph__wrapper xlt-sticky_top"><h1 class="xlt-ph__title"><?php echo get_the_title(); ?></h1>
			</div>
		</div>

		<div class="xlt-content xlt-spacing">
			<article class="post-type-<?php echo get_post_type(); ?>" id="post-<?php echo get_the_ID(); ?>">

				<?php echo ( 'en' === $lang ) ? get_content_en() : apply_filters( 'the_content', get_the_content() ); ?>

				<h2><?php echo ( 'en' === $lang ) ? 'Friends' : 'Amici'; ?></h2>

				<ul class="xlt-list">
					<?php wp_list_bookmarks( 'title_li=&categorize=0&category_name=Friends' ); ?>
				</ul>

				<h2><?php echo ( 'en' === $lang ) ? 'Others' : 'Altri'; ?></h2>
				<ul class="xlt-list">
					<?php wp_list_bookmarks( 'title_li=&categorize=0&category_name=Music' ); ?>
				</ul>

				<ul class="xlt-list">
					<?php wp_list_bookmarks( 'title_li=&categorize=0&category_name=Organizations' ); ?>
				</ul>

				<ul class="xlt-list">
					<?php wp_list_bookmarks( 'title_li=&categorize=0&category_name=Fun' ); ?>
				</ul>

				<ul class="xlt-list">
					<?php wp_list_bookmarks( 'title_li=&categorize=0&category_name=Recommended' ); ?>
				</ul>

			</article>
		</div>

		<div class="xlt-main-sidebar xlt-spacing">
			<?php get_template_part( 'parts/sidebar-page' ); ?>
		</div>

	</div>

<?php endwhile; ?>
<?php
get_footer();
