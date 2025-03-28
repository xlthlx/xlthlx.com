<?php
/**
 * The template for displaying all single posts.
 *
 * @package  xlthlx
 */

global $lang, $post;
get_header();
?>

<?php get_template_part( 'parts/first-row' ); ?>
<?php
while ( have_posts() ) :
	the_post();
	?>

	<div class="xlt-row" id="main-content">
		<div class="xlt-ph xlt-spacing xlt-sticky">
			<div class="xlt-ph__wrapper xlt-sticky_top">
				<h2 class="xlt-ph__title"><?php echo get_the_title(); ?></h2>
			</div>
		</div>

		<div class="xlt-content xlt-spacing">
			<article class="post-type-<?php echo get_post_type(); ?>" id="post-<?php echo get_the_ID(); ?>">
				<?php
				if ( function_exists( 'xlt_old_posts_warning' ) ) {
					echo xlt_old_posts_warning( $lang );
				}
				?>
				<?php echo apply_filters( 'the_content', get_the_content() ); ?>

			</article>
		</div>

		<div class="xlt-meta xlt-spacing xlt-sticky">
			<div class="xlt-meta__wrapper xlt-sticky_top">
				<div class="xlt-meta__date">
					<time class="entry-date published" datetime="
					<?php
					if ( function_exists( 'xlt_atom_date' ) ) {
						echo xlt_atom_date( $post->post_date ); }
					?>
					">
						<?php echo get_the_date(); ?></time>
					<time class="updated screen-reader-text"
						  datetime="
						  <?php
							if ( function_exists( 'xlt_atom_date' ) ) {
								echo xlt_atom_date( $post->post_modified ); }
							?>
							">
						<?php echo get_the_date(); ?></time>
				</div>

				<div class="xlt-meta__categories">
					<div class="xlt-cl">
						<?php get_template_part( 'parts/terms' ); ?>
					</div>
				</div>

			</div>
		</div>

		<div class="xlt-main-sidebar xlt-spacing">
			<?php get_template_part( 'parts/sidebar-post' ); ?>
		</div>
	</div>
	<?php comments_template(); ?>
	<?php get_template_part( 'parts/navigation' ); ?>

<?php endwhile; ?>
<?php
get_footer();
