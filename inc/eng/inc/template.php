<?php
/**
 * Template (rewrite) functions for English translation.
 *
 * @package  xlthlx
 */

/**
 * Save comment meta lang.
 *
 * @param int $comment_id The comment ID.
 *
 * @return void
 */
function xlt_save_comment_lang( $comment_id ) {
	// @codingStandardsIgnoreStart
		update_comment_meta( $comment_id, 'comment_lang', $_POST['comment_lang'] );
	// @codingStandardsIgnoreEnd
}

add_action( 'comment_post', 'xlt_save_comment_lang' );

/**
 * Add query var.
 *
 * @param array $vars Query vars.
 *
 * @return array
 */
function xlt_query_vars_lang( $vars ) {
	$vars[] = 'en';

	return $vars;
}

add_filter( 'query_vars', 'xlt_query_vars_lang' );

/**
 * Template redirect for en.
 *
 * @param string $template The template filename.
 *
 * @return string
 */
function xlt_template_redirect( $template ) {
	global $wp_query;

	if ( ! isset( $wp_query->query_vars['en'] ) ) {
		return $template;
	}

	$url = get_abs_url();
	$url = str_replace( get_home_url() . '/en/', '', $url );

	$page = explode( '/', $url );

	if ( isset( $page[0], $page[1] ) && 'page' === $page[0] ) {
		set_query_var( 'page', (int) $page[1] );
		set_query_var( 'paged', (int) $page[1] );
	}

	if ( is_single() || is_preview() ) {
		$template = '/single.php';
	}

	if ( is_page() && ! is_paged() ) {
		$template = '/page.php';
	}

	$current_theme  = wp_get_theme();
	$page_templates = $current_theme->get_page_templates();

	foreach ( $page_templates as $key => $value ) {
		if ( is_page_template( $key ) ) {
			$template = '/' . $key;
		}
	}

	if ( is_page_template( 'template-film.php' ) ) {
		$template = '/template-film.php';
	}

	if ( is_page_template( 'template-tv.php' ) ) {
		$template = '/template-tv.php';
	}

	if ( is_404() ) {
		$template = '/404.php';
	}

	if ( is_archive() ) {
		$template = '/archive.php';
	}

	if ( is_search() ) {
		$template = '/search.php';
	}

	if ( is_front_page() ) {
		$template = '/home.php';
	}

	set_query_var( 'template', $template );
	return get_template_directory() . $template;
}

add_filter( 'template_include', 'xlt_template_redirect' );

/**
 * Add rewrite endpoints.
 *
 * @return void
 */
function xlt_rewrite_tags_lang() {
	add_rewrite_endpoint( 'en', EP_ALL, 'en' );
	add_rewrite_endpoint( 'search', EP_SEARCH, 's' );
}

add_action( 'init', 'xlt_rewrite_tags_lang' );

/**
 * Controls the number of search results.
 *
 * @param object $query The WP_Query instance.
 */
function xlt_home_posts_per_page( $query ) {

	if ( ! is_admin() && $query->is_main_query() && is_front_page() ) {
		set_query_var( 'posts_per_page', 5 );
	}
}

add_action( 'pre_get_posts', 'xlt_home_posts_per_page' );

/**
 * Set up an excerpt from $content.
 *
 * @param int $length Excerpt length.
 *
 * @return string
 * @throws Exception Exception.
 */
function xlt_get_excerpt( $length = 50 ) {

	global $lang,$post;
	$content = get_the_content();

	if ( isset( $post ) && 'en' === $lang ) {
		$content = get_content_en( $post->ID );
	}

	$content = strip_shortcodes( $content );
	$content = excerpt_remove_blocks( $content );
	$content = apply_filters( 'the_content', $content );
	$content = str_replace( ']]>', ']]&gt;', $content );
	$content = wp_trim_words( $content, $length, '...' );

	if ( '' === trim( $content ) ) {
		$content = ( 'en' === $lang ) ? get_trans( get_the_excerpt() ) : get_the_excerpt();
	}

	return $content;
}

/**
 * Filters the title.
 *
 * @param string $title The title.
 * @param int    $id The post ID.
 *
 * @return string
 */
function xlt_set_title_en( $title, $id ) {
	global $lang;

	if ( is_admin() ) {
		return $title;
	}

	$post = get_post( $id );

	if ( ! isset( $post ) ) {
		return $title;
	}

	if ( ( 'post' !== $post->post_type ) && ( 'page' !== $post->post_type ) && ( 'film' !== $post->post_type ) && ( 'tvseries' !== $post->post_type ) ) {
		return $title;
	}

	if ( 'en' === $lang ) {
		$title = get_title_en( $post->ID );
	}

	return $title;
}

add_filter( 'the_title', 'xlt_set_title_en', 10, 2 );

/**
 * Filters a taxonomy term object.
 *
 * @param WP_Term $term Term object.
 * @param string  $taxonomy The taxonomy slug.
 *
 * @return WP_Term
 */
