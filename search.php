<?php
/**
 * The template for displaying search results.
 *
 * @package  xlthlx
 */

global $lang;
get_header();
get_template_part( 'parts/first-row' );

$page_title = ( 'en' === $lang ) ? 'Search' : 'Ricerca';
$search_title = ( 'en' === $lang ) ? 'You searched for:' : 'Hai cercato:';
$results_title = ( 'en' === $lang ) ? 'Results:' : 'Risultati:';
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
		<div class="xlt-loop__wrapper" id="xlt-loop__wrapper">

			<div class="xlt-content xlt-spacing-min xlt-top-smaller">
                <h2 class="xlt-ph__title loop"><?php echo $search_title; ?> “<?php echo get_query_var( 's' ); ?>”</h2>
                <h3><?php echo $results_title; ?> <?php echo $search_query->found_posts ?></h3>
			</div>
			<?php
			while ( $search_query->have_posts() ) {
				$search_query->the_post();
				get_template_part( 'parts/tease', 'post' );
			}
			?>
		</div>
		<div class="xlt-main-sidebar xlt-spacing xlt-top-smaller">
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
