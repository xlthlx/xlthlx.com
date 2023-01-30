<?php
/**
 * Newsletter Widget.
 *
 * @package  xlthlx
 */

/**
 * Newsletter Widget Class.
 */
class Newsletter_Widget extends WP_Widget {

	/**
	 * Widget Constructor.
	 *
	 * @return void
	 */
	public function __construct() {

		// Setup Widget.
		parent::__construct(
			'xlthlx-newsletter', // ID.
			esc_html__( '04 Newsletter', 'xlthlx' ), // Name.
			array(
				'description'                 => esc_html__( 'Displays the newsletter form to subscribe.', 'xlthlx' ),
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
		// Display Title.
		echo '<h3 class="h2 pb-2 shadows">Newsletter</h3>';
		?>

		<div class="text-widget">

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
		$content = ( 'en' === $lang ) ? 'Do you want to receive an email when a new article is published?' : 'Vuoi ricevere una email quando viene pubblicato un nuovo post?';
		$form_id = ( 'en' === $lang ) ? 34503 : 34396;

		?>
		<?php echo $content; ?>
		<br/>
		<?php echo do_shortcode( '[contact-form-7 id="' . $form_id . '"]' ); ?>
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
		<p>Newsletter Widget.</p>
		<?php
	}
}
