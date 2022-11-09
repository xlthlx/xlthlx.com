<?php
/**
 * Home page template.
 *
 * @package  xlthlx
 */

get_header();
global $lang;

$paged = ( get_query_var( 'paged' ) ) ?: 1;
if ( 'en' === $lang ) {
	$paged = ( get_query_var( 'page' ) ) ?: 1;
}

$first            = xlt_get_first_post();
$offset           = $first['offset'];
$first_post_query = $first['first_post_query'];

$args = array(
	'post__not_in' => $offset,
	'paged'        => $paged,
);

$wp_query = new WP_Query( $args );

if ( $first_post_query && 1 === $paged ) {
	?>
	<div class="dots mt-5 mb-4 p-5">

		<?php
		foreach ( $first_post_query as $post ) {
			setup_postdata( $post );
			get_template_part( 'parts/sticky' );

		}
		wp_reset_postdata();
		?>

	</div>
	<?php
}

if ( $wp_query->have_posts() ) {
	?>
	<div class="row mb-2">
	<?php
	while ( $wp_query->have_posts() ) {
		$wp_query->the_post();
		get_template_part( 'parts/tease', 'home' );
		if ( ( $wp_query->current_post % 2 !== 0 ) && ( $wp_query->post_count !== $wp_query->current_post + 1 ) ) {
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

xlt_pagination( $wp_query, $paged );
get_footer();
