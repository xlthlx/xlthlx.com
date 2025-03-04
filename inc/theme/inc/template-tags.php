<?php
/**
 * Custom template tags.
 *
 * @package  xlthlx
 */

if ( ! function_exists( 'xlt_get_link' ) ) {
	/**
	 * Set up the single link.
	 *
	 * @param array  $args Link args.
	 * @param string $link Link.
	 * @param string $name Link name.
	 * @param string $position Link position.
	 *
	 * @return string
	 */
	function xlt_get_link( $args, $link, $name, $position ) {
		$return  = $args['before'];
		$return .= sprintf(
			$args['link'],
			$link,
			$name,
			sprintf( $args['name'], $name )
		);
		$return .= sprintf( $args['position'], $position );

		return $return;
	}
}

if ( ! function_exists( 'xlt_comment_form' ) ) {
	/**
	 * Custom comments form.
	 *
	 * @param int|bool $post_id The post ID.
	 *
	 * @return void
	 */
	function xlt_comment_form( $post_id = false ) {

		$comments_args = array(
			'format'               => 'html5',
			'label_submit'         => 'Invia commento',
			'comment_notes_before' => '<p class="comment-notes"><span id="email-notes">Il tuo indirizzo email non sarà pubblicato.</span></p>',
			'class_submit'         => 'submit',
			'comment_field'        => '<p class="comment-form-comment">
        <label for="comment">Commento</label>
        <textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" required="required"></textarea>
    </p>
    <input id="comment_lang" name="comment_lang" type="hidden" value="it" />',
			'fields'               => array(
				'author' => '<p class="comment-form-author">
        <label for="author">Nome</label>
        <input id="author" name="author" type="text" value="" size="30" maxlength="245" autocomplete="name" required="required"/>
    </p>',
				'email'  => '<p class="comment-form-email">
        <label for="email">Email</label>
        <input id="email" name="email" type="email" value="" size="30" maxlength="100"
               aria-describedby="email-notes" autocomplete="email" required="required"/>
    </p>',
				'url'    => '    <p class="comment-form-url">
        <label for="url">Sito web</label>
        <input id="url" name="url" type="url" size="30" maxlength="200" autocomplete="url"/>
    </p>
    <p id="comment-subscribe">
	' . wp_nonce_field( 'nonce_comment', 'nonce_comment', true, false ) . '
	  <input class="form-check-input" type="checkbox" value="1" name="comment_subscribe" id="comment_subscribe">
	  <label class="form-check-label" for="comment_subscribe">
	    Avvisami quando vengono aggiunti nuovi commenti
	  </label>
	</p>',
			),
		);

		if ( $post_id ) {
			comment_form( $comments_args, $post_id );
		} else {
			comment_form( $comments_args );
		}
	}
}

if ( ! function_exists( 'xlt_comment_form_en' ) ) {
	/**
	 * Custom english comments form.
	 *
	 * @param int|bool $post_id The post ID.
	 *
	 * @return void
	 */
	function xlt_comment_form_en( $post_id = false ) {

		$comments_args = array(
			'format'               => 'html5',
			'label_submit'         => 'Send comment',
			'title_reply'          => 'Leave a comment',
			'title_reply_to'       => 'Reply to %s',
			'cancel_reply_link'    => 'Cancel reply',
			'comment_notes_before' => '<p class="comment-notes"><span id="email-notes">Your email address will not be published.</span></p>',
			'class_submit'         => 'submit',
			'comment_field'        => '<p class="comment-form-comment">
        <label for="comment">Comment</label>
        <textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" required="required"></textarea>
    </p>
    <input id="comment_lang" name="comment_lang" type="hidden" value="en" />
	<input id="en_redirect_to" name="en_redirect_to" type="hidden" value="true" />',
			'fields'               => array(
				'author' => '<p class="comment-form-author">
        <label for="author">Name</label>
        <input id="author" name="author" type="text" value="" size="30" maxlength="245" autocomplete="name" required="required"/>
    </p>',
				'email'  => '<p class="comment-form-email">
        <label for="email">Email</label>
        <input id="email" name="email" type="email" value="" size="30" maxlength="100"
               aria-describedby="email-notes" autocomplete="email" required="required"/>
    </p>',
				'url'    => '    <p class="comment-form-url">
        <label for="url">Website</label>
        <input id="url" name="url" type="url" size="30" maxlength="200" autocomplete="url"/>
    </p>
    <p id="comment-subscribe">
	' . wp_nonce_field( 'nonce_comment', 'nonce_comment', true, false ) . '
	  <input class="form-check-input" type="checkbox" value="1" name="comment_subscribe" id="comment_subscribe">
	  <label class="form-check-label" for="comment_subscribe">
	    Notify me when new comments are added
	  </label>
	</p>',
			),
		);

		if ( $post_id ) {
			comment_form( $comments_args, $post_id );
		} else {
			comment_form( $comments_args );
		}

	}
}

