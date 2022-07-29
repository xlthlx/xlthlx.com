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
							$series = xlt_get_all_film_tv( 'film',$lang );

							if ( ! empty( $series ) ) {
								foreach ( $series as $serie ) {
									echo '<div class="clearfix">';

									if ( $serie['image'] ) {
										echo $serie['image'];
									}

									echo '<p>';
									echo '<h3><a title="' . $serie['title'] . '" target="_blank" href="' . $serie['link'] . '">' . $serie['title'] . '</a></h3>';
									echo '<em><strong>' . $serie['year'] . '</strong></em>';

									if ( $serie['directors'] ) {
										$created = ( 'en' === $lang ) ? 'Director(s)' : 'Regista(i)';
										echo '<br/><em>' . $created . '</em>';
										echo '<br/>' . $serie['directors'];
									}

									if ( $serie['starring'] ) {
										$stars = ( 'en' === $lang ) ? 'Starring' : 'Interpreti';
										echo '<br/><em>' . $stars . '</em>';
										echo '<br/>' . $serie['starring'];
									}

									echo '</p>';
									echo $serie['content'];

									if ( '' !== $serie['internal'] ) {
										$review = ( 'en' === $lang ) ? 'What had I written about it' : 'Cosa ne avevo scritto';
										echo '<p><a title="' . $serie['title'] . '" target="_blank" href="' . $serie['internal'] . '">' . $review . '</a></p>';
									}
									
									echo '</div>';
									echo '<hr class="pt-0 mt-4 mb-4"/>';
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
