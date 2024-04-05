<?php
/**
 * Home page template.
 *
 * @package  xlthlx
 */

get_header();
global $lang, $wp_query;

$paging = ( 0 !== get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$args   = array_merge( $wp_query->query_vars, array( 'is_paged' => true, 'paged' => $paging ) );
query_posts( $args );

if ( have_posts() ) {
	?>
    <div id="main-content">
        <div class="xlt-loop__wrapper" id="xlt-loop__wrapper">
            <article class="xlt-entry">
                <div class="xlt-row">
                    <div class="xlt-entry__header xlt-spacing-min"></div>
                    <div class="xlt-entry__content xlt-spacing-min"></div>
                    <div class="xlt-entry__meta xlt-spacing-min">
                        <p class="xlt-widget__title">
							<?php $text = ( 'en' === $lang ) ? 'Subscribe to the newsletter' : 'Iscriviti alla Newsletter'; ?>
							<?php $url = ( 'en' === $lang ) ? '/en/' : '/'; ?>
                            <a title="<?php echo $text; ?>" class="svg-btn no-under"
                               href="https://xlthlx.com/newsletter<?php echo $url; ?>">
								<?php echo xlt_print_svg( '/assets/img/newsletter.svg' ); ?>
                            </a>
                            <a title="<?php echo $text; ?>" class="svg-btn"
                               href="https://xlthlx.com/newsletter<?php echo $url; ?>">
                                <span>Newsletter</span>
                            </a>
                        </p>
                    </div>
                </div>
            </article>
			<?php
			while ( have_posts() ) {
				the_post();
				get_template_part( 'parts/tease', 'home' );
			}
			?>
        </div>
		<?php if ( '' !== xlt_pagination( $wp_query, $paging ) ) { ?>
            <div class="xlt-page-navigation">
                <nav class="navigation pagination">
                    <div class="nav-links">
						<?php echo xlt_pagination( $wp_query, $paging ); ?>
                    </div>
                </nav>
            </div>
		<?php }
		wp_reset_query();
		?>
    </div>
	<?php

} else {
	get_template_part( 'parts/no-content' );
}

get_footer();
