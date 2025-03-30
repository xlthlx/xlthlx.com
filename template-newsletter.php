<?php
/**
 * Template Name: Newsletter
 *
 * @package  xlthlx
 */

global $lang;
get_header();
get_template_part( 'parts/first-row' );
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
		$content    = apply_filters( 'the_content', get_the_content() );
		break;
}
?>

<?php
while ( have_posts() ) :
	the_post();
	?>

	<div class="xlt-row" id="main-content">
		<div class="xlt-ph xlt-spacing xlt-top-smaller"></div>

		<div class="xlt-content xlt-spacing xlt-top-smaller">
			<article class="post-type-<?php echo get_post_type(); ?>" id="post-<?php echo get_the_ID(); ?>">

				<div class="xlt-ph__wrapper">
					<h2 class="xlt-ph__title"><?php echo $news_title; ?></h2>
				</div>

				<?php echo $content; ?>

			</article>
		</div>

		<div class="xlt-main-sidebar xlt-spacing xlt-top-smaller">
			<?php get_template_part( 'parts/sidebar-page' ); ?>
		</div>

	</div>

<?php endwhile; ?>
<?php
get_footer();
