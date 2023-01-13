<?php
/**
 * Related Articles Widget.
 *
 * @package  xlthlx
 */

/**
 * Related Articles Widget Class.
 */
class Related_Widget extends WP_Widget {

	/**
	 * Widget Constructor.
	 *
	 * @return void
	 */
	public function __construct() {
		// Setup Widget.
		parent::__construct(
			'xlthlx-related', // ID.
			esc_html__( '04 Related articles', 'xlthlx' ), // Name.
			array(
				'description'                 => esc_html__( 'Displays related articles.', 'xlthlx' ),
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
		$this->widget_title( $args, $settings );
		?>

			<?php $this->render( $settings['title'] ); ?>

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
			'title' => esc_html__( 'Related articles', 'xlthlx' ),
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

		$widget_title = 'Articoli correlati';
		if ( 'en' === get_lang() ) {
			$widget_title = 'Related articles';
		}

		echo $args['before_title'] . $widget_title . $args['after_title'];
	}

	/**
	 *  Renders the Widget Content.
	 *
	 * @param string $widget_title The Widget title.
	 *
	 * @return void
	 */
	public function render( $widget_title ) {

		$related_links = '';

		if ( is_single() ) {

			global $post;

			$num_posts = 6;
			$count     = 0;
			$post_ids  = array( $post->ID );
			$related   = '';
			$cats      = wp_get_post_categories( $post->ID );

			if ( $count <= ( $num_posts - 1 ) ) {

				$cat_ids = array();
				foreach ( $cats as $cat ) {
					$cat_ids[] = $cat;
				}

				$show_posts = $num_posts - $count;

				$args = array(
					'category__in'        => $cat_ids,
					'post__not_in'        => $post_ids,
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
								'post-format-quote',
							),
							'operator' => 'NOT IN',
						),
					),
				);

				$cat_query = new WP_Query( $args );

				if ( $cat_query->have_posts() ) {

					while ( $cat_query->have_posts() ) {

						$cat_query->the_post();

						$title = ( 'en' === get_lang() ) ? get_title_en() : get_the_title();
						$link  = ( 'en' === get_lang() ) ? get_permalink() . 'en/' : get_permalink();

						$related .= '<li><a href="' . $link . '" rel="bookmark" title="' . $title . '">' . $title . '</a></li>';
					}
				}
			}

			if ( $related ) {

				$class = 'menu';

				if ( 'Related articles' !== $widget_title ) {
					$class = 'two-columns';
				}

				$related_links = '<ul class="' . $class . '">' . $related . '</ul>';
			}

			wp_reset_query();
		}

		echo $related_links;

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

		// Get Widget Settings.
		$settings = wp_parse_args( $instance, $this->default_settings() );
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'xlthlx' ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
					   name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"
					   value="<?php echo esc_attr( $settings['title'] ); ?>"/>
			</label>
		</p>

		<?php
	}
}
