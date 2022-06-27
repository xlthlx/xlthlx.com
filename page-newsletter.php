<?php
/**
 * Template Name: Newsletter
 *
 * @package  xlthlx
 */
global $lang;
get_header();

$lan     = get_query_var( 'lan', false );
$title   = '';
$content = '';

if ( $lan ) {
	$act = get_query_var( 'act' );
	$cod = get_query_var( 'cod' );

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
					$post_id = get_the_ID();
					update_post_meta( $post_id, '_active', 'si' );
					$_code = wp_generate_password( 64, false );
					update_post_meta( $post_id, '_code', $_code );
					break;
				case 'unsubscribe':
					$post_id = get_the_ID();
					wp_delete_post( $post_id, true );
					$other_post_id = get_the_ID() + 1;
					wp_delete_post( $other_post_id, true );
					break;
			}

		}

	}
} else {
	$act = 'error';
}

wp_reset_postdata();

switch ( $act ) {
	case 'confirm':
		$title   = ( 'en' === $lang ) ? 'Email verified' : 'Email verificata';
		$content = ( 'en' === $lang ) ? '<p>Thank you for verifying your email address.</p>' : '<p>Grazie per aver verificato il tuo indirizzo email.</p>';
		break;
	case 'unsubscribe':
		$title   = ( 'en' === $lang ) ? 'Email deleted' : 'Email cancellata';
		$content = ( 'en' === $lang ) ? '<p>You will no longer receive emails from us.</p><p>See you!</p>' : '<p>Non riceverai più email da noi.</p><p>Arrivederci!</p>';
		break;
	case 'error':
		$img     = '<p><img class="img-fluid d-block" src="' . get_template_directory_uri() . '/assets/img/404.gif" alt="Error"></p>';
		$title   = ( 'en' === $lang ) ? 'Oh-oh' : 'Uh-oh';
		$content = ( 'en' === $lang ) ? '<p>There was a problem, the hamsters who run the site are perplexed.</p>' : "<p>C'è stato un problema, i criceti che gestiscono il sito sono perplessi.</p>";
		$content .= $img;
		break;
}
?>

<?php while ( have_posts() ) :
	the_post(); ?>

	<article class="post-type-<?php echo get_post_type(); ?>" id="post-<?php echo get_the_ID(); ?>">

		<div class="row">
			<div class="col-md-8">

				<div class="row">

					<div class="col-12 d-flex">
						<div class="col-md-12 d-flex">
							<h2 class="display-4 pb-3 shadows"><?php echo $title; ?></h2>
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
