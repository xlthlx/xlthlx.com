<?php
/**
 * The template for displaying archives.
 *
 * @package  xlthlx
 */

global $lang, $wp_query;
get_header();
$archive_title = ( 'en' === $lang ) ? 'Archive' : 'Archivio';

$paging = ( 0 !== get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$args   = array_merge( $wp_query->query_vars, array( 'is_paged' => true ) );
query_posts( $args );


$archive_month = get_the_date( 'F' );
$archive_year  = get_the_date( 'Y' );

if ( is_day() ) {
	$archive_title = get_the_date( 'd' ) . ' ' . $archive_month . ' ' . $archive_year;
} elseif ( is_month() ) {
	$archive_title = $archive_month . ' ' . $archive_year;
} elseif ( is_year() ) {
	$archive_title = $archive_year;
} elseif ( is_tag() ) {
	$archive_title = single_tag_title( '', false );
} elseif ( is_category() ) {
	$archive_title = single_cat_title( '', false );
} elseif ( is_post_type_archive() ) {
	$archive_title = post_type_archive_title( '', false );
}

if ( have_posts() ) { ?>
	<?php get_template_part( 'parts/first-row' ); ?>
	<div class="xlt-row" id="main-content">
		<div class="xlt-ph xlt-spacing xlt-sticky">
			<div class="xlt-ph__wrapper xlt-sticky_top">
				<h2 class="xlt-ph__title"><?php echo $archive_title; ?></h2>
			</div>
		</div>
		<div class="xlt-loop__wrapper" id="xlt-loop__wrapper">
			<?php
			while ( have_posts() ) {
				the_post();
				get_template_part( 'parts/tease', 'post' );
			}
			?>
		</div>
		<div class="xlt-main-sidebar xlt-spacing xlt-sticky">
			<?php get_template_part( 'parts/sidebar-page' ); ?>
		</div>
		<?php if ( function_exists( 'xlt_pagination' ) && '' !== xlt_pagination( $wp_query, $paging ) ) { ?>
			<div class="xlt-page-navigation">
				<nav class="navigation pagination">
					<div class="nav-links">
						<?php echo xlt_pagination( $wp_query, $paging ); ?>
					</div>
				</nav>
			</div>
		<?php } ?>
	</div>
	<?php

} else {
	get_template_part( 'parts/no-content' );
}

get_footer();
