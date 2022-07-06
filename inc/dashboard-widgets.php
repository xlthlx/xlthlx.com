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
}

add_action( 'wp_dashboard_setup', 'xlt_add_dashboard_widgets' );

/**
 * Output the contents of the dashboard widget.
 *
 * @param $post
 * @param $callback_args
 *
 * @return void
 */
function plausible_widget_callback( $post, $callback_args ) {
	?>
	<div>
		<p>Click the button below to toggle your exclusion in analytics for this site.</p>
		<p>You currently <span id="plausible_not">are not</span><span id="plausible_yes">are</span>
			excluding your visits.<br/>
			<a id="plausible_button" href="javascript:toggleExclusion()">Exclude my visits</a></p>
	</div>

	<script>
		window.addEventListener('load', function (e) {
			var exclusionState = window.localStorage.plausible_ignore == "true"

			if ( exclusionState ) {
				document.getElementById("plausible_not").style.display = "none"
				document.getElementById("plausible_yes").style.display = "inline"
				document.getElementById("plausible_button").innerHTML = 'Stop excluding my visits'
			} else {
				document.getElementById("plausible_yes").style.display = "none"
				document.getElementById("plausible_not").style.display = "inline"
				document.getElementById("plausible_button").innerHTML = 'Exclude my visits'
			}
		});

		function toggleExclusion(e) {
			var exclusionState = window.localStorage.plausible_ignore == "true"

			if ( exclusionState ) {
				delete window.localStorage.plausible_ignore
				document.getElementById("plausible_yes").style.display = "none"
				document.getElementById("plausible_not").style.display = "inline"
				document.getElementById("plausible_button").innerHTML = 'Exclude my visits'
			} else {
				window.localStorage.plausible_ignore = "true"
				document.getElementById("plausible_not").style.display = "none"
				document.getElementById("plausible_yes").style.display = "inline"
				document.getElementById("plausible_button").innerHTML = 'Stop excluding my visits'
			}
		}
	</script>
	<?php
}

/**
 * Output the contents of the dashboard widget.
 *
 * @param $post
 * @param $callback_args
 *
 * @return void
 */
function flamingo_widget_callback( $post, $callback_args ) {
	$the_query = new WP_Query( [ 'post_type' => 'flamingo_inbound' ] );

	if ( $the_query->have_posts() ) {

		?>
		<table class="wp-list-table widefat fixed striped table-view-list posts">
			<thead>
			<tr>
				<th scope="col" id="subject" class="manage-column column-subject column-primary"><span>Oggetto</span></th>
				<th scope="col" id="from" class="manage-column column-from"><span>Da</span></th>
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
							   aria-label="Modifica">
								<?php echo get_the_title(); ?>
							</a>
						</strong>
					</td>
					<td class="from column-from" data-colname="Da">Rick@themaxplane.win &lt;Rick@themaxplane.win&gt;</td>
					<td class="date column-date" data-colname="Data"><?php echo get_the_date(); ?></td>
				</tr>
			<?php } ?>
			</tbody>

		</table>

		<?php

	}
	wp_reset_postdata();
}