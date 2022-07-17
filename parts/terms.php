<?php
$cats = xlt_get_the_terms( 'category' );

if ( is_home() || is_front_page() ) {
	$cats = xlt_get_the_terms( 'category', true );
}

if ( '' !== $cats ) { ?>
	<ul class="list-unstyled ml-0 pl-0 mb-0">
		<?php echo $cats; ?>
	</ul>
<?php }
