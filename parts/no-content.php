<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @package  xlthlx
 */

global $lang;

$content_search = ( 'en' === $lang ) ? 'Sorry, but nothing matched your search terms. Please try again with some different keywords.' : 'Siamo spiacenti, ma nulla corrisponde ai termini di ricerca. Riprova con alcune parole chiave diverse.';
$content        = ( 'en' === $lang ) ? 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.' : 'Sembra che non riusciamo a trovare quello che stai cercando. Forse la ricerca può aiutare.';
?>

<div id="main-content">
	<div class="xlt-loop__wrapper" id="xlt-loop__wrapper">
		<article class="xlt-entry">
			<div class="xlt-row">
				<div class="xlt-entry__header xlt-spacing">
				</div>

				<div class="xlt-entry__content xlt-spacing">
					<?php if ( is_search() ) { ?>
						<p><?php echo $content_search; ?></p>
					<?php } else { ?>
						<p><?php echo $content; ?></p>
					<?php } ?>
					<?php get_template_part( 'parts/search-form' ); ?>
				</div>

			</div>
	</article>
</div>
