<?php
/**
 * Template Name: Newsletter
 *
 * @package  xlthlx
 */

global $lang;
get_header();

$cod        = get_query_var( 'cod', false );
$act        = get_query_var( 'act', false );
$news_title = '';
$content    = '';

if ( $cod && $act ) {

	$args = array(
		'nopaging'   => true,
		'post_type'  => 'flamingo_contact',
		'meta_query' => array(
			array(
				'key'     => '_code',
				'value'   => $cod,
				'compare' => '=',
			),
		),
	);

	$query = new WP_Query( $args );

	if ( $query->have_posts() ) {

		while ( $query->have_posts() ) {
			$query->the_post();

			switch ( $act ) {
				case 'confirm':
					$news_id = get_the_ID();
					update_post_meta( $news_id, '_active', 'si' );
					$_code = wp_generate_password( 64, false );
					update_post_meta( $news_id, '_code', $_code );
					wp_set_object_terms( $news_id, 2954, 'flamingo_contact_tag' );
					break;
				case 'unsubscribe':
					$news_id = get_the_ID();
					wp_delete_post( $news_id, true );
					$other_post_id = get_the_ID() + 1;
					wp_delete_post( $other_post_id, true );
					break;
			}
		}
	}
} else {
	$act = 'subscribe';
}

wp_reset_postdata();

switch ( $act ) {
	case 'confirm':
		$news_title = ( 'en' === $lang ) ? 'Email verified' : 'Email verificata';
		$content    = ( 'en' === $lang ) ? '<p>Thank you for verifying your email address.</p>' : '<p>Grazie per aver verificato il tuo indirizzo email.</p>';
		break;
	case 'unsubscribe':
		$news_title = ( 'en' === $lang ) ? 'Email deleted' : 'Email cancellata';
		$content    = ( 'en' === $lang ) ? '<p>You will no longer receive emails from us.</p><p>See you!</p>' : '<p>Non riceverai più email da noi.</p><p>Arrivederci!</p>';
		break;
	case 'subscribe':
		$news_title = 'Newsletter';
		$form_id    = ( 'en' === $lang ) ? 34503 : 34396;
		$content    = ( 'en' === $lang ) ? '<p>Do you want to receive an email when a new article is published?</p>' : '<p>Vuoi ricevere una email quando viene pubblicato un nuovo post?</p>';
		$content   .= do_shortcode( '[contact-form-7 id="' . $form_id . '"]' );
		break;
}
?>

<?php
while ( have_posts() ) :
	the_post();
	?>

	<article class="post-type-<?php echo get_post_type(); ?>" id="post-<?php echo get_the_ID(); ?>">

		<div class="row">
			<div class="col-md-9">

				<div class="row">

					<div class="col-12 d-flex">
						<div class="col-md-12 d-flex">
							<h2 class="display-4 pb-3 shadows"><?php echo $news_title; ?></h2>
						</div>
					</div>

					<div class="col-md-12 text-break">

						<section class="page-content mb-4">
							<hr class="pt-0 mt-0 mb-4"/>
							<?php echo $content; ?>
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
