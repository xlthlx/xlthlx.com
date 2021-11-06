<?php
/**
 * Custom Widgets.
 *
 * @package  WordPress
 * @subpackage  Xlthlx
 */

/**
 * Archive Widget Class.
 */
class Archive_Widget extends WP_Widget {

	/**
	 * Widget Constructor.
	 */
	public function __construct() {

		// Setup Widget.
		parent::__construct(
			'xlthlx-archive', // ID.
			esc_html__( 'Archives by year', 'xlthlx' ), // Name.
			array(
				'description' => esc_html__( 'Displays a post archive by year.', 'xlthlx' ),
				'customize_selective_refresh' => true,
			) // Args.
		);
	}

	/**
	 * Main Function to display the widget.
	 *
	 * @param array $args / Parameters from widget area created with register_sidebar().
	 * @param array $instance / Settings for this widget instance.
	 *
	 *@uses this->render()
	 *
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

			<div class="textwidget">

				<?php
				if ( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) {
					$this->render_amp();
				}
				else {
					$this->render();
				}
				 ?>

			</div>

		<?php
		echo $args['after_widget'];

		// End Output Buffering.
		ob_end_flush();
	}

	/**
	 * Set default settings of the widget.
	 */
	private function default_settings() {

		return array(
			'title'    => esc_html__( 'Archives', 'xlthlx' ),
		);
	}

	/**
	 * Displays Widget Title.
	 *
	 * @param array $args
	 * @param array $settings
	 */
	public function widget_title( $args, $settings ) {

		// Add Widget Title Filter.
		$widget_title = apply_filters( 'widget_title', $settings['title'], $settings, $this->id_base );

		if ( ! empty( $widget_title ) ) :

			// Display Widget Title.
			echo $args['before_title'] . $widget_title . $args['after_title'];

		endif;
	}

	/**
	 * Renders the Widget Content AMP.
	 */
	public function render_amp() {

		global $wpdb;

		echo '<amp-accordion id="archives" class="accordion accordion-flush" animate>';

		$year_prev = null;
		$months    = $wpdb->get_results( "SELECT DISTINCT MONTH( post_date ) AS month ,  YEAR( post_date ) AS year, COUNT( id ) as post_count FROM $wpdb->posts WHERE post_status = 'publish' and post_date <= now( ) and post_type = 'post' GROUP BY month , year ORDER BY post_date DESC" );
		foreach ( $months as $month ) :
			$year_current = $month->year;

			if ( $year_current !== $year_prev ) {
				if ( $year_prev !== null ) {
					echo '</ul>
		</div>
	</div>
</section>';
				} ?>
				<section class="accordion-item">
				<h2 class="accordion-header" id="year-<?php echo $month->year; ?>">
					<button class="accordion-button collapsed">
						<?php echo $month->year; ?>
					</button>
				</h2>
				<div id="collapse-<?php echo $month->year; ?>" class="accordion-collapse collapse show">
				<div class="accordion-body months-container">
				<ul>
				<?php } ?>
					<li>
						<a href="<?php bloginfo( 'url' ) ?>/<?php echo $month->year; ?>/<?php echo date( "m", mktime( 0, 0, 0, $month->month, 1, $month->year ) ) ?>/">
							<?php echo date_i18n( "m", mktime( 0, 0, 0, $month->month, 1, $month->year ) ) ?>
						</a>
					</li>
			<?php $year_prev = $year_current;

		endforeach;
		echo '</ul>
		</div>
	</div>
</section>';

		echo '</amp-accordion>';

	}

	/**
	 * Renders the Widget Content.
	 */
	public function render() {

		global $wpdb;

		echo '<div class="accordion accordion-flush" id="archives">';

		$year_prev = null;
		$months    = $wpdb->get_results( "SELECT DISTINCT MONTH( post_date ) AS month ,  YEAR( post_date ) AS year, COUNT( id ) as post_count FROM $wpdb->posts WHERE post_status = 'publish' and post_date <= now( ) and post_type = 'post' GROUP BY month , year ORDER BY post_date DESC" );
		foreach ( $months as $month ) :
			$year_current = $month->year;

			if ( $year_current !== $year_prev ) {
				if ( $year_prev !== null ) {
					echo '</ul>
		</div>
	</div>
</div>';
				} ?>
				<div class="accordion-item">
				<h2 class="accordion-header" id="year-<?php echo $month->year; ?>">
					<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
							data-bs-target="#collapse-<?php echo $month->year; ?>" aria-expanded="false"
							aria-controls="collapse-<?php echo $month->year; ?>">
						<?php echo $month->year; ?>
					</button>
				</h2>
				<div id="collapse-<?php echo $month->year; ?>" class="accordion-collapse collapse" aria-labelledby="year-<?php echo $month->year; ?>" data-bs-parent="#archives">
				<div class="accordion-body months-container">
				<ul>
				<?php } ?>
					<li>
						<a href="<?php bloginfo( 'url' ) ?>/<?php echo $month->year; ?>/<?php echo date( "m", mktime( 0, 0, 0, $month->month, 1, $month->year ) ) ?>/">
							<?php echo date_i18n( "m", mktime( 0, 0, 0, $month->month, 1, $month->year ) ) ?>
						</a>
					</li>
			<?php $year_prev = $year_current;

		endforeach;
		echo '</ul>
		</div>
	</div>
</div>';

		echo '</div>';

	}

