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
	<div id="main-content">
		<div class="xlt-loop__wrapper" id="xlt-loop__wrapper">
			<?php get_template_part( 'parts/first-row' ); ?>
			<?php
			while ( have_posts() ) {
				the_post();
				get_template_part( 'parts/tease', 'home' );
			}
			?>
		</div>
		<?php if ( '' !== xlt_pagination( $wp_query, $paging ) ) { ?>
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
