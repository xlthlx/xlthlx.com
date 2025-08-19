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
    global $post;

    if ( isset( $post->post_content ) && '' !== trim( $post->post_content ) ) {
        $post_desc = get_post( $post );
        $text      = get_the_content( '', false, $post_desc );

        $text = strip_shortcodes( $text );
        $text = excerpt_remove_blocks( $text );
        $text = excerpt_remove_footnotes( $text );

        $filter_image_removed = remove_filter( 'the_content', 'wp_filter_content_tags', 12 );
        $filter_block_removed = remove_filter( 'the_content', 'do_blocks', 9 );

        $text = apply_filters( 'the_excerpt', $text );
        $text = str_replace( ']]>', ']]&gt;', $text );
        $text = wp_strip_all_tags( $text );

        if ( $filter_block_removed ) {
            add_filter( 'the_content', 'do_blocks', 9 );
        }
        if ( $filter_image_removed ) {
            add_filter( 'the_content', 'wp_filter_content_tags', 12 );
        }

        if ( strlen( $text ) > 200 ) {
            $text = substr( $text, 0, 200 );
        }

        return $text;
    }

    return '';
}

global $charset; ?>
<head>
	<meta charset="<?php echo $charset; ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="fediverse:creator" content="@xlthlx@hachyderm.io">
    <meta property="og:description" name="description" content="<?php echo xlt_get_text(); ?>">
	<link rel="author" href="<?php echo get_template_directory_uri(); ?>/humans.txt"/>
    <link rel="canonical" href="<?php echo esc_attr( get_permalink() ); ?>">
	<?php wp_head(); ?>
</head>