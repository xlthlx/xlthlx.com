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
							<?php echo ( 'en' === $lang ) ? get_content_en() : apply_filters( 'the_content', get_the_content() ); ?>
							<hr class="pt-0 mt-0 mb-4"/>
							<?php $bookmarks = get_bookmarks( array(
								'orderby'       => 'name',
								'order'         => 'ASC',
								'category_name' => 'TV Series'
							) );

							$series = '';

							foreach ( $bookmarks as $bookmark ) {
								$series .= '<p>';
								if ( '' !== $bookmark->link_image ) {
									$series .= '<figure class="wp-block-image alignleft is-style-default">
									<a title="' . $bookmark->link_name . '" target="_blank" href="' . $bookmark->link_url . '">
									<picture>
										<source srcset="' . $bookmark->link_image . '" type="image/webp">
										<source srcset="' . $bookmark->link_image . '" type="image/jpeg">
										<img src="' . $bookmark->link_image . '" alt="' . $bookmark->link_name . '" class="img-fluid">
									</picture>
									</a>
								</figure>';
								}
								$series .= '<a title="' . $bookmark->link_name . '" target="_blank" href="' . $bookmark->link_url . '">' . $bookmark->link_name . '</a>';
								if ( '' !== $bookmark->link_notes ) {
									$series .= '<br />' . nl2br( $bookmark->link_notes );
								}
								if ( '' !== $bookmark->link_description ) {
									$series .= '</p><p>' . $bookmark->link_description;
								}
								$series .= '</p>';

							}

							echo $series;
							?>
						</section>
					</div>
				</div>

			</div>

			<div class="col-md-4">
				<aside class="sidebar mt-md-0 mt-4 ps-md-4 ps-0">
					<?php dynamic_sidebar( 'page_sidebar' ); ?>
				</aside>
			</div>
		</div>

	</article>

<?php endwhile; ?>
<?php
get_footer();
