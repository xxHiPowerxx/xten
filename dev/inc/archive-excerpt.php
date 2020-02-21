<?php
/**
 * Replaces the "[...]" at the end of The Excerpt.
 */
function excerpt_ellipsis( $more ) {
	global $post;
	return '<span class="ellipsis">...</span>';
}
add_filter( 'excerpt_more', 'excerpt_ellipsis' );

/**
 * Truncate the Excerpt to a smaller length.
 */
function wp_trim_all_excerpt( $text ) {
	// Creates an excerpt if needed; and shortens the manual excerpt as well.
	global $post;
	$raw_excerpt = $text;
	if ( '' == $text ) {
		$text = get_the_content( '' );
		$text = strip_shortcodes( $text );
		$text = apply_filters( 'the_content', $text );
		$text = str_replace( ']]>', ']]&gt;', $text );
	}

	$text           = strip_tags( $text );
	$excerpt_length = apply_filters( 'excerpt_length', 30 );
	$excerpt_more   = apply_filters( 'excerpt_more', ' [...]' );
	$text           = wp_trim_words( $text, $excerpt_length, $excerpt_more ); // since wp3.3.

	return apply_filters( 'wp_trim_excerpt', $text, $raw_excerpt ); // since wp3.3.
}

remove_filter( 'get_the_excerpt', 'wp_trim_excerpt' );
add_filter( 'get_the_excerpt', 'wp_trim_all_excerpt' );