if ( ! function_exists( 'xlt_old_posts_warning' ) ) {
	/**
	 * Old posts warning.
	 *
	 * @param string   $lang Language.
	 * @param int|bool $post_id The post ID.
	 *
	 * @return string
	 */
	function xlt_old_posts_warning( $lang, $post_id = null ) {

		$warning = '';

		if ( ! $post_id ) {
			global $post;
			$post_id = $post->ID;
		}

		$post_categories = wp_get_post_categories(
			$post_id,
			array( 'fields' => 'slugs' )
		);

		$cats = array(
			'analytics',
			'android',
			'android-apps',
			'cosmetici',
			'git',
			'jquery',
			'makeup',
			'php',
			'plugin',
			'trucco',
			'wordpress',
		);

		$intersect = array_intersect( $post_categories, $cats );

		if ( ! empty( $intersect ) ) {
			$today_str     = strtotime( current_time( 'Y-m-d' ) );
			$post_date_str = strtotime( get_the_date( 'Y-m-d', $post_id ) );
			$diff          = ( $today_str - $post_date_str ) / 60 / 60 / 24;
			$days          = 365;
			$years         = floor( $diff / $days );
			$ay_label      = ( 'en' !== $lang ) ? 'un anno' : 'one year';
			$ys_label      = ( 'en' !== $lang ) ? 'anni' : 'years';
			$when          = ( 1 === (int) $years ) ? $ay_label : $years . ' ' . $ys_label;
			if ( $diff > $days ) {
				if ( 'en' !== $lang ) {
					$warning = '<blockquote><em>Attenzione: questo articolo è stato scritto più di ' . $when . ' fa, alcune informazioni potrebbero essere obsolete.</em></blockquote>';
				} else {
					$warning = '<blockquote><em>Warning: this article was written over ' . $when . ' ago, some information may be out of date.</em></blockquote>';
				}
			}
		}

		return $warning;

	}
}

if ( ! function_exists( 'xlt_get_avatar' ) ) {
	/**
	 * Get the gravatar or set a first letter avatar.
	 * Adds the comment author url if inserted.
	 *
	 * @param object $comment The comment object.
	 * @param string $author_name The comment author name.
	 *
	 * @return string
	 */
	function xlt_get_avatar( $comment, $author_name ) {
		$args = array(
			'size'    => '60',
			'default' => '404',
		);

		$url = get_avatar_url( $comment, $args );

		if ( ! xlt_gravatar_exists( $url ) ) {
			$first_letter = substr( xlt_clean( $author_name ), 0, 1 );
			$avatar       = '<div class="avatar avatar-60 photo letter-avatar">
							    <span>' . $first_letter . '</span>
							</div>';
		} else {
			$avatar = '<img class="avatar avatar-60 photo" height="60" width="60" loading="lazy"
                     decoding="async" src="' . $url . '" alt="' . $author_name . '">';
		}

		if ( '' !== $comment->comment_author_url ) {
			$avatar = '<a title="' . $comment->comment_author_url . '" target="_blank" href="' . $comment->comment_author_url . '">' . $avatar . '</a>';
		}

		return $avatar;
	}
}

if ( ! function_exists( 'xlt_get_author' ) ) {
	/**
	 * Gets the comment author with the url if inserted.
	 *
	 * @param object $comment The comment object.
	 *
	 * @return string
	 */
	function xlt_get_author( $comment ) {

		$author = $comment->comment_author;

		if ( '' !== $comment->comment_author_url ) {
			$author = '<a title="' . $comment->comment_author_url . '" target="_blank" href="' . $comment->comment_author_url . '">' . $comment->comment_author . '</a>';
		}

		return $author;
	}
}

