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
	 * @param $args
	 * @param $link
	 * @param $name
	 * @param $position
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

if ( ! function_exists( 'xlt_breadcrumbs' ) ) {
	/**
	 * Breadcrumbs.
	 */
	function xlt_breadcrumbs() {

		global $post,$lang;

		$args = array(
			'before'        => '<li class="breadcrumb-item" itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem">',
			'before_active' => '<li class="breadcrumb-item active" aria-current="page" itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem">',
			'link'          => '<a href="%1$s" title="%2$s" itemscope itemtype="https://schema.org/Thing" itemprop="item" itemid="%1$s">%3$s</a>',
			'active'        => '<span itemscope itemtype="https://schema.org/Thing" itemprop="name" itemid="%1$s">%2$s</span>',
			'name'          => '<span itemprop="name">%1$s</span>',
			'position'      => '<meta itemprop="position" content="%1$s">',
			'text'          => array(
				'home'     => 'Home',
				'category' => '%s',
				'search'   => ( 'en' === $lang ) ? 'Search results for "%s"' : 'Risultati della ricerca per "%s"',
				'tag'      => '%s',
				'author'   => ( 'en' === $lang ) ? 'Posts by %s' : 'Articoli di %s',
				'404'      => ( 'en' === $lang ) ? 'Error 404' : 'Errore 404',
				'page'     => ( 'en' === $lang ) ? 'Page %s' : 'Pagina %s',
				'cpage'    => ( 'en' === $lang ) ? 'Comments page %s' : 'Commenti pagina %s',
			),
		);


		$home_url  = home_url( '/' );
		$parent_id = $post->post_parent ?? 0;
		if ( is_404() ) {
			$title = ( 'en' === $lang ) ? 'Error 404' : get_the_title();
		} else {
			$title = ( 'en' === $lang ) ? get_title_en( $post->ID ) : get_the_title();
		}

		$home_link = xlt_get_link( $args, $home_url, $args['text']['home'], 1 );

		if ( ! is_home() && ! is_front_page() ) {

			$position = 0;
			echo '<ol class="breadcrumb" id="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">';

			$position ++;
			echo $home_link;

			if ( is_category() ) {
				$parents = get_ancestors( get_query_var( 'cat' ), 'category' );
				foreach ( array_reverse( $parents ) as $cat ) {
					$position ++;
					echo xlt_get_link(
						$args,
						get_category_link( $cat ),
						get_cat_name( $cat ),
						$position
					);
				}
				if ( get_query_var( 'paged' ) ) {
					$position ++;
					echo xlt_get_link(
						$args,
						get_category_link( get_query_var( 'cat' ) ),
						get_cat_name( get_query_var( 'cat' ) ),
						$position
					);
					echo $args['before'] . sprintf(
						$args['text']['page'],
						get_query_var( 'paged' )
					);

				} else {
					$position ++;
					echo $args['before_active'] . sprintf(
						$args['active'],
						get_permalink(),
						sprintf(
							$args['name'],
							sprintf(
								$args['text']['category'],
								single_cat_title(
									'',
									false
								)
							)
						)
					) . sprintf(
						$args['position'],
						$position
					);
				}
			} elseif ( is_search() ) {
				if ( get_query_var( 'paged' ) ) {

					$position ++;
					echo xlt_get_link(
						$args,
						$home_url . '?s=' . get_search_query(),
						sprintf( $args['text']['search'], get_search_query() ),
						$position
					);
					echo $args['before'] . sprintf(
						$args['text']['page'],
						get_query_var( 'paged' )
					);

				} else {

					$position ++;
					echo $args['before_active'] . sprintf(
						$args['active'],
						get_permalink(),
						sprintf(
							$args['text']['search'],
							get_search_query()
						)
					) . sprintf(
						$args['position'],
						$position
					);


				}
			} elseif ( is_year() ) {

				$position ++;
				echo $args['before_active'] . sprintf(
					$args['active'],
					get_permalink(),
					get_the_time( 'Y' )
				) . sprintf(
					$args['position'],
					$position
				);


			} elseif ( is_month() ) {

				$month = get_the_time( 'F' );
				if ( 'en' === $lang ) {
					$month = get_trans( $month );
				}

				$position ++;
				echo xlt_get_link(
					$args,
					get_year_link( get_the_time( 'Y' ) ),
					get_the_time( 'Y' ),
					$position
				);

				$position ++;
				echo $args['before_active'] . sprintf(
					$args['active'],
					get_permalink(),
					$month
				) . sprintf(
					$args['position'],
					$position
				);

			} elseif ( is_day() ) {

				$month = get_the_time( 'F' );
				if ( 'en' === $lang ) {
					$month = get_trans( $month );
				}

				$position ++;
				echo xlt_get_link(
					$args,
					get_year_link( get_the_time( 'Y' ) ),
					get_the_time( 'Y' ),
					$position
				);

				$position ++;
				echo xlt_get_link(
					$args,
					get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ),
					$month,
					$position
				);


				$position ++;
				echo $args['before_active'] . sprintf(
					$args['active'],
					get_permalink(),
					get_the_time( 'd' )
				) . sprintf(
					$args['position'],
					$position
				);

			} elseif ( is_single() && ! is_attachment() ) {
				$post_type = get_post_type_object( get_post_type() );
				if ( $post_type && get_post_type() !== 'post' ) {
					$position ++;
					echo xlt_get_link(
						$args,
						get_post_type_archive_link( $post_type->name ),
						$post_type->labels->name,
						$position
					);
					$position ++;
					$args['before_active'] . sprintf(
						$args['active'],
						get_permalink(),
						$title
					) . sprintf(
						$args['position'],
						$position
					);

				} else {
					$cat       = get_the_category();
					$catID     = $cat[0]->cat_ID;
					$parents   = array_reverse( get_ancestors( $catID, 'category' ) );
					$parents[] = $catID;

					foreach ( $parents as $cat ) {
						$position ++;
						echo xlt_get_link(
							$args,
							get_category_link( $cat ),
							get_cat_name( $cat ),
							$position
						);
					}

					if ( get_query_var( 'cpage' ) ) {
						$position ++;
						echo xlt_get_link(
							$args,
							get_permalink(),
							$title,
							$position
						);

						$position ++;
						echo $args['before_active'] . sprintf(
							$args['active'],
							get_permalink(),
							sprintf(
								$args['text']['cpage'],
								get_query_var( 'cpage' )
							)
						) . sprintf(
							$args['position'],
							$position
						);

					} else {
						$position ++;
						echo $args['before_active'] . sprintf(
							$args['active'],
							get_permalink(),
							sprintf(
								$args['name'],
								$title
							)
						) . sprintf(
							$args['position'],
							$position
						);

					}
				}
			} elseif ( is_post_type_archive() ) {
				$post_type = get_post_type_object( get_post_type() );
				if ( $post_type && get_query_var( 'paged' ) ) {

					$position ++;
					echo xlt_get_link(
						$args,
						get_post_type_archive_link( $post_type->name ),
						$post_type->label,
						$position
					);

					$position ++;
					echo $args['before_active'] . sprintf(
						$args['active'],
						get_permalink(),
						sprintf(
							$args['text']['page'],
							get_query_var( 'paged' )
						)
					) . sprintf(
						$args['position'],
						$position
					);
				} else {

					$position ++;
					echo $args['before_active'] . sprintf(
						$args['active'],
						get_permalink(),
						$post_type->label
					) . sprintf(
						$args['position'],
						$position
					);

				}
			} elseif ( is_attachment() ) {
				$parent    = get_post( $parent_id );
				$cat       = get_the_category( $parent->ID );
				$catID     = $cat[0]->cat_ID;
				$parents   = array_reverse(
					get_ancestors(
						$catID,
						'category'
					)
				);
				$parents[] = $catID;
				foreach ( $parents as $cat ) {
					$position ++;
					echo xlt_get_link(
						$args,
						get_category_link( $cat ),
						get_cat_name( $cat ),
						$position
					);
				}

				$position ++;
				echo xlt_get_link(
					$args,
					get_permalink( $parent ),
					$parent->post_title,
					$position
				);

				$position ++;
				echo $args['before_active'] . sprintf(
					$args['active'],
					get_permalink(),
					$title
				) . sprintf(
					$args['position'],
					$position
				);

			} elseif ( ! $parent_id && is_page() ) {

				$position ++;
				echo $args['before_active'] . sprintf(
					$args['active'],
					get_permalink(),
					$title
				) . sprintf(
					$args['position'],
					$position
				);


			} elseif ( $parent_id && is_page() ) {
				$parents = get_post_ancestors( get_the_ID() );
				foreach ( array_reverse( $parents ) as $pageID ) {
					$position ++;
					echo xlt_get_link(
						$args,
						get_page_link( $pageID ),
						get_the_title( $pageID ),
						$position
					);
				}

				$position ++;
				echo $args['before_active'] . sprintf(
					$args['active'],
					get_permalink(),
					$title
				) . sprintf(
					$args['position'],
					$position
				);

			} elseif ( is_tag() ) {
				if ( get_query_var( 'paged' ) ) {
					$position ++;
					$tagID = get_query_var( 'tag_id' );
					echo xlt_get_link(
						$args,
						get_tag_link( $tagID ),
						single_tag_title( '', false ),
						$position
					);

					$position ++;
					echo $args['before_active'] . sprintf(
						$args['active'],
						get_permalink(),
						sprintf(
							$args['text']['page'],
							get_query_var( 'paged' )
						)
					) . sprintf(
						$args['position'],
						$position
					);
				} else {

					$position ++;
					echo $args['before_active'] . sprintf(
						$args['active'],
						get_permalink(),
						sprintf(
							$args['text']['tag'],
							single_tag_title(
								'',
								false
							)
						)
					) . sprintf(
						$args['position'],
						$position
					);

				}
			} elseif ( is_author() ) {
				$author = get_userdata( get_query_var( 'author' ) );
				if ( get_query_var( 'paged' ) ) {

					$position ++;
					echo xlt_get_link(
						$args,
						get_author_posts_url( $author->ID ),
						sprintf(
							$args['text']['author'],
							$author->display_name
						),
						$position
					);

					$position ++;
					echo $args['before_active'] . sprintf(
						$args['active'],
						get_permalink(),
						sprintf(
							$args['text']['page'],
							get_query_var( 'paged' )
						)
					) . sprintf(
						$args['position'],
						$position
					);

				} else {

					$position ++;
					echo $args['before_active'] . sprintf(
						$args['active'],
						get_permalink(),
						sprintf(
							$args['text']['author'],
							$author->display_name
						)
					) . sprintf(
						$args['position'],
						$position
					);

				}
			} elseif ( is_404() ) {

				$position ++;
				echo $args['before_active'] . sprintf(
					$args['active'],
					get_permalink(),
					$args['text']['404']
				) . sprintf(
					$args['position'],
					$position
				);

			} elseif ( has_post_format() && ! is_singular() ) {

				echo get_post_format_string( get_post_format() );
			}

			echo '</ol>';
		}
	}
}

