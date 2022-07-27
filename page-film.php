<?php
/**
 * Template Name: Film
 *
 * @package  xlthlx
 */
global $lang;
get_header();
?>

<?php while ( have_posts() ) :
	the_post(); ?>

	<article class="post-type-<?php echo get_post_type(); ?>" id="post-<?php echo get_the_ID(); ?>">

		<div class="row">
			<div class="col-md-8">

				<div class="row">

					<div class="col-12 d-flex">
						<div class="col-md-12 d-flex">
							<h2 class="display-4 pb-3 shadows"><?php echo get_the_title(); ?></h2>
						</div>
					</div>

					<div class="col-md-12 text-break">

						<section class="page-content mb-4">
							<hr class="pt-0 mt-0 mb-4"/>
							<?php echo ( 'en' === $lang ) ? get_content_en() : apply_filters( 'the_content',get_the_content() ); ?>
							<hr class="pt-0 mt-0 mb-4"/>
							<?php
							$years = get_terms( [
								'taxonomy' => 'year',
								'orderby'  => 'name',
								'order'    => 'DESC',
							] );

							if ( ! empty( $years ) && ! is_wp_error( $years ) ) {
								foreach ( $years as $year ) {
									$args = [
										'post_type' => 'film',
										'tax_query' => [
											[
												'taxonomy' => 'year',
												'field'    => 'slug',
												'terms'    => [ $year->slug ],
												'operator' => 'IN'
											]
										]
									];

									$the_query = new WP_Query( $args );

									if ( $the_query->have_posts() ) {

										while ( $the_query->have_posts() ) {
											$the_query->the_post();
											echo '<div class="clearfix">';

											if ( get_post_thumbnail_id( get_the_ID() ) ) {
												echo xlt_get_thumb_img( get_post_thumbnail_id( get_the_ID() ),get_the_title() );
											}

											echo '<p>';
											echo '<h3><a title="' . get_the_title() . '" target="_blank" href="' . get_post_meta( get_the_ID(),'link',true ) . '">' . get_the_title() . '</a></h3>';
											echo '<em><strong>' . $year->name . '</strong></em>';
											$directors = get_the_terms( get_the_ID(),'director' );

											$dir = ( 'en' === $lang ) ? 'Director(s)' : 'Regista(i)';

											if ( ! empty( $directors ) && ! is_wp_error( $directors ) ) {
												echo '<br/><em>' . $dir . '</em>';

												$directors = wp_list_pluck( $directors,'name' );
												echo '<br/>' . implode( ', ',$directors );
											}

											$starring = get_the_terms( get_the_ID(),'actor' );

											$stars = ( 'en' === $lang ) ? 'Starring' : 'Interpreti';

											if ( ! empty( $starring ) && ! is_wp_error( $starring ) ) {
												echo '<br/><em>' . $stars . '</em>';

												$starring = wp_list_pluck( $starring,'name' );
												echo '<br/>' . implode( ', ',$starring );
											}

											echo '</p>';
											echo ( 'en' === $lang ) ? get_content_en() : apply_filters( 'the_content',get_the_content() );
											echo '</div>';
											echo '<hr class="pt-0 mt-4 mb-4"/>';
										}

									}

									wp_reset_postdata();
								}
							}
							?>

						</section>
					</div>
				</div>

			</div>

			<?php get_template_part( 'parts/sidebar-page' ); ?>
		</div>

	</article>

<?php endwhile; ?>
<?php
get_footer();
