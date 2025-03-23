<?php
/**
 * The template for displaying search results.
 *
 * @package  xlthlx
 */

global $lang;
get_header();

$search_title = ( 'en' === $lang ) ? 'Search results for:' : 'Risultati della ricerca per:';
$paging       = ( 0 !== get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

$search_query = new WP_Query(
	array(
		'paged'   => $paging,
		's'       => get_query_var( 's' ),
		'order'   => 'DESC',
		'orderby' => 'date',
	)
);
if ( $search_query->have_posts() ) {
	?>
	<div class="xlt-row" id="main-content">
		<div class="xlt-ph xlt-spacing xlt-sticky">
			<div class="xlt-ph__wrapper xlt-sticky_top">
				<p class="xlt-ph__before-title"><?php echo $search_title; ?></p>
				<h1 class="xlt-ph__title">“<?php echo get_query_var( 's' ); ?>”</h1></div>
		</div>
		<div class="xlt-loop__wrapper" id="xlt-loop__wrapper">
			<?php
			while ( $search_query->have_posts() ) {
				$search_query->the_post();
				get_template_part( 'parts/tease', 'post' );
			}
			?>
		</div>
		<div class="xlt-main-sidebar xlt-spacing">
			<?php get_template_part( 'parts/sidebar-page' ); ?>
		</div>
		<?php if ( function_exists( 'xlt_pagination' ) && '' !== xlt_pagination( $search_query, $paging ) ) { ?>
			<div class="xlt-page-navigation">
				<nav class="navigation pagination">
					<div class="nav-links">
						<?php echo xlt_pagination( $search_query, $paging ); ?>
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
