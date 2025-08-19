<?php
/**
 * Template part for header.
 *
 * @package  xlthlx
 */

/**
 * Get the description from the post content.
 *
 * @return string
 */
function xlt_get_text() {
    global $post, $site_desc;

    if ( ! is_home() && ! is_front_page() && ! is_archive() ) {

        if ( isset( $post->post_content ) && '' !== trim( $post->post_content ) ) {
            $post_object = get_post( $post );
            $text        = get_the_content( '', false, $post_object );

            $text = strip_shortcodes( $text );
            $text = excerpt_remove_blocks( $text );
            $text = excerpt_remove_footnotes( $text );

            $text = apply_filters( 'the_excerpt', $text );
            $text = str_replace( ']]>', ']]&gt;', $text );
            $text = wp_strip_all_tags( $text );
            $text = html_entity_decode( $text, ENT_HTML5 );
            $text = preg_replace( '/(^|[^\n\r])[\r\n](?![\n\r])/', '$1 ', $text );
            $text = str_replace( '.', '. ', $text );

            if ( strlen( $text ) > 200 ) {
                $text = substr( $text, 0, 200 ) . '...';
            }

            if ( '' === $text ) {
                return html_entity_decode( $site_desc, ENT_HTML5 );
            }

            return $text;
        }
    } else {
        return html_entity_decode( $site_desc, ENT_HTML5 );
    }

    return '';
}

/**
 * Gets the og:image from the post thumbnail.
 *
 * @return false|string
 */
function xlt_get_og_img() {
    global $post;

    if ( ! is_home() && ! is_front_page() && ! is_archive() ) {
        $post_object = get_post( $post );
        return get_the_post_thumbnail_url( $post_object, 'full' );
    }

    return '';
}

global $charset; ?>
<head>
	<meta charset="<?php echo $charset; ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="fediverse:creator" content="@xlthlx@hachyderm.io">
    <meta property="og:description" name="description" content="<?php echo xlt_get_text(); ?>">
    <meta property="og:image" content="<?php echo esc_url( xlt_get_og_img() ); ?>">
	<link rel="author" href="<?php echo get_template_directory_uri(); ?>/humans.txt"/>
    <link rel="canonical" href="<?php echo esc_attr( get_permalink() ); ?>">
	<?php wp_head(); ?>
</head>