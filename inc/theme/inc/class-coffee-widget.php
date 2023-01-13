<?php
/**
 * Buy Me a Coffee Widget.
 *
 * @package  xlthlx
 */

/**
 * Coffee Widget Class.
 */
class Coffee_Widget extends WP_Widget {

	/**
	 * Widget Constructor.
	 *
	 * @return void
	 */
	public function __construct() {

		// Setup Widget.
		parent::__construct(
			'xlthlx-coffee', // ID.
			esc_html__( 'Buy me a coffee', 'xlthlx' ), // Name.
			array(
				'description'                 => esc_html__( 'Displays the Buy me a coffee link.', 'xlthlx' ),
				'customize_selective_refresh' => true,
			) // Args.
		);
	}

	/**
	 * Main Function to display the widget.
	 *
	 * @param array $args Widgets args.
	 * @param array $instance Widget instance.
	 *
	 * @uses this->render()
	 * @return void
	 */
	public function widget( $args, $instance ) {

		// Start Output Buffering.
		ob_start();

		// Output.
		echo $args['before_widget'];
		?>

		<div class="textwidget light">

			<?php $this->render(); ?>

		</div>

		<?php
		echo $args['after_widget'];

		// End Output Buffering.
		ob_end_flush();
	}

	/**
	 * Renders the Widget Content.
	 *
	 * @return void
	 */
	public function render() {

		global $lang;
		$text = ( 'en' === $lang ) ? 'Buy me a coffee' : 'Offrimi un caffè';

		?>
		<ul>
			<li>
				<a class="bmc-btn" target="_blank" href="https://buymeacoffee.com/xlthlx">
					<?php echo xlt_print_svg( '/assets/img/bmc.svg' ); ?>
					<span class="bmc-btn-text"><?php echo $text; ?></span>
				</a>
			</li>
		</ul>
		<?php
	}

	/**
	 * Displays Widget Settings Form in the Backend.
	 *
	 * @param array $instance Widget instance.
	 *
	 * @return void
	 */
	public function form( $instance ) {
		?>

		<p>No settings for this widget.</p>

		<?php
	}
}