if ( ! function_exists( 'xlt_comment_form' ) ) {
	/**
	 * Custom comments form.
	 */
	function xlt_comment_form( $post_id = false ) {

		$comments_args = array(
			'format'               => 'xhtml',
			'label_submit'         => 'Invia',
			'comment_notes_before' => '<p>Il tuo indirizzo email non sarà pubblicato.</p>',
			'class_submit'         => 'btn btn-outline-primary btn-lg py-1 px-5 pink-hover rounded-0',
			'fields'               => array(
				'author' => '<div class="form-floating mb-3">
							<input placeholder="Nome" class="form-control rounded-0" type="text" id="author" name="author" required>
							<label for="author">Nome</label>
						</div>',
				'email'  => '<div class="form-floating mb-3">
							<input placeholder="Email" class="form-control rounded-0" type="email" id="email" name="email" required>
							<label for="email">Email</label>
						</div>',
				'url'    => '<div class="form-floating mb-3">
							<input placeholder="Url" class="form-control rounded-0" type="url" id="url" name="url">
							<label for="url">Url</label>
						</div>',
			),
			'comment_field'        => '<div class="form-floating mb-3">
								<textarea placeholder="Commento" class="form-control rounded-0" id="comment" name="comment" style="height: 150px" required></textarea>
								<label for="comment">Commento</label>
								<input id="comment_lang" name="comment_lang" type="hidden" value="it" />
								<div id="lstc-comment-subscription" class="form-check mt-3">
								  <input class="form-check-input" type="checkbox" type="checkbox" value="1" name="lstc_subscribe" id="lstc_subscribe">
								  <label class="form-check-label" id="cnns-label" for="lstc_subscribe">
								    Avvisami quando vengono aggiunti nuovi commenti
								  </label>
								</div>
								</div>',
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
	 * @param bool $post_id
	 */
	function xlt_comment_form_en( $post_id = false ) {

		$comments_args = array(
			'format'               => 'xhtml',
			'label_submit'         => 'Send',
			'title_reply'          => 'Leave a comment',
			'title_reply_to'       => 'Reply to %s',
			'cancel_reply_link'    => 'Cancel reply',
			'comment_notes_before' => '<p>Your email address will not be published.</p>',
			'class_submit'         => 'btn btn-outline-primary btn-lg py-1 px-5 pink-hover rounded-0',
			'fields'               => array(
				'author' => '<div class="form-floating mb-3">
							<input placeholder="Name" class="form-control rounded-0" type="text" id="author" name="author" required>
							<label for="author">Name</label>
						</div>',
				'email'  => '<div class="form-floating mb-3">
							<input placeholder="Email" class="form-control rounded-0" type="email" id="email" name="email" required>
							<label for="email">Email</label>
						</div>',
				'url'    => '<div class="form-floating mb-3">
							<input placeholder="Url" class="form-control rounded-0" type="url" id="url" name="url">
							<label for="url">Url</label>
						</div>',
			),
			'comment_field'        => '<div class="form-floating mb-3">
								<textarea placeholder="Comment" class="form-control rounded-0" id="comment" name="comment" style="height: 150px" required></textarea>
								<label for="comment">Comment</label>
								<input id="comment_lang" name="comment_lang" type="hidden" value="en" />
								<input id="en_redirect_to" name="en_redirect_to" type="hidden" value="true" />
								<div id="lstc-comment-subscription" class="form-check mt-3">
								  <input class="form-check-input" type="checkbox" type="checkbox" value="1" name="lstc_subscribe" id="lstc_subscribe">
								  <label class="form-check-label" id="cnns-label" for="lstc_subscribe">
								    Notify me when new comments are added
								  </label>
								</div>
								</div>',
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
	 * @param $lang
	 * @param null $post_id
	 *
	 * @return string
	 */
	function xlt_old_posts_warning( $lang, $post_id = null ) {

		$warning = '<hr class="mt-2 mb-4 pt-0"/>';

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
			$ay_label      = ( $lang !== 'en' ) ? 'un anno' : 'one year';
			$ys_label      = ( $lang !== 'en' ) ? 'anni' : 'years';
			$when          = ( 1 === (int) $years ) ? $ay_label : $years . ' ' . $ys_label;
			if ( $diff > $days ) {
				if ( $lang !== 'en' ) {
					$warning = '<div class="alert alert-primary rounded-0 border-0 mt-2 black" role="alert"><small>Attenzione: questo articolo è stato scritto più di ' . $when . ' fa, alcune informazioni potrebbero essere obsolete.</small></div>';
				} else {
					$warning = '<div class="alert alert-primary rounded-0 border-0 mt-2 black" role="alert"><small>Warning: this article was written over ' . $when . ' ago, some information may be out of date.</small></div>';
				}
			}
		}

		return $warning;

	}
}

if ( ! function_exists( 'xlt_get_avatar' ) ) {
	/**
	 * Get the gravatar or set a first letter avatar.
	 *
	 * @param $comment
	 * @param $author_name
	 *
	 * @return string
	 */
	function xlt_get_avatar( $comment, $author_name ) {
		$args = array(
			'size'    => '64',
			'default' => '404',
		);

		$url = get_avatar_url( $comment, $args );

		if ( ! xlt_gravatar_exists( $url ) ) {
			$first_letter = substr( xlt_clean( $author_name ), 0, 1 );
			$avatar       = '<div class="letter-avatar">
							    <span>' . $first_letter . '</span>
							</div>';
		} else {
			$avatar = '<img class="img-fluid p-1" src="' . $url . '" alt="' . $author_name . '">';
		}

		return $avatar;
	}
}

if ( ! function_exists( 'xlt_clean' ) ) {
	/**
	 * Clean a string from all the special chars.
	 *
	 * @param $string
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
	 * @param $url
	 *
	 * @return bool
	 */
	function xlt_gravatar_exists( $url ) {
		$headers = @get_headers( $url );
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
	 * @param string $file_path
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

if ( ! function_exists( 'xlt_get_sticky_img' ) ) {
	/**
	 * Returns the HTML for the sticky image.
	 *
	 * @param int    $id
	 * @param string $alt
	 *
	 * @return string
	 */
	function xlt_get_sticky_img( $id, $alt ) {
		return wp_get_attachment_image(
			$id,
			array( '437', '225' ),
			false,
			array(
				'class'   => 'img-fluid grey_img',
				'alt'     => $alt,
				'loading' => false,
			)
		);
	}
}

if ( ! function_exists( 'xlt_get_url_from_href' ) ) {
	/**
	 * Returns a url from an HTML link.
	 *
	 * @param string $string
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
	 * @param $theme_location
	 *
	 * @return array
	 */
	function xlt_get_menu_items( $theme_location ) {

		$locations = get_nav_menu_locations();
		if ( ( $locations ) && isset( $locations[ $theme_location ] ) ) {

			$menu       = get_term( $locations[ $theme_location ], 'nav_menu' );
			$menu_items = wp_get_nav_menu_items( $menu->term_id );
			$menu_list  = array();
			$bool       = false;

			$i = 0;
			foreach ( $menu_items as $menu_item ) {
				if ( (int) $menu_item->menu_item_parent === 0 ) {

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

					if ( $bool === true && count( $menu_array ) > 0 ) {
						$menu_list[ $i ]['submenu'] = $menu_array;
					}
					$i ++;
				}
			}
		} else {
			$menu_list[] = '';
		}

		return $menu_list;
	}

	/**
	 * Set up the menu array.
	 *
	 * @param $menu
	 * @param array $menu_array
	 * @param int   $i
	 *
	 * @return array
	 */
	function xlt_get_arr( $menu, array $menu_array, int $i ): array {
		global $lang;

		$menu_array[ $i ]['url']     = $menu->url;
		$title_en                    = ( '' !== get_title_en( $menu->object_id ) ) ? get_title_en( $menu->object_id ) : $menu->title;
		$menu_array[ $i ]['title']   = ( 'it' === $lang ) ? $menu->title : $title_en;
		$menu_array[ $i ]['target']  = ! empty( $menu->target ) ? ' target="' . $menu->target . '"' : '';
		$menu_array[ $i ]['classes'] = implode( ' ', $menu->classes );

		return $menu_array;
	}
}

if ( ! function_exists( 'xlt_get_first_post' ) ) {
	/**
	 * Get the first or the sticky post.
	 *
	 * @return array
	 */
	function xlt_get_first_post() {

		$sticky = get_option( 'sticky_posts' );
		$first  = array_slice( $sticky, 0, 1 );

		$offset = array();

		if ( count( $first ) === 1 ) {
			$args             = array(
				'post__in'            => $first,
				'ignore_sticky_posts' => 1,
			);
			$first_post_query = get_posts( $args );
			$offset           = $first;
		} else {
			$args             = array( 'numberposts' => 1 );
			$first_post_query = get_posts( $args );

			if ( $first_post_query ) {
				foreach ( $first_post_query as $post ) {
					$offset[0] = $post->ID;
				}
			}
		}

		if ( count( $first ) === 1 ) {
			$offset = array_slice( $sticky, 0, 3 );
		}

		$return['first_post_query'] = $first_post_query;
		$return['offset']           = $offset;

		return $return;
	}
}

if ( ! function_exists( 'xlt_pagination' ) ) {
	/**
	 * Pagination.
	 *
	 * @param $wp_query
	 * @param $paged
	 *
	 * @return void
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

		$end_page = $paged + $half_page_end;
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

			$return  = '<nav class="mt-1 mb-5">' . "\n";
			$return .= '<ul class="pagination flex-wrap">' . "\n";

			if ( 1 < (int) $paged ) {
				$return .= '<li class="page-item">' . "\n";
				$return .= '<a href="' . esc_url( get_pagenum_link() ) . '" class="page-link btn-50" title="' . $first . '">&laquo;</a>' . "\n";
				$return .= '</li>' . "\n";
			}

			$return .= '<li class="page-item">' . "\n";
			$return .= str_replace( '<a href="', '<a class="page-link btn-50" title="' . $previous . '" href="', get_previous_posts_link( '&lsaquo;' ) );
			$return .= '</li>' . "\n";

			if ( (int) $start_page >= 2 && $pages_to_show < $max_page ) {
				$return .= '<li class="page-item">' . "\n";
				$return .= '<a href="' . esc_url( get_pagenum_link() ) . '" class="page-link btn-50" title="1">1</a>' . "\n";
				$return .= '</li>' . "\n";
				$return .= '<li class="page-item active" aria-current="page">
					<span class="page-link dots">...<span class="visually-hidden">(current)</span></span>
				  </li>';
			}

			for ( $i = $start_page; $i <= $end_page; $i ++ ) {
				if ( (int) $i === (int) $paged ) {
					$return .= '<li class="page-item active" aria-current="page">
						<span class="page-link page-number page-numbers current btn-50">' . number_format_i18n( $i ) . ' <span class="visually-hidden">(current)</span></span>
					</li>';
				} else {
					$return .= '<li class="page-item">' . "\n";
					$return .= '<a href="' . esc_url( get_pagenum_link( $i ) ) . '" class="page-link btn-50" title="' . number_format_i18n( $i ) . '">' . number_format_i18n( $i ) . '</a>';
					$return .= '</li>' . "\n";
				}
			}

			if ( (int) $end_page < $max_page ) {
				$return .= '<li class="page-item active" aria-current="page">
							<span class="page-link dots">...<span class="visually-hidden">(current)</span></span>
						  </li>';
				$return .= '<li class="page-item">' . "\n";
				$return .= '<a href="' . esc_url( get_pagenum_link( $max_page ) ) . '" class="page-link btn-50" title="' . $max_page . '">' . $max_page . '</a>';
				$return .= '</li>' . "\n";
			}

			$return .= '<li class="page-item">' . "\n";
			$return .= str_replace( '<a href="', '<a class="page-link btn-50" title="' . $next . '" href="', get_next_posts_link( '&rsaquo;', $max_page ) );
			$return .= '</li>' . "\n";

			if ( (int) $max_page > (int) $paged ) {
				$return .= '<li class="page-item">' . "\n";
				$return .= '<a href="' . esc_url( get_pagenum_link( $max_page ) ) . '" class="page-link btn-50" title="' . $last . '">&raquo;</a>';
				$return .= '</li>' . "\n";
			}
			$return .= '</ul>' . "\n";
			$return .= '</nav>' . "\n";
		}

		echo $return;
	}
}

if ( ! function_exists( 'xlt_get_the_terms' ) ) {

	/**
	 * Function to return list of the terms.
	 *
	 * @param string 'taxonomy'
	 *
	 * @return string Returns the list of elements.
	 */

	function xlt_get_the_terms( $taxonomy, $cut = false ) {

		$all_terms = '';
		$terms     = get_the_terms( get_the_ID(), $taxonomy );

		if ( $terms && ! is_wp_error( $terms ) ) {

			$term_links = array();

			foreach ( $terms as $term ) {
				$term_links[] = '<li class="d-inline fw-bold"><a href="' . esc_attr( get_term_link( $term->slug, $taxonomy ) ) . '">' . esc_html( $term->name ) . '</a></li>';
			}

			if ( $cut ) {
				$term_links    = array();
				$key           = count( $terms ) - 1;
				$term_links[0] = '<li class="d-inline fw-bold"><a href="' . esc_attr( get_term_link( $terms[ $key ]->slug, $taxonomy ) ) . '">' . esc_html( $terms[ $key ]->name ) . '</a></li>';
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
	 * @param $actual_year
	 *
	 * @return void
	 */
	function xlt_get_years( $actual_year = null ) {
		global $wpdb,$lang;

		$array = array();

		$years = $wpdb->get_results( "SELECT DISTINCT YEAR( post_date ) AS year FROM $wpdb->posts WHERE post_status = 'publish' and post_date <= now( ) and post_type = 'post' GROUP BY YEAR( post_date ) ORDER BY post_date DESC" );

		$url = '/';
		if ( 'en' === $lang ) {
			$url .= 'en/';
		}

		foreach ( $years as $year ) {
			if ( ( isset( $actual_year ) ) && $year->year === $actual_year ) {
				$array[] = '<span class="text-black">' . $year->year . '</span>';
			} else {
				$array[] = '<a href="' . home_url( '/' ) . $year->year . $url . '">' . $year->year . '</a>';
			}
		}

		echo implode( ' | ', $array );
	}
}

if ( ! function_exists( 'xlt_get_months' ) ) {
	/**
	 * Returns a list of months archives based on $year.
	 *
	 * @param $year
	 * @param $actual_month
	 *
	 * @return void
	 */
	function xlt_get_months( $year, $actual_month = null ) {
		global $wpdb,$lang;

		$array = array();

		$months = $wpdb->get_results( "SELECT DISTINCT MONTH( post_date ) AS month FROM $wpdb->posts WHERE post_status = 'publish' and post_date <= now( ) and post_type = 'post' and YEAR( post_date ) = $year GROUP BY MONTH( post_date ) ORDER BY post_date ASC" );

		$url = '/';
		if ( 'en' === $lang ) {
			$url .= 'en/';
		}

		foreach ( $months as $month ) {
			$l_month    = sprintf( '%02d', $month->month );
			$datetime   = $year . '-' . $l_month . '-01';
			$month_name = ( 'en' === $lang ) ? date( 'F', strtotime( $datetime ) ) : date_i18n( 'F', strtotime( $datetime ) );

			if ( ( isset( $actual_month ) ) && $actual_month === $month->month ) {
				$array[] = '<li><span class="text-black">' . $month_name . '</span></li>';
			} else {
				$array[] = '<li><a href="' . home_url( '/' ) . $year . '/' . $l_month . $url . '">' . $month_name . '</a></li>';
			}
		}

		echo implode( ' ', $array );
	}
}

if ( ! function_exists( 'xlt_print_svg' ) ) {
	/**
	 * @param string $svg
	 *
	 * @return string
	 */
	function xlt_print_svg( $svg ): string {
		$file    = get_template_directory() . $svg;
		return xlt_get_file_content( $file );
	}
}

if ( ! function_exists( 'xlt_get_related' ) ) {
	/**
	 * @param $post
	 *
	 * @return string
	 */
	function xlt_get_related( $post ): string {
		$related_links = '';
		global $lang;

		$num_posts = 6;
		$count     = 0;
		$postIDs   = [ $post->ID ];
		$related   = '';
		$cats      = wp_get_post_categories( $post->ID );

		if ( $count <= ( $num_posts - 1 ) ) {

			$catIDs = [];
			foreach ( $cats as $cat ) {
				$catIDs[] = $cat;
			}

			$show_posts = $num_posts - $count;

			$args = [
				'category__in'        => $catIDs,
				'post__not_in'        => $postIDs,
				'showposts'           => $show_posts,
				'ignore_sticky_posts' => 1,
				'orderby'             => 'rand',
				'tax_query'           => [
					[
						'taxonomy' => 'post_format',
						'field'    => 'slug',
						'terms'    => [
							'post-format-link',
							'post-format-status',
							'post-format-aside',
							'post-format-quote',
						],
						'operator' => 'NOT IN',
					],
				],
			];

			$cat_query = new WP_Query( $args );

			if ( $cat_query->have_posts() ) {

				while ( $cat_query->have_posts() ) {

					$cat_query->the_post();

					$title = ( 'en' === $lang ) ? get_title_en() : get_the_title();
					$link  = ( 'en' === $lang ) ? get_permalink() . 'en/' : get_permalink();
					$more  = ( 'en' === $lang ) ? "Keep reading: '" : "Continua a leggere: '";

					$related .= '<li><a href="' . $link . '" rel="bookmark" title="' . $more . $title . '">' . $title . '</a></li>';
				}
			}
		}

		if ( $related ) {

			$related_links = '<ul class="two-columns">' . $related . '</ul>';
		}

		wp_reset_query();

		return $related_links;
	}
}

