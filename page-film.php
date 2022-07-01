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
							<?php echo ( 'en' === $lang ) ? get_content_en() : apply_filters( 'the_content', get_the_content() ); ?>
							<hr class="pt-0 mt-0 mb-4"/>
							<?php $bookmarks = get_bookmarks( array(
								'orderby'       => 'rand',
								'order'         => 'DESC',
								'category_name' => 'Film'
							) );

							$film = '';

							foreach ( $bookmarks as $bookmark ) {
								$film .= '<div class="clearfix">';
								if ( '' !== $bookmark->link_image ) {
									$webp_src = preg_replace( '/(?:jpg|png|jpeg)$/i', 'webp', $bookmark->link_image );
									$film .= '<figure class="wp-block-image alignleft is-style-default">
									<a title="' . $bookmark->link_name . '" target="_blank" href="' . $bookmark->link_url . '">
									<picture>
										<source srcset="' . $webp_src . '" type="image/webp">
										<source srcset="' . $bookmark->link_image . '" type="image/jpeg">
										<img src="' . $bookmark->link_image . '" alt="' . $bookmark->link_name . '" class="img-fluid">
									</picture>
									</a>
								</figure>';
								}
								$film .= '<p>';
								$film .= '<a title="' . $bookmark->link_name . '" target="_blank" href="' . $bookmark->link_url . '">' . $bookmark->link_name . '</a>';
								$link_year = get_post_meta( $bookmark->link_id, 'link_year', true );
								if ( '' !== $link_year ) {
									$film .= '<br/><em><strong>' . $link_year . '</strong></em>';
								}

								$link_directors = get_post_meta( $bookmark->link_id, 'link_directors', true );
								if ( '' !== $link_directors ) {
									$film .= '<br/><em>Director(s)</em>';
									$film .= '<br/>' . $link_directors;
								}

								$link_starring = get_post_meta( $bookmark->link_id, 'link_starring', true );
								if ( '' !== $link_starring ) {
									$film .= '<br/><em>Starring</em>';
									$film .= '<br/>' . $link_starring;
								}
								if ( '' !== $bookmark->link_description ) {
									$film .= '</p><p>' . $bookmark->link_description;
								}
								$film .= '</p>';
								$film .= '</div>';
								$film .= '<hr class="pt-0 mt-4 mb-4"/>';
							}

							echo $film;
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
