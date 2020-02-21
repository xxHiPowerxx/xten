<?php
/**
 * Collection of Shortcodes.
 *
 * @package xten
 */

/**
 * Year shortcode.
 */
function get_year_func() {
	$year = date( 'Y' );
	return $year;
}
add_shortcode( 'year', 'get_year_func' );

/**
 * Facebook shortcode.
 *
 * @param array $atts attributes from shortcode.
 */
function fontawesome_link_shortcode_func( $atts ) {
	$a = shortcode_atts( array(
		'icon'  => 'fas fa-home',
		'url'   => 'http://xxhipowerxx.github.io/xten',
		'color' => '#696B6E',
		'size'  => '2em',
	), $atts );

	$content = '<a class="socia-icon ' . esc_attr( $a['icon'] ) . '" href="' . esc_url( $a['url'] ) . '" style="color:' . esc_attr( $a['color'] ) . ';font-size:' . esc_attr( $a['size'] ) . '"></a>';

	return $content;
}
add_shortcode( 'fontawesome_link', 'fontawesome_link_shortcode_func' );

/**
 * Text Modification shortcode.
 *
 * @param array $atts attributes from shortcode.
 */
function text_modification_shortcode_func( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'size'  => '',
		'color'   => '',
	), $atts );

	$styles = '';
	$class  = '';

	if ( $a['size'] ) :
		$styles = 'font-size:' . esc_attr( preg_replace( "/&#?[a-z0-9]+;/i",'', $a['size'] ) ) . ';';
	endif;

	if ( $a['color'] ) :
		$class = 'has-' . esc_attr( preg_replace( "/&#?[a-z0-9]+;/i",'', $a['color'] ) ) . '-color';
	endif;


	return '<span class="' . $class . '" style="' . $styles . '">' . $content . '</span>';
}
add_shortcode( 'text_mod', 'text_modification_shortcode_func' );
