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
	$paging = (0 !==  get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
}

$first            = xlt_get_first_post();
$offset           = $first['offset'];
$first_post_query = $first['first_post_query'];

$args = array(
	'post__not_in' => $offset,
	'paged'        => $paging,
);

$main_query = new WP_Query( $args );

if ( $first_post_query && 1 === $paging ) {
	?>
	<div class="dots mt-5 mb-4 px-4 py-5">

		<?php
		foreach ( $first_post_query as $first_post ) {
			setup_postdata( $first_post );
			get_template_part( 'parts/sticky' );

		}
		wp_reset_postdata();
		?>

	</div>
	<?php
}

if ( $main_query->have_posts() ) {
	?>
	<div class="row mb-2">
	<?php
	while ( $main_query->have_posts() ) {
		$main_query->the_post();
		get_template_part( 'parts/tease', 'home' );
		if ( ( 0 !== $main_query->current_post % 2 ) && ( $main_query->post_count !== $main_query->current_post + 1 ) ) {
			?>
			</div>
			<hr class="pt-0 mt-0 mb-4"/>
			<div class="row mb-2">
			<?php
		}
	}
	?>
	</div>
	<?php

} else {
	get_template_part( 'parts/no-content' );
}

xlt_pagination( $main_query, $paging );
get_footer();
