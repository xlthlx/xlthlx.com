<?php
global $lang;
$prev = ( 'en' === $lang ) ? 'Previous post' : 'Post precedente';
$next = ( 'en' === $lang ) ? 'Next post' : 'Post successivo';
?>
<div class="row">
	<div class="col-12 d-flex">
		<div class="col-auto me-auto d-flex">
			<?php echo get_previous_post_link( '%link', '<span class="display-5 arrow" aria-hidden="true">&#8672;</span><span class="visually-hidden">' . $prev . '</span>' ); ?>
		</div>
		<div class="col-auto d-flex">
			<?php echo get_next_post_link( '%link', '<span class="visually-hidden">' . $next . '</span><span class="display-5 arrow" aria-hidden="true">&#8674;</span>' ); ?>
		</div>
	</div>
</div>