if ( ! function_exists( 'xlt_clean' ) ) {
	/**
	 * Clean a string from all the special chars.
	 *
	 * @param string $string Any string.
	 *
	 * @return string|string[]|null
	 */
	function xlt_clean( $string ) {
		$string = str_replace( ' ', '', $string );

		return preg_replace( '/[^A-Za-z0-9\-]/', '', $string );
	}
}

if ( ! function_exists( 'xlt_gravatar_exists' ) ) {
	/**
	 * Check if the url is a valid gravatar.
	 *
	 * @param string $url Any url.
	 *
	 * @return bool
	 */
	function xlt_gravatar_exists( $url ) {
		$headers = get_headers( $url );
		if ( false === strpos( $headers[0], '200' ) ) {
			$has_valid_avatar = false;
		} else {
			$has_valid_avatar = true;
		}

		return $has_valid_avatar;
	}
}

if ( ! function_exists( 'xlt_get_file_content' ) ) {
	/**
	 * This method gets the content of a given file.
	 *
	 * @param string $file_path The file path.
	 *
	 * @return  string Content of $file_path
	 */
	function xlt_get_file_content( $file_path ) {

		global $wp_filesystem;
		require_once ABSPATH . '/wp-admin/includes/file.php';

		WP_Filesystem();
		$content = '';

		if ( $wp_filesystem->exists( $file_path ) ) {
			$content = $wp_filesystem->get_contents( $file_path );
		}

		return $content;

	}
}

if ( ! function_exists( 'xlt_get_url_content' ) ) {
	/**
	 * Get contents from a url.
	 *
	 * @param string $url The url to get the content from.
	 *
	 * @return false|mixed
	 */
	function xlt_get_url_content( $url ) {

		$response = wp_remote_get( $url );

		if ( is_array( $response ) && ! is_wp_error( $response ) ) {
			return $response['body'];
		}

		return false;
	}
}

if ( ! function_exists( 'xlt_get_url_from_href' ) ) {
	/**
	 * Returns a url from an HTML link.
	 *
	 * @param string $string The HTML link.
	 *
	 * @return string
	 */
	function xlt_get_url_from_href( $string ) {

		$re = '/href="(.*?)"/i';
		preg_match( $re, $string, $matches, PREG_OFFSET_CAPTURE );

		return $matches[1][0];
	}
}

if ( ! function_exists( 'xlt_get_menu_items' ) ) {
	/**
	 * Get a menu as array from location.
	 *
	 * @param string $theme_location Theme location.
	 *
	 * @return array
	 */
	function xlt_get_menu_items( $theme_location ) {

		$menu_list = array();

		$locations = get_nav_menu_locations();
		if ( ( $locations ) && isset( $locations[ $theme_location ] ) ) {

			$menu = get_term( $locations[ $theme_location ], 'nav_menu' );
			if ( null !== $menu && ! is_wp_error( $menu ) ) {

				$menu_items = wp_get_nav_menu_items( $menu->term_id );
				if ( $menu_items ) {

					$menu_list = array();
					$bool      = false;

					$i = 0;
					foreach ( $menu_items as $menu_item ) {
						if ( 0 === (int) $menu_item->menu_item_parent ) {

							$parent     = $menu_item->ID;
							$menu_array = array();
							$y          = 0;

							foreach ( $menu_items as $submenu ) {
								if ( isset( $submenu ) && (int) $submenu->menu_item_parent === (int) $parent ) {
									$bool       = true;
									$menu_array = xlt_get_arr( $submenu, $menu_array, $y );
									$y ++;
								}
							}

							$menu_list = xlt_get_arr( $menu_item, $menu_list, $i );

							if ( true === $bool && count( $menu_array ) > 0 ) {
								$menu_list[ $i ]['submenu'] = $menu_array;
							}
							$i ++;
						}
					}
				}
			}
		}

		return $menu_list;
	}

	/**
	 * Set up the menu array.
	 *
	 * @param object $menu The menu object.
	 * @param array  $menu_array The menu array.
	 * @param int    $i The menu position.
	 *
	 * @return array
	 */
	function xlt_get_arr( $menu, $menu_array, $i ) {
		global $lang;

		$menu_array[ $i ]['url']     = '#' !== $menu->url ? $menu->url : false;
		$title_en                    = '' !== get_title_en( $menu->object_id ) ? get_title_en( $menu->object_id ) : $menu->title;
		$menu_array[ $i ]['title']   = 'it' === $lang ? $menu->title : $title_en;
		$menu_array[ $i ]['target']  = ! empty( $menu->target ) ? ' target="' . $menu->target . '"' : '';
		$menu_array[ $i ]['classes'] = ! empty( $menu->classes ) ? implode( ' ', $menu->classes ) : '';

		return $menu_array;
	}
}

