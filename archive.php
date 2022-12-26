<?php
/**
 * The template for displaying archives.
 *
 * @package  xlthlx
 */

global $lang, $wp_query;
get_header();
$archive_title = ( 'en' === $lang ) ? 'Archive' : 'Archivio';

$month = get_the_time( 'F' );
if ( 'en' === $lang ) {
	$month = get_trans( $month );
}

if ( is_day() ) {
	$archive_title = get_the_date( 'd' ) . ' ' . $month . ' ' . get_the_date( 'Y' );
} elseif ( is_month() ) {
	$archive_title = $month . ' ' . get_the_date( 'Y' );
} elseif ( is_year() ) {
	$archive_title = get_the_date( 'Y' );
} elseif ( is_tag() ) {
	$archive_title = single_tag_title( '', false );
} elseif ( is_category() ) {
	$archive_title = single_cat_title( '', false );
} elseif ( is_post_type_archive() ) {
	$archive_title = post_type_archive_title( '', false );
}

$paging = ( 0 !== get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
?>

<?php if ( have_posts() ) { ?>

	<div class="row">
		<?php
		echo ( is_year() || is_month() ) ? '<div class="col-md-8">' : '<div class="col-md-12">';
		?>
		<h2 class="display-5 pb-3"><?php echo $archive_title; ?></h2>
		<hr class="pt-0 mt-0 mb-4"/>

		<?php
		while ( have_posts() ) {
			the_post();

			get_template_part( 'parts/tease', 'post' );

		}
		?>
	</div>
	<?php if ( ( is_year() || is_month() ) ) { ?>
		<div class="col-md-4">
			<aside class="sidebar mt-md-0 mt-4 ps-md-4 ps-0">
				<div id="xlthlx-months" class="widget widget_xlthlx-archive p-4">
					<h3 class="h2 pb-2 shadows">
						<?php echo ( 'en' === $lang ) ? 'Months' : 'Mesi'; ?>
					</h3>
					<div class="textwidget light">
						<?php $month = ( is_year() ) ? '' : get_the_time( 'n' ); ?>
						<ul>
							<?php xlt_get_months( get_the_time( 'Y' ), $month ); ?>
						</ul>
					</div>
				</div>
				<div id="xlthlx-archive" class="widget widget_xlthlx-archive p-4">
					<h3 class="h2 pb-2 shadows">
						<?php echo ( 'en' === $lang ) ? 'Years' : 'Anni'; ?>
					</h3>
					<div class="textwidget light">
						<?php xlt_get_years( get_the_time( 'Y' ) ); ?>
					</div>
				</div>
			</aside>
		</div>
	<?php } ?>
	</div>
	<?php
	xlt_pagination( $wp_query, $paging );

} else {
	get_template_part( 'parts/no-content' );
}

get_footer();
