<?php
/**
 * Template Name: TV Series
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
							$series = xlt_get_all_film_tv( 'tvseries',$lang );

							if ( ! empty( $series ) ) {
								foreach ( $series as $serie ) {
									echo '<div class="clearfix">';

									if ( $serie['image'] ) {
										echo $serie['image'];
									}

									echo '<p>';
									echo '<h3><a title="' . $serie['title'] . '" target="_blank" href="' . $serie['link'] . '">' . $serie['title'] . ' <svg width="20px" height="20px" class="open-new" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg"><path fill="currentColor" d="M12.1.6a.944.944 0 0 0 .2 1.04l1.352 1.353L10.28 6.37a.956.956 0 0 0 1.35 1.35l3.382-3.38 1.352 1.352a.944.944 0 0 0 1.04.2.958.958 0 0 0 .596-.875V.96a.964.964 0 0 0-.96-.96h-4.057a.958.958 0 0 0-.883.6z"/><path fill="currentColor" d="M14 11v5a2.006 2.006 0 0 1-2 2H2a2.006 2.006 0 0 1-2-2V6a2.006 2.006 0 0 1 2-2h5a1 1 0 0 1 0 2H2v10h10v-5a1 1 0 0 1 2 0z"/></svg></a></h3>';
									echo '<em><strong>' . $serie['year'] . '</strong></em>';

									if ( $serie['directors'] ) {
										$created = ( 'en' === $lang ) ? 'Created by' : 'Ideatore(i)';
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
										$review = ( 'en' === $lang ) ? 'What I had written about it' : 'Cosa ne avevo scritto';
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