if ( ! function_exists( 'xlt_pagination' ) ) {
	/**
	 * Pagination.
	 *
	 * @param object $wp_query Query object.
	 * @param string $paged Page number.
	 *
	 * @return string
	 */
	function xlt_pagination( $wp_query, $paged ) {
		global $lang;

		$first    = 'Primo';
		$last     = 'Ultimo';
		$previous = 'Precedente';
		$next     = 'Successivo';

		if ( 'en' === $lang ) {
			$first    = 'First';
			$last     = 'Last';
			$previous = 'Previous';
			$next     = 'Next';
		}

		$return   = '';
		$max_page = $wp_query->max_num_pages;

		$pages_to_show         = 8;
		$pages_to_show_minus_1 = $pages_to_show - 1;
		$half_page_start       = floor( $pages_to_show_minus_1 / 2 );
		$half_page_end         = ceil( $pages_to_show_minus_1 / 2 );
		$start_page            = $paged - $half_page_start;

		if ( $start_page <= 0 ) {
			$start_page = 1;
		}

		$end_page = (int) $paged + (int) $half_page_end;
		if ( ( $end_page - $start_page ) !== $pages_to_show_minus_1 ) {
			$end_page = $start_page + $pages_to_show_minus_1;
		}

		if ( $end_page > $max_page ) {
			$start_page = $max_page - $pages_to_show_minus_1;
			$end_page   = $max_page;
		}

		if ( $start_page <= 0 ) {
			$start_page = 1;
		}

		if ( $max_page > 1 ) {

			if ( 1 < (int) $paged ) {
				$return .= '<a href="' . esc_url( get_pagenum_link() ) . '" class="page-numbers" title="' . $first . '">&laquo;</a>' . "\n";
			}

			$return .= str_replace( '<a href="', '<a class="page-numbers" title="' . $previous . '" href="', get_previous_posts_link( '&lsaquo;' ) ?? '' );

			if ( (int) $start_page >= 2 && $pages_to_show < $max_page ) {
				$return .= '<a href="' . esc_url( get_pagenum_link() ) . '" class="page-numbers" title="1">1</a>' . "\n";
				$return .= '<span class="page-numbers dots">&hellip;</span>';
			}

			for ( $i = $start_page; $i <= $end_page; $i ++ ) {
				if ( (int) $i === (int) $paged ) {
					$return .= '<span class="current page-numbers">' . number_format_i18n( $i ) . ' <span class="meta-nav screen-reader-text">(current)</span></span>';
				} else {
					$return .= '<a href="' . esc_url( get_pagenum_link( $i ) ) . '" class="page-numbers" title="' . number_format_i18n( $i ) . '">' . number_format_i18n( $i ) . '</a>';
				}
			}

			if ( (int) $end_page < $max_page ) {
				$return .= '<span class="page-numbers dots">&hellip;</span>';
				$return .= '<a href="' . esc_url( get_pagenum_link( $max_page ) ) . '" class="page-numbers" title="' . $max_page . '">' . $max_page . '</a>';
			}

			$return .= str_replace( '<a href="', '<a class="page-numbers" title="' . $next . '" href="', get_next_posts_link( '&rsaquo;', $max_page ) );

			if ( (int) $max_page > (int) $paged ) {
				$return .= '<a href="' . esc_url( get_pagenum_link( $max_page ) ) . '" class="page-numbers" title="' . $last . '">&raquo;</a>';
			}
		}

		return $return;
	}
}

