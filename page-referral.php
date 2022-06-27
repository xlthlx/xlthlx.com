<?php
/**
 * Template Name: Referral
 *
 * @package  xlthlx
 */
global $lang;
get_header();

$ref    = '';
$coffee = '';

$bookmarks = get_bookmarks( array(
	'orderby'       => 'name',
	'order'         => 'ASC',
	'category_name' => 'Referral'
) );

foreach ( $bookmarks as $bookmark ) {
	$ref .= '<p>';
	$ref .= '<a title="' . $bookmark->link_name . '" target="_blank" href="' . $bookmark->link_url . '">' . $bookmark->link_name . '</a>';
	if ( '' !== $bookmark->link_description ) {
		$ref .= '<br />' . $bookmark->link_description;
	}
	$ref .= '</p>';
}

$money = get_bookmarks( array(
	'orderby'       => 'name',
	'order'         => 'ASC',
	'category_name' => 'Money'
) );

foreach ( $money as $send ) {
	$coffee .= '<p>';
	$coffee .= '<a title="' . $send->link_name . '" target="_blank" href="' . $send->link_url . '">' . $send->link_name . '</a>';
	if ( '' !== $send->link_description ) {
		$coffee .= '<br />' . $send->link_description;
	}
	$coffee .= '</p>';
}
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
							<?php echo $ref; ?>
							<h4 class="display-6 mt-4 shadows">
								<?php echo ( 'en' === $lang ) ? 'Buy me a coffee' : 'Offrimi un caffè'; ?>
							</h4>
							<hr class="mt-4 mb-4">
							<?php echo $coffee; ?>
							<?php echo ( 'en' === $lang ) ? get_content_en() : apply_filters( 'the_content', get_the_content() ); ?>
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
