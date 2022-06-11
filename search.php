<?php
/**
 * The template for displaying search results.
 *
 * @package  xlthlx
 */

global $lang, $wp_query;
get_header();

$title = ( 'en' === $lang ) ? 'Search results for: ' . get_query_var( 's' ) : 'Risultati della ricerca per: ' . get_query_var( 's' );
$paged = ( get_query_var( 'paged' ) ) ?: 1;

$wp_query = new WP_Query( array(
	'paged'   => $paged,
	's'       => get_query_var( 's' ),
	'order'   => 'DESC',
	'orderby' => 'date',
) );
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
