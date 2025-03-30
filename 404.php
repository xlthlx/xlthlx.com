<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package  xlthlx
 */

global $lang;
get_header();
get_template_part( 'parts/first-row' );

$not_found_title          = ( 'en' === $lang ) ? 'Not found' : 'Non trovato';
$not_found_content_before = ( 'en' === $lang ) ? 'Something went wrong.' : 'Qualcosa è andato storto.';
$not_found_content        = ( 'en' === $lang ) ? 'It seems we can&rsquo;t find what you&rsquo;re looking for. <br/>Perhaps searching can help.' : 'Sembra che non riusciamo a trovare quello che stai cercando. <br/>Forse fare una ricerca può aiutare.';
$not_found_content_after  = ( 'en' === $lang ) ? 'While you think about it, here is a photo of Petula, my cat.' : 'Mentre ci pensi, ecco una foto di Petula, la mia gatta.';
$not_found_content_last   = ( 'en' === $lang ) ? 'She greets you and says: Meow.' : 'Ti saluta, e dice: Miao.';
?>

	<div class="xlt-row" id="main-content">
		<div class="xlt-ph xlt-spacing xlt-top-smaller"></div>

		<div class="xlt-content xlt-spacing xlt-top-smaller">
			<article class="post-type-404" id="post-404">

				<div class="xlt-ph__wrapper">
					<h2 class="xlt-ph__title"><?php echo $not_found_title; ?></h2>
				</div>

				<p><?php echo $not_found_content_before; ?></p>
				<p><?php echo $not_found_content; ?></p>

				<?php get_template_part( 'parts/search-form' ); ?>

				<p></p>
				<p><?php echo $not_found_content_after; ?></p>

				<figure class="wp-block-image aligncenter size-full">
					<img decoding="async" width="800" height="450"
						 src="<?php echo get_template_directory_uri(); ?>/assets/img/404.jpg" alt="Petula"/>
				</figure>

				<p><?php echo $not_found_content_last; ?></p>

			</article>
		</div>

		<div class="xlt-main-sidebar xlt-spacing xlt-top-smaller">
			<?php get_template_part( 'parts/sidebar-page' ); ?>
		</div>

	</div>

<?php
get_footer();
