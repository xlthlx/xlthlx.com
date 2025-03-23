<?php
/**
 * Template Name: Makeup
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
		<div class="xlt-ph xlt-spacing xlt-sticky">
			<div class="xlt-ph__wrapper xlt-sticky_top">
				<h2 class="xlt-ph__title"><?php echo get_the_title(); ?></h2>
			</div>
		</div>

		<div class="xlt-content xlt-spacing">
			<article class="post-type-<?php echo get_post_type(); ?>" id="post-<?php echo get_the_ID(); ?>">

				<?php echo apply_filters( 'the_content', get_the_content() ); ?>

				<ul class="xlt-list">
					<?php
					$bookmarks = get_bookmarks(
						array(
							'orderby'       => 'name',
							'order'         => 'ASC',
							'category_name' => 'Makeup',
						)
					);

					$makeup = '';

					foreach ( $bookmarks as $bookmark ) {
						$makeup .= '<p>';
						$makeup .= '<a title="' . $bookmark->link_name . '" target="_blank" href="' . $bookmark->link_url . '">' . $bookmark->link_name . '</a>';
						if ( '' !== $bookmark->link_description ) {
							$makeup .= '<br />' . $bookmark->link_description;
						}
						$makeup .= '</p>';
					}

					echo $makeup;
					?>
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