function xlt_filter_term_name( $term, $taxonomy ) {

	global $lang;

	if ( is_admin() ) {
		return $term;
	}

	if ( 'category' !== $taxonomy ) {
		return $term;
	}

	if ( 'en' === $lang ) {

		$meta_value = get_term_meta( $term->term_id, 'category_en', true );

		if ( $meta_value ) {
			$term->name = $meta_value;
		}
	}

	return $term;
}

add_filter( 'get_term', 'xlt_filter_term_name', 10, 2 );

/**
 * Filters the term link.
 *
 * @param string  $termlink Term link URL.
 * @param WP_Term $term Term object.
 * @param string  $taxonomy Taxonomy slug.
 *
 * @return string
 */
function xlt_term_link_filter( $termlink, $term, $taxonomy ) {

	global $lang;

	if ( null === $term ) {
		return $termlink;
	}

	if ( is_admin() ) {
		return $termlink;
	}

	if ( 'category' !== $taxonomy ) {
		return $termlink;
	}

	if ( 'en' === $lang ) {
		$termlink = str_replace( '/cat/', '/cat/en/', $termlink );
	}

	return $termlink;

}

add_filter( 'term_link', 'xlt_term_link_filter', 10, 3 );

/**
 * Filters the search permalink.
 *
 * @param string $link Search permalink.
 * @param string $search The URL-encoded search term.
 *
 * @return string
 */
function xlt_search_link_filter( $link, $search ) {

	global $lang;

	if ( null === $search ) {
		return $link;
	}

	if ( is_admin() ) {
		return $link;
	}

	if ( 'en' === $lang ) {
		$link = str_replace( '/page/', '/en/page/', $link );
	}

	return $link;
}

add_filter( 'search_link', 'xlt_search_link_filter', 10, 2 );

/**
 * Filters the retrieved list of pages.
 *
 * @param array $pages Array of page objects.
 *
 * @return array
 */
function xlt_set_title_en_pages( $pages ) {

	global $lang;

	if ( 'en' === $lang && ! is_admin() ) {
		foreach ( $pages as $page ) {
			$page->post_title = get_title_en( $page->ID );
		}
	}

	return $pages;
}

add_filter( 'get_pages', 'xlt_set_title_en_pages' );

/**
 * Filters the permalink for page/post.
 *
 * @param string $link The page's permalink.
 * @param int    $post_id The ID of the page.
 *
 * @return string
 */
function xlt_set_url_en( $link, $post_id ) {

	global $lang;

	if ( empty( $post_id ) ) {
		return $link;
	}

	if ( is_admin() ) {
		return $link;
	}

	if ( 'en' === $lang ) {
		return $link . 'en/';
	}

	return $link;
}

add_filter( 'page_link', 'xlt_set_url_en', 10, 2 );
add_filter( 'post_link', 'xlt_set_url_en', 10, 2 );

/**
 * Filters the widget title.
 *
 * @param string $title The widget title.
 * @param array  $instance Array of settings for the current widget.
 *
 * @return string
 */
function xlt_change_widget_title( $title, $instance ) {

	global $lang;

	if ( isset( $instance['nav_menu'] ) && 'Topics' === $instance['title'] && 'it' === $lang ) {
		$title = 'Argomenti';
	}

	if ( isset( $instance['title'] ) && 'Pages' === $instance['title'] && 'it' === $lang ) {
		$title = 'Pagine';
	}

	return $title;
}

add_filter( 'widget_title', 'xlt_change_widget_title', 10, 2 );

/**
 * Add attributes to next post link.
 *
 * @param string $link Next post link.
 *
 * @return string
 */
function xlt_filter_next_post_link( $link ) {

	global $lang;
	$title = 'Post successivo';

	if ( 'en' === $lang ) {
		$title = 'Next post';
	}

	return str_replace(
		'rel=',
		'title="' . $title . '" class="display-5 arrow" rel=',
		$link
	);
}

add_filter( 'next_post_link', 'xlt_filter_next_post_link' );

/**
 * Add attributes to previous post link.
 *
 * @param string $link Previous post link.
 *
 * @return string
 */
function xlt_filter_previous_post_link( $link ) {

	global $lang;
	$title = 'Post precedente';

	if ( 'en' === $lang ) {
		$title = 'Previous post';
	}

	return str_replace(
		'rel=',
		'title="' . $title . '" class="display-5 arrow" rel=',
		$link
	);
}

add_filter( 'previous_post_link', 'xlt_filter_previous_post_link' );

/**
 * Filters the meta title.
 *
 * @param string $title The title.
 *
 * @return string
 */
