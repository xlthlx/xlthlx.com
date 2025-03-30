<?php
/**
 * Home page template.
 *
 * @package  xlthlx
 */

get_header();
global $lang, $wp_query;

$paging = ( 0 !== get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$args   = array_merge(
	$wp_query->query_vars,
	array(
		'is_paged' => true,
		'paged'    => $paging,
	)
);
query_posts( $args );

if ( have_posts() ) {
	?>
	<?php get_template_part( 'parts/first-row' ); ?>
	<div class="xlt-row" id="main-content">
		<div class="xlt-loop__wrapper xlt-top-smaller" id="xlt-loop__wrapper">
			<?php
			while ( have_posts() ) {
				the_post();
				get_template_part( 'parts/tease', 'home' );
			}
			?>
		</div>
		<div class="xlt-main-sidebar xlt-spacing xlt-top-smaller">
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
			<?php
		}
		wp_reset_query();
		?>
	</div>
	<?php

} else {
	get_template_part( 'parts/no-content' );
}

get_footer();
