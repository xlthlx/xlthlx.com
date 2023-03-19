<?php
/**
 * Dashboard widgets.
 *
 * @package  xlthlx
 */

/**
 * Add a new dashboard widget.
 *
 * @return void
 */
function xlt_add_dashboard_widgets() {
	wp_add_dashboard_widget( 'plausible_widget', 'Plausible statistics', 'plausible_widget_callback' );
	wp_add_dashboard_widget( 'flamingo_widget', 'Messaggi in arrivo', 'flamingo_widget_callback' );
	wp_add_dashboard_widget( 'latest_comments_widget', 'Ultimi commenti', 'latest_comments_widget_callback' );
}

add_action( 'wp_dashboard_setup', 'xlt_add_dashboard_widgets' );

/**
 * Output the contents of the dashboard widget.
 *
 * @return void
 */
function plausible_widget_callback() {
	?>
	<div>
		<p>Fai clic sul pulsante in basso per attivare o disattivare la tua esclusione nell'analisi per questo sito.</p>
		<p>Al momento <span id="plausible_not">non stai</span><span id="plausible_yes">stai</span> escludendo le tue visite.<br/>
			<a id="plausible_button" href="javascript:toggleExclusion()">Escludi le mie visite</a></p>
	</div>

	<script>
		window.addEventListener('load', function () {
			let exclusionState = window.localStorage.plausible_ignore == "true"

			if ( exclusionState ) {
				document.getElementById("plausible_not").style.display = "none"
				document.getElementById("plausible_yes").style.display = "inline"
				document.getElementById("plausible_button").innerHTML = 'Includi le mie visite'
			} else {
				document.getElementById("plausible_yes").style.display = "none"
				document.getElementById("plausible_not").style.display = "inline"
				document.getElementById("plausible_button").innerHTML = 'Escludi le mie visite'
			}
		});

		function toggleExclusion() {
			let exclusionState = window.localStorage.plausible_ignore == "true"

			if ( exclusionState ) {
				delete window.localStorage.plausible_ignore
				document.getElementById("plausible_yes").style.display = "none"
				document.getElementById("plausible_not").style.display = "inline"
				document.getElementById("plausible_button").innerHTML = 'Escludi le mie visite'
			} else {
				window.localStorage.plausible_ignore = "true"
				document.getElementById("plausible_not").style.display = "none"
				document.getElementById("plausible_yes").style.display = "inline"
				document.getElementById("plausible_button").innerHTML = 'Includi le mie visite'
			}
		}
	</script>
	<?php
}

/**
 * Output the contents of the dashboard widget.
 *
 * @return void
 */
function flamingo_widget_callback() {
	$the_query = new WP_Query(
		array(
			'post_type'      => 'flamingo_inbound',
			'posts_per_page' => 4,
		)
	);

	if ( $the_query->have_posts() ) {

		?>
		<style>.fixed .column-date {
				width: 30%;
			}</style>
		<table class="wp-list-table widefat fixed striped table-view-list posts">
			<thead>
			<tr>
				<th scope="col" id="subject" class="manage-column column-subject column-primary"><span>Oggetto</span></th>
				<th scope="col" id="date" class="manage-column column-date"><span>Data</span></th>
			</tr>
			</thead>

			<tbody id="the-list" data-wp-lists="list:post">
			<?php
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				?>
				<tr>
					<td class="subject column-subject has-row-actions column-primary" data-colname="Oggetto">
						<strong>
							<a class="row-title"
							   href="https://xlthlx.com/wp-admin/admin.php?page=flamingo_inbound&amp;post=<?php echo get_the_ID(); ?>&amp;action=edit"
							   aria-label="Modifica" title="Modifica">
								<?php echo get_the_title(); ?>
							</a>
						</strong>
					</td>
					<td class="date column-date" data-colname="Data"><?php echo get_the_date(); ?></td>
				</tr>
			<?php } ?>
			</tbody>

		</table>

		<?php

	}
	wp_reset_postdata();
}

/**
 * Widget callback.
 *
 * @return void
 */
function latest_comments_widget_callback() {
	$args = array(
		'orderby' => 'comment_date',
		'order'   => 'DESC',
		'number'  => 6,
	);

	$comments_query = new WP_Comment_Query( $args );
	$comments       = $comments_query->comments;

	?>
	<style>.fixed .column-author {
			width: 20%;
		}</style>
	<table class="wp-list-table widefat fixed striped table-view-list posts">
		<thead>
		<tr>
			<th scope="col" id="author" class="manage-column column-author column-primary"><span>Autore</span></th>
			<th scope="col" id="comment" class="manage-column column-comment"><span>Commento</span></th>
		</tr>
		</thead>

		<tbody id="the-list" data-wp-lists="list:post">
		<?php
		foreach ( $comments as $comment ) {
			?>
			<tr>
				<td class="author column-author column-primary" data-colname="Autore">
					<strong>
						<a class="row-title"
						   href="<?php echo get_home_url(); ?>/wp-admin/comment.php?action=editcomment&c=<?php echo $comment->comment_ID; ?>"
						   aria-label="Modifica" title="Modifica">
							<?php echo $comment->comment_author; ?>
						</a>
					</strong>
				</td>
				<td class="comment column-comment" data-colname="Commento"><?php echo $comment->comment_content; ?></td>
			</tr>
		<?php } ?>
		</tbody>

	</table>
	<?php

}
