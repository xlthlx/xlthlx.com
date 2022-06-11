<?php
/**
 * The template for displaying archives.
 *
 * @package  xlthlx
 */

global $lang, $wp_query;
get_header();
$title = ( 'en' === $lang ) ? 'Archive' : 'Archivio';

if ( is_day() ) {
	$title = get_the_date( 'D M Y' );
} elseif ( is_month() ) {
	$title = get_the_date( 'M Y' );
} elseif ( is_year() ) {
	$title = get_the_date( 'Y' );
} elseif ( is_tag() ) {
	$title = single_tag_title( '', false );
} elseif ( is_category() ) {
	$title = single_cat_title( '', false );
} elseif ( is_post_type_archive() ) {
	$title = post_type_archive_title( '', false );
}

$paged = ( get_query_var( 'paged' ) ) ?: 1;
?>

<?php if ( have_posts() ) { ?>

	<h2 class="display-5 pb-3"><?php echo $title; ?></h2>
	<hr class="pt-0 mt-0 mb-4"/>

	<?php
	while ( have_posts() ) {
		the_post();

		get_template_part( 'parts/tease', 'post' );

	}

	xlt_pagination( $wp_query, $paged );

} else {
	get_template_part( 'parts/no-content' );
}

get_footer();
