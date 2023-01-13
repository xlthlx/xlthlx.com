<?php
/**
 * Images Widget.
 *
 * @package  xlthlx
 */

/**
 * Images Widget Class.
 */
class Images_Widget extends WP_Widget {

	/**
	 * Widget Constructor.
	 *
	 * @return void
	 */
	public function __construct() {

		// Setup Widget.
		parent::__construct(
			'xlthlx-images', // ID.
			esc_html__( '03 Images', 'xlthlx' ), // Name.
			array(
				'description'                 => esc_html__( 'Displays some images.', 'xlthlx' ),
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
		if ( ( 'en' === $lang ) ) { 
			?>
				<figure class="wp-block-image size-full is-style-default">
					<a title="#FixTheDigitalStatus!" href="https://the3million.org.uk/fix-the-digital-status" target="_blank">
						<picture>
							<source srcset="<?php echo get_template_directory_uri(); ?>/assets/img/fix-digital-status.webp" type="image/webp">
							<source srcset="<?php echo get_template_directory_uri(); ?>/assets/img/fix-digital-status.jpg" type="image/jpeg">
							<img width="300" height="120" src="<?php echo get_template_directory_uri(); ?>/assets/img/fix-digital-status.jpg" alt="#FixTheDigitalStatus!" class="img-fluid" srcset="<?php echo get_template_directory_uri(); ?>/assets/img/fix-digital-status.jpg 300w, <?php echo get_template_directory_uri(); ?>/assets/img/fix-digital-status-150x60.jpg 150w" sizes="(max-width: 300px) 100vw, 300px">
						</picture>
					</a>
				</figure>
		<?php } else { ?>
				<figure class="wp-block-image size-full is-style-default">
					<a title="Sbattèzzati!" href="https://www.sbattezzati.it/" target="_blank">
						<picture>
							<source srcset="<?php echo get_template_directory_uri(); ?>/assets/img/exit.webp" type="image/webp">
							<source srcset="<?php echo get_template_directory_uri(); ?>/assets/img/exit.jpg" type="image/jpeg">
							<img width="300" height="78" src="<?php echo get_template_directory_uri(); ?>/assets/img/exit.jpg" alt="Sbattèzzati!" class="img-fluid" srcset="<?php echo get_template_directory_uri(); ?>/assets/img/exit.jpg 300w, <?php echo get_template_directory_uri(); ?>/assets/img/exit-150x39.jpg 150w" sizes="(max-width: 300px) 100vw, 300px">
						</picture>
					</a>
				</figure>
			<?php
		}
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
		<p>Images Widget.</p>
		<?php
	}
}
