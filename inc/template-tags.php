<?php
/**
 * Custom template tags.
 *
 * @package  WordPress
 * @subpackage  Xlthlx
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
		$return = $args['before'];
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

		$args = array(
			'before'        => '<li class="breadcrumb-item" itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem">',
			'before_active' => '<li class="breadcrumb-item active" aria-current="page" itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem">',
			'link'          => '<a href="%1$s" title="%2$s" itemscope itemtype="https://schema.org/Thing" itemprop="item" itemid="%1$s">%3$s</a>',
			'active'        => '<span itemscope itemtype="https://schema.org/Thing" itemprop="name" itemid="%1$s">%2$s</span>',
			'name'          => '<span itemprop="name">%1$s</span>',
			'position'      => '<meta itemprop="position" content="%1$s">',
			'text'          => array(
				'home'     => __( 'Home' ),
				'category' => '%s',
				'search'   => __( 'Search results for "%s"' ),
				'tag'      => '%s',
				'author'   => __( 'Posts by %s' ),
				'404'      => __( 'Error 404' ),
				'page'     => __( 'Page %s' ),
				'cpage'    => __( 'Comments page %s' )
			)
		);

		global $post;
		$home_url  = home_url( '/' );
		$parent_id = $post->post_parent ?? 0;
		$lang      = get_lang();
		$title     = ( 'en' === $lang ) ? get_title_en() : get_the_title();


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
					echo xlt_get_link( $args, get_category_link( $cat ), get_cat_name( $cat ), $position );
				}
				if ( get_query_var( 'paged' ) ) {
					$position ++;
					echo xlt_get_link( $args, get_category_link( get_query_var( 'cat' ) ), get_cat_name( get_query_var( 'cat' ) ), $position );
					echo $args['before'] . sprintf( $args['text']['page'], get_query_var( 'paged' ) );

				} else {
					$position ++;
					echo $args['before_active'] . sprintf( $args['active'], get_permalink(), sprintf( $args['name'], sprintf( $args['text']['category'], single_cat_title( '', false ) ) ) ) . sprintf( $args['position'], $position );
				}
			} elseif ( is_search() ) {
				if ( get_query_var( 'paged' ) ) {

					$position ++;
					echo xlt_get_link( $args, $home_url . '?s=' . get_search_query(), sprintf( $args['text']['search'], get_search_query() ), $position );
					echo $args['before'] . sprintf( $args['text']['page'], get_query_var( 'paged' ) );

				} else {

					$position ++;
					echo $args['before_active'] . sprintf( $args['active'], get_permalink(), sprintf( $args['text']['search'], get_search_query() ) ) . sprintf( $args['position'], $position );


				}
			} elseif ( is_year() ) {

				$position ++;
				echo $args['before_active'] . sprintf( $args['active'], get_permalink(), get_the_time( 'Y' ) ) . sprintf( $args['position'], $position );


			} elseif ( is_month() ) {

				$position ++;
				echo xlt_get_link( $args, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ), $position );

				$position ++;
				echo $args['before_active'] . sprintf( $args['active'], get_permalink(), get_the_time( 'F' ) ) . sprintf( $args['position'], $position );

			} elseif ( is_day() ) {

				$position ++;
				echo xlt_get_link( $args, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ), $position );

				$position ++;
				echo xlt_get_link( $args, get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ), get_the_time( 'F' ), $position );


				$position ++;
				echo $args['before_active'] . sprintf( $args['active'], get_permalink(), get_the_time( 'd' ) ) . sprintf( $args['position'], $position );

			} elseif ( is_single() && ! is_attachment() ) {
				$post_type = get_post_type_object( get_post_type() );
				if ( $post_type && get_post_type() !== 'post' ) {
					$position ++;
					echo xlt_get_link( $args, get_post_type_archive_link( $post_type->name ), $post_type->labels->name, $position );
					$position ++;
					$args['before_active'] . sprintf( $args['active'], get_permalink(), $title ) . sprintf( $args['position'], $position );

				} else {
					$cat       = get_the_category();
					$catID     = $cat[0]->cat_ID;
					$parents   = array_reverse( get_ancestors( $catID, 'category' ) );
					$parents[] = $catID;

					foreach ( $parents as $cat ) {
						$position ++;
						echo xlt_get_link( $args, get_category_link( $cat ), get_cat_name( $cat ), $position );
					}

					if ( get_query_var( 'cpage' ) ) {
						$position ++;
						echo xlt_get_link( $args, get_permalink(), $title, $position );

						$position ++;
						echo $args['before_active'] . sprintf( $args['active'], get_permalink(), sprintf( $args['text']['cpage'], get_query_var( 'cpage' ) ) ) . sprintf( $args['position'], $position );

					} else {
						$position ++;
						echo $args['before_active'] . sprintf( $args['active'], get_permalink(), sprintf( $args['name'], $title ) ) . sprintf( $args['position'], $position );

					}
				}
			} elseif ( is_post_type_archive() ) {
				$post_type = get_post_type_object( get_post_type() );
				if ( $post_type && get_query_var( 'paged' ) ) {

					$position ++;
					echo xlt_get_link( $args, get_post_type_archive_link( $post_type->name ), $post_type->label, $position );

					$position ++;
					echo $args['before_active'] . sprintf( $args['active'], get_permalink(), sprintf( $args['text']['page'], get_query_var( 'paged' ) ) ) . sprintf( $args['position'], $position );
				} else {

					$position ++;
					echo $args['before_active'] . sprintf( $args['active'], get_permalink(), $post_type->label ) . sprintf( $args['position'], $position );

				}

			} elseif ( is_attachment() ) {
				$parent    = get_post( $parent_id );
				$cat       = get_the_category( $parent->ID );
				$catID     = $cat[0]->cat_ID;
				$parents   = array_reverse( get_ancestors( $catID, 'category' ) );
				$parents[] = $catID;
				foreach ( $parents as $cat ) {
					$position ++;
					echo xlt_get_link( $args, get_category_link( $cat ), get_cat_name( $cat ), $position );
				}

				$position ++;
				echo xlt_get_link( $args, get_permalink( $parent ), $parent->post_title, $position );

				$position ++;
				echo $args['before_active'] . sprintf( $args['active'], get_permalink(), $title ) . sprintf( $args['position'], $position );

			} elseif ( ! $parent_id && is_page() ) {

				$position ++;
				echo $args['before_active'] . sprintf( $args['active'], get_permalink(), $title ) . sprintf( $args['position'], $position );


			} elseif ( $parent_id && is_page() ) {
				$parents = get_post_ancestors( get_the_ID() );
				foreach ( array_reverse( $parents ) as $pageID ) {
					$position ++;
					echo xlt_get_link( $args, get_page_link( $pageID ), get_the_title( $pageID ), $position );
				}

				$position ++;
				echo $args['before_active'] . sprintf( $args['active'], get_permalink(), $title ) . sprintf( $args['position'], $position );

			} else if ( is_tag() ) {
				if ( get_query_var( 'paged' ) ) {
					$position ++;
					$tagID = get_query_var( 'tag_id' );
					echo xlt_get_link( $args, get_tag_link( $tagID ), single_tag_title( '', false ), $position );

					$position ++;
					echo $args['before_active'] . sprintf( $args['active'], get_permalink(), sprintf( $args['text']['page'], get_query_var( 'paged' ) ) ) . sprintf( $args['position'], $position );
				} else {

					$position ++;
					echo $args['before_active'] . sprintf( $args['active'], get_permalink(), sprintf( $args['text']['tag'], single_tag_title( '', false ) ) ) . sprintf( $args['position'], $position );

				}
			} elseif ( is_author() ) {
				$author = get_userdata( get_query_var( 'author' ) );
				if ( get_query_var( 'paged' ) ) {

					$position ++;
					echo xlt_get_link( $args, get_author_posts_url( $author->ID ), sprintf( $args['text']['author'], $author->display_name ), $position );

					$position ++;
					echo $args['before_active'] . sprintf( $args['active'], get_permalink(), sprintf( $args['text']['page'], get_query_var( 'paged' ) ) ) . sprintf( $args['position'], $position );

				} else {

					$position ++;
					echo $args['before_active'] . sprintf( $args['active'], get_permalink(), sprintf( $args['text']['author'], $author->display_name ) ) . sprintf( $args['position'], $position );

				}
			} elseif ( is_404() ) {

				$position ++;
				echo $args['before_active'] . sprintf( $args['active'], get_permalink(), $args['text']['404'] ) . sprintf( $args['position'], $position );

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

if ( ! function_exists( 'xlt_countdown' ) ) {
	/**
	 * Countdown.
	 *
	 * @return string
	 * @throws Exception
	 */
	function xlt_countdown() {

		$start_date = '2021-12-25 23:59:59';
		$end_date   = date( 'Y-m-d H:i:s' );

		$datetime1 = new DateTime( $start_date );
		$datetime2 = new DateTime( $end_date );
		$interval  = $datetime1->diff( $datetime2 );
		$days      = $interval->days;

		if ( $datetime1 <= $datetime2 ) {
			$count_down = '';

		} else {
			$count_down = '<div class="container bg-white pt-4 mt-0 pb-0 px-4">';
			$count_down .= '<div class="alert alert-secondary text-center mb-0 rounded-0 border-0 pink" role="alert">';
			$link       = "Christmas";
			$text       = ( (string) $days === '1' ) ? ' day to ' : ' days to ';
			$count_down .= $days . $text . $link;
			$count_down .= '</div>';
			$count_down .= '</div>';
		}

		return $count_down;
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

		$warning = '';

		if ( ! $post_id ) {
			global $post;
			$post_id = $post->ID;
		}

		$today         = current_time( 'Y-m-d' );
		$postdate      = get_the_date( 'Y-m-d', $post_id );
		$today_str     = strtotime( $today );
		$post_date_str = strtotime( $postdate );
		$diff          = ( $today_str - $post_date_str ) / 60 / 60 / 24;
		$days          = 365;
		if ( $diff > $days ) {
			if ( $lang !== 'en' ) {
				$warning = '<div class="alert alert-primary rounded-0 border-0" role="alert"><small>Attenzione: questo articolo è stato scritto più di un anno fa, alcune informazioni potrebbero essere obsolete.</small></div>';
			} else {
				$warning = '<div class="alert alert-primary rounded-0 border-0" role="alert"><small>Warning: this article was written over a year ago, some information may be out of date.</small></div>';
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
		if ( false === strpos( $headers[0], "200" ) ) {
			$has_valid_avatar = false;
		} else {
			$has_valid_avatar = true;
		}

		return $has_valid_avatar;
	}
}
