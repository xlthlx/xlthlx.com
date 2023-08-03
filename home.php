<?php
/**
 * Home page template.
 *
 * @package  xlthlx
 */

get_header();
global $lang;

$paging = ( 0 !== get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
if ( 'en' === $lang ) {
	$paging = ( '' !== get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
}

$main_query = new WP_Query( array( 'paged' => $paging ) );

if ( $main_query->have_posts() ) {
	?>
	<div id="main-content">
		<div class="xlt-loop__wrapper" id="xlt-loop__wrapper">
			<?php
			while ( $main_query->have_posts() ) {
				$main_query->the_post();
				get_template_part( 'parts/tease', 'home' );
			}
			?>
		</div>
		<?php if ( '' !== xlt_pagination( $main_query, $paging ) ) { ?>
			<div class="xlt-page-navigation">
				<nav class="navigation pagination">
					<div class="nav-links">
						<?php echo xlt_pagination( $main_query, $paging ); ?>
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
