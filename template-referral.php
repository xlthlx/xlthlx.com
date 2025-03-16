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

$bookmarks = get_bookmarks(
	array(
		'orderby'       => 'name',
		'order'         => 'ASC',
		'category_name' => 'Referral',
	)
);

foreach ( $bookmarks as $bookmark ) {
	$ref .= '<p>';
	$ref .= '<a title="' . $bookmark->link_name . '" target="_blank" href="' . $bookmark->link_url . '">' . $bookmark->link_name . '</a>';
	if ( '' !== $bookmark->link_description ) {
		$ref .= '<br />' . $bookmark->link_description;
	}
	$ref .= '</p>';
}

$money = get_bookmarks(
	array(
		'orderby'       => 'name',
		'order'         => 'ASC',
		'category_name' => 'Money',
	)
);

foreach ( $money as $send ) {
	$coffee .= '<p>';
	$coffee .= '<a title="' . $send->link_name . '" target="_blank" href="' . $send->link_url . '">' . $send->link_name . '</a>';
	if ( '' !== $send->link_description ) {
		$coffee .= '<br />' . $send->link_description;
	}
	$coffee .= '</p>';
}
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

				<?php echo apply_filters( 'the_content', get_the_content() ); ?>

				<?php echo $ref; ?>
				<h2><?php echo ( 'en' === $lang ) ? 'Buy me a coffee' : 'Offrimi un caffè'; ?></h2>
				<?php echo $coffee; ?>

			</article>
		</div>

		<div class="xlt-main-sidebar xlt-spacing">
			<?php get_template_part( 'parts/sidebar-page' ); ?>
		</div>

	</div>

<?php endwhile; ?>
<?php
get_footer();