function xlt_en_title( $title ) {

	global $lang,$post;

	if ( 'en' === $lang ) {

		if ( is_home() || is_front_page() ) {
			$title = get_bloginfo( 'name' ) . ' | Better than a cyber duck.';
		}

		if ( is_singular() && ! is_preview() ) {
			$title = get_title_en( $post->ID ) . ' | ' . get_bloginfo( 'name' );
		}

		if ( is_search() ) {
			$title = 'Search results for: ' . get_search_query() . ' | xlthlx';
		}

		if ( is_search() && is_paged() ) {
			$title = 'Search results for: ' . get_search_query() . ' | Page ' . get_query_var( 'paged' ) . ' | xlthlx';
		}

		if ( is_archive() && is_paged() ) {
			$title =  get_the_archive_title() . ' | Page ' . get_query_var( 'paged' ) . ' | xlthlx';
		}

		if ( is_404() ) {
			$title = 'Page not found | xlthlx';
		}

		if ( is_month() ) {
			$datetime = get_the_time( 'm' ) . '/01/' . get_the_time( 'Y' );
			$title    = date( 'F', strtotime( $datetime ) ) . ' ' . get_the_time( 'Y' ) . ' | xlthlx';
		}
	}

	return $title;
}

add_filter( 'slim_seo_meta_title', 'xlt_en_title' );

/**
 * Filters the meta description.
 *
 * @param string $description The meta description.
 *
 * @return string
 * @throws Exception Exception.
 */
function xlt_en_description( $description ) {

	global $lang;

	if ( 'en' === $lang ) {

		if ( is_home() || is_front_page() ) {
			$description = 'xlthlx. Better than a cyber duck.';
		}

		if ( is_singular() ) {
			$description = wp_trim_excerpt( get_content_en() );
		}

		if ( is_search() ) {
			$description = 'Search results for: ' . get_search_query();
		}
	}

	return $description;
}

add_filter( 'slim_seo_meta_description', 'xlt_en_description' );

/**
 * Join posts and post meta tables for the search results.
 *
 * @param string $join The JOIN clause of the query.
 *
 * @return string
 */
function xlt_search_join_post_meta( $join ) {
	global $wpdb;

	if ( is_search() ) {
		$join .= ' LEFT JOIN ' . $wpdb->postmeta . ' ON ' . $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
	}

	return $join;
}

add_filter( 'posts_join', 'xlt_search_join_post_meta' );

/**
 * Modify the search query to add post meta.
 *
 * @param string $where The WHERE clause of the query.
 *
 * @return string
 */
function xlt_search_where_post_meta( $where ) {
	global $wpdb;

	if ( is_search() ) {
		$where = preg_replace(
			'/\(\s*' . $wpdb->posts . ".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
			'(' . $wpdb->posts . '.post_title LIKE $1) OR (' . $wpdb->postmeta . '.meta_value LIKE $1)',
			$where
		);
	}

	return $where;
}

add_filter( 'posts_where', 'xlt_search_where_post_meta' );

/**
 * Prevent duplicates in the search results.
 *
 * @param string $distinct The DISTINCT clause of the query.
 *
 * @return string
 */
function xlt_search_distinct( $distinct ) {

	if ( is_search() ) {
		return 'DISTINCT';
	}

	return $distinct;
}

add_filter( 'posts_distinct', 'xlt_search_distinct' );

/**
 * Pretty permalink for search.
 *
 * @return void.
 */
function xlt_search_url_rewrite() {
	global $wp_rewrite;
	if ( ! isset( $wp_rewrite ) || ! is_object( $wp_rewrite ) || ! $wp_rewrite->get_search_permastruct() ) {
		return;
	}

	$search_base = $wp_rewrite->search_base;
	$needle      = '/' . $search_base . '/';
	$uri         = $_SERVER['REQUEST_URI'];

	if ( strpos( $uri, $needle ) === false && strpos(
		$uri,
		'&lang=en'
	) !== false ) {

		$search = urlencode( get_query_var( 's' ) );
		$search = str_replace(
			'%2F',
			'/',
			$search
		); // %2F(/) is not valid within a URL, send it un-encoded.

		wp_redirect( home_url() . '/search/' . $search . '/en/' );
		exit();
	}

	if ( is_search() && strpos( $uri, $needle ) === false && strpos(
		$uri,
		'&'
	) === false ) {
		wp_redirect( get_search_link() );
		exit();
	}

}

add_action( 'template_redirect', 'xlt_search_url_rewrite' );

/**
 * Filters the search results.
 *
 * @param object $query The WP_Query instance.
 *
 * @return void.
 */
function xlt_exclude_pages_from_search_results( $query ) {
	if ( $query->is_search() && ! is_admin() ) {
		$query->set( 'post_type', array( 'post' ) );
	}

}

add_action( 'pre_get_posts', 'xlt_exclude_pages_from_search_results' );

/**
 * Adds rewrite rule for English paginated search.
 *
 * @return void
 */
function xlt_rewrite_search_pages_en() {
	add_rewrite_rule(
		'^search/([^/]+)/en/page/([0-9]+)/?$',
		'index.php?s=$matches[1]&lang=en&paged=$matches[2]',
		'top'
	);

	add_rewrite_rule(
		'^film/en/page/([0-9]+)/?$',
		'index.php?pagename=film&lang=en&paged=$matches[1]',
		'top'
	);

	add_rewrite_rule(
		'^tv-series/en/page/([0-9]+)/?$',
		'index.php?pagename=tv-series&lang=en&paged=$matches[1]',
		'top'
	);
}

add_action( 'init', 'xlt_rewrite_search_pages_en' );