	/**
	 * Update Widget Settings.
	 *
	 * @param array $new_instance
	 * @param array $old_instance
	 *
	 * @return array $instance
	 */
	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );

		return $instance;
	}

	/**
	 * Displays Widget Settings Form in the Backend.
	 *
	 * @param array $instance
	 */
	function form( $instance ) {

		// Get Widget Settings.
		$settings = wp_parse_args( $instance, $this->default_settings() );
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'xlthlx' ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $settings['title'] ); ?>" />
			</label>
		</p>

		<?php
	}
}

/**
 * Related Articles Widget Class.
 */
class Related_Widget extends WP_Widget {

	/**
	 * Widget Constructor.
	 */
	public function __construct() {

		// Setup Widget.
		parent::__construct(
			'xlthlx-related', // ID.
			esc_html__( 'Related articles', 'xlthlx' ), // Name.
			array(
				'description' => esc_html__( 'Displays related articles.', 'xlthlx' ),
				'customize_selective_refresh' => true,
			) // Args.
		);
	}

	/**
	 * Main Function to display the widget.
	 *
	 * @param array $args
	 * @param array $instance
	 *
	 *@uses this->render()
	 *
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

			<div class="textwidget">

				<?php $this->render(); ?>

			</div>

		<?php
		echo $args['after_widget'];

		// End Output Buffering.
		ob_end_flush();
	}

	/**
	 * Set default settings of the widget.
	 */
	private function default_settings() {

		return array(
			'title'    => esc_html__( 'Related articles', 'xlthlx' ),
		);
	}

	/**
	 * Displays Widget Title.
	 *
	 * @param array $args
	 * @param array $settings
	 */
	public function widget_title( $args, $settings ) {

		// Add Widget Title Filter.
		$widget_title = apply_filters( 'widget_title', $settings['title'], $settings, $this->id_base );

		if ( ! empty( $widget_title ) ) :

			// Display Widget Title.
			echo $args['before_title'] . $widget_title . $args['after_title'];

		endif;
	}

	/**
	 * Renders the Widget Content.
	 */
	public function render() {

		$related_links = '';

		if ( is_single() ) {

			global $post;

			$num_posts = 5;
			$count     = 0;
			$postIDs   = array( $post->ID );
			$related   = '';
			$cats      = wp_get_post_categories( $post->ID );

			if ( $count <= ( $num_posts - 1 ) ) {

				$catIDs = array();
				foreach ( $cats as $cat ) {
					$catIDs[] = $cat;
				}

				$show_posts = $num_posts - $count;

				$args = array(
						'category__in'        => $catIDs,
						'post__not_in'        => $postIDs,
						'showposts'           => $show_posts,
						'ignore_sticky_posts' => 1,
						'orderby'             => 'rand',
						'tax_query'           => array(
								array(
										'taxonomy' => 'post_format',
										'field'    => 'slug',
										'terms'    => array(
												'post-format-link',
												'post-format-status',
												'post-format-aside',
												'post-format-quote'
										),
										'operator' => 'NOT IN'
								)
						)
				);

				$cat_query = new WP_Query( $args );

				if ( $cat_query->have_posts() ) {

					while ( $cat_query->have_posts() ) {

						$cat_query->the_post();

						$related .= '<li><a href="' . get_permalink() . '" rel="bookmark" title="' . get_the_title() . '">' . get_the_title() . '</a></li>';
					}
				}
			}

			if ( $related ) {

				$related_links = '<ul class="menu">' . $related . '</ul>';
			}

			wp_reset_query();
		}

		echo $related_links;

	}

	/**
	 * Update Widget Settings.
	 *
	 * @param array $new_instance
	 * @param array $old_instance
	 *
	 * @return array $instance
	 */
	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );

		return $instance;
	}

	/**
	 * Displays Widget Settings Form in the Backend.
	 *
	 * @param array $instance
	 */
	function form( $instance ) {

		// Get Widget Settings.
		$settings = wp_parse_args( $instance, $this->default_settings() );
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'xlthlx' ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $settings['title'] ); ?>" />
			</label>
		</p>

		<?php
	}
}

/**
 * Register Widgets.
 */
function xlt_register_widget() {

	register_widget( 'Archive_Widget' );
	register_widget( 'Related_Widget' );

}

add_action( 'widgets_init', 'xlt_register_widget' );
