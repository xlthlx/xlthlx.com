<?php
/**
 * Archive Widget.
 *
 * @package  xlthlx
 */

/**
 * Archive Widget Class.
 */
class Archive_Widget extends WP_Widget {

	/**
	 * Widget Constructor.
	 *
	 * @return void
	 */
	public function __construct() {

		// Setup Widget.
		parent::__construct(
			'xlthlx-archive', // ID.
			esc_html__( 'Archives by year', 'xlthlx' ), // Name.
			array(
				'description'                 => esc_html__( 'Displays a post archive by year.', 'xlthlx' ),
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

		// Get Widget Settings.
		$settings = wp_parse_args( $instance, $this->default_settings() );
		// Output.
		echo $args['before_widget'];
		// Display Title.
		$this->widget_title( $args, $settings ); ?>

		<div class="textwidget light">

			<?php $this->render(); ?>

		</div>

		<?php
		echo $args['after_widget'];

		// End Output Buffering.
		ob_end_flush();
	}

	/**
	 * Set default settings of the widget.
	 *
	 * @return array
	 */
	private function default_settings() {

		return array(
			'title' => esc_html__( 'Archives', 'xlthlx' ),
		);
	}

	/**
	 * Displays Widget Title.
	 *
	 * @param array $args Widget args.
	 * @param array $settings Widget settings.
	 *
	 * @return void
	 */
	public function widget_title( $args, $settings ) {

		$widget_title = 'Archivi';
		if ( 'en' === get_lang() ) {
			$widget_title = 'Archives';
		}

		if ( ! empty( $widget_title ) ) :
			// Display Widget Title.
			echo '<h3 class="h2 pb-2 shadows">';
			echo $widget_title;
			echo '</h3>';
		endif;
	}

	/**
	 * Renders the Widget Content.
	 *
	 * @return void
	 */
	public function render() {
		xlt_get_years();
	}

	/**
	 * Update Widget Settings.
	 *
	 * @param array $new_instance New widget instance.
	 * @param array $old_instance Old widget instance.
	 *
	 * @return array $instance
	 */
	public function update( $new_instance, $old_instance ) {

		$instance          = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );

		return $instance;
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
		<?php
	}
}