if ( ! function_exists( 'xlt_get_the_terms' ) ) {

	/**
	 * Function to return list of the terms.
	 *
	 * @param string $taxonomy The taxonomy.
	 * @param bool   $cut No idea.
	 *
	 * @return string Returns the list of elements.
	 */
	function xlt_get_the_terms( $taxonomy, $cut = false ) {

		$all_terms = '';
		$terms     = get_the_terms( get_the_ID(), $taxonomy );

		if ( $terms && ! is_wp_error( $terms ) ) {

			$term_links = array();

			foreach ( $terms as $term ) {
				$term_links[] = '<a href="' . esc_attr( get_term_link( $term->slug, $taxonomy ) ) . '">' . esc_html( $term->name ) . '</a>';
			}

			if ( $cut ) {
				$term_links    = array();
				$key           = count( $terms ) - 1;
				$term_links[0] = '<a href="' . esc_attr( get_term_link( $terms[ $key ]->slug, $taxonomy ) ) . '">' . esc_html( $terms[ $key ]->name ) . '</a>';
			}

			$all_terms = implode( ', ', $term_links );
		}

		return $all_terms;

	}
}

if ( ! function_exists( 'xlt_get_years' ) ) {
	/**
	 * Returns a list of years excluding $actual_year.
	 *
	 * @param string $actual_year The current year.
	 *
	 * @return void
	 */
	function xlt_get_years( $actual_year = null ) {
		global $wpdb, $lang;

		$array = array();

		$years = $wpdb->get_results( "SELECT DISTINCT YEAR( post_date ) AS year FROM $wpdb->posts WHERE post_status = 'publish' and post_date <= now( ) and post_type = 'post' GROUP BY YEAR( post_date ) ORDER BY post_date DESC" );

		$url = '/';
		if ( 'en' === $lang ) {
			$url .= 'en/';
		}

		foreach ( $years as $year ) {
			if ( ( isset( $actual_year ) ) && $year->year === $actual_year ) {
				$array[] = '<strong>' . $year->year . '</strong>';
			} else {
				$array[] = '<a href="' . home_url( '/' ) . $year->year . $url . '">' . $year->year . '</a>';
			}
		}

		echo implode( ' ', $array );
	}
}

if ( ! function_exists( 'xlt_get_months' ) ) {
	/**
	 * Returns a list of months archives based on $year.
	 *
	 * @param string $year The year.
	 * @param string $actual_month The current month.
	 *
	 * @return void
	 */
	function xlt_get_months( $year, $actual_month = null ) {
		global $wpdb, $lang;

		$array = array();

		$months = $wpdb->get_results( $wpdb->prepare( "SELECT DISTINCT MONTH( post_date ) AS month FROM $wpdb->posts WHERE post_status = 'publish' and post_date <= now( ) and post_type = 'post' and YEAR( post_date ) = %s GROUP BY MONTH( post_date ) ORDER BY post_date ASC", $year ) );

		$url = '/';
		if ( 'en' === $lang ) {
			$url .= 'en/';
		}

		foreach ( $months as $month ) {
			$l_month    = sprintf( '%02d', $month->month );
			$datetime   = $year . '-' . $l_month . '-01';
			$month_name = ( 'en' === $lang ) ? date( 'F', strtotime( $datetime ) ) : date_i18n( 'F', strtotime( $datetime ) );

			if ( ( isset( $actual_month ) ) && $actual_month === $month->month ) {
				$array[] = '<strong>' . $month_name . '</strong>';
			} else {
				$array[] = '<a href="' . home_url( '/' ) . $year . '/' . $l_month . $url . '">' . $month_name . '</a>';
			}
		}

		echo implode( ' ', $array );
	}
}

if ( ! function_exists( 'xlt_print_svg' ) ) {
	/**
	 * Print a svg into the HTML.
	 *
	 * @param string $svg The SVG url.
	 *
	 * @return string
	 */
	function xlt_print_svg( $svg ) {
		$file = get_template_directory() . $svg;

		return xlt_get_file_content( $file );
	}
}

if ( ! function_exists( 'xlt_atom_date' ) ) {
	/**
	 * Convert a date to ATOM format.
	 *
	 * @param string $date The date to convert.
	 *
	 * @return string
	 * @throws Exception Exception.
	 */
	function xlt_atom_date( $date ) {
		// @codingStandardsIgnoreStart
		return ( new DateTime( $date, new DateTimeZone( 'Europe/Rome' ) ) )->format( DateTimeInterface::ATOM );
		// @codingStandardsIgnoreEnd
	}
}

if ( ! function_exists( 'xlt_related_links' ) ) {
	/**
	 * Get related articles list.
	 *
	 * @return string
	 */
	function xlt_related_links() {
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

				$class = 'two-columns';

				$related_links = '<ul class="' . $class . '">' . $related . '</ul>';
			}

			wp_reset_query();
		}

		return $related_links;
	}
}
